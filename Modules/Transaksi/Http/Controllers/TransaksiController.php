<?php

namespace Modules\Transaksi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use DataTables;
use Illuminate\Support\Facades\Redis;
use PDF;

class TransaksiController extends Controller
{

    public function index()
    {
        return view('main::index', [
            'title' => 'Transaksi',
            'content' => view('transaksi::index')
        ]);
    }

    public function countTransaksi()
    {
        $session = session()->get('userdata');

        $operation = DB::table('tb_transaksi')->where('transaksi_tanggal', 'LIKE', '%' . date('Y-m-d') . '%')->count();
        $data['kode_transaksi'] = (int)date('Ymd') . $operation + 1;

        $getTotal = DB::table('tb_keranjang')->where([
            ['keranjang_user_id', $session['user_id']],
            ['keranjang_transaksi_status', 1],
        ])->sum('keranjang_subtotal');
        $data['grandtotal'] = $getTotal;

        return $data;
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('v_keranjang')->where([
                ['keranjang_active', 1],
                ['keranjang_transaksi_status', 1],
            ])->get()->toArray();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->keranjang_id;
                    $btn = '<div >
                                        <a href="#" onclick="onPlusQty(this)" data-id="' . $id . '" data-produk_id="' . $row->keranjang_produk_id . '" data-qty="' . $row->keranjang_qty . '" title="Tambah Qty" class="btn btn-primary btn-sm"><i class="align-middle fa fa-plus fw-light text-whitw"> </i></a>
                                        <a href="#" onclick="onMinusQty(this)" data-id="' . $id . '" data-produk_id="' . $row->keranjang_produk_id . '" data-qty="' . $row->keranjang_qty . '" title="Kurang Qty" class="btn btn-primary btn-sm"><i class="align-middle fa fa-minus fw-light text-whitw"> </i></a>
                                        <a href="#" onclick="onDelete(this)" data-id="' . $id . '" data-produk_id="' . $row->keranjang_produk_id . '" data-qty="' . $row->keranjang_qty . '" title="Delete Data" class="btn btn-danger btn-sm"><i class="align-middle fa fa-trash fw-light"> </i></a>
                                </div>
                                ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('transaksi.index');
    }

    public function search(Request $request)
    {
        $data = $request->input();
        $operation = DB::table('tb_produk')->where('produk_kode', 'LIKE', '%' . $data['produk_kode'] . '%')->where('produk_active', 1)->limit(5)->get()->toArray();
        $result = convertArray($operation);
        return $result;
    }

    public function addCart(Request $request)
    {
        $session = session()->get('userdata');
        $data = $request->input();

        $operationProduk = DB::table('tb_produk')->where('produk_id', $data['keranjang_produk_id'])->get()->toArray();
        $produk = convertArray($operationProduk);

        if ((int)$produk[0]['produk_stok'] >= (int)$data['keranjang_qty']) {

            $harga =  (int)$produk[0]['produk_harga_jual'] * (int)$data['keranjang_qty'];

            $data['keranjang_id'] = uniqid();
            $data['keranjang_user_id'] = $session['user_id'];
            $data['keranjang_subtotal'] = $harga;
            $data['keranjang_active'] = 1;
            $data['keranjang_transaksi_status'] = 1;
            $qtyNew = (int)$produk[0]['produk_stok'] - (int)$data['keranjang_qty'];
            $sellNew = (int)$produk[0]['produk_terjual'] + (int)$data['keranjang_qty'];
            $dataU['produk_terjual'] = $sellNew;
            $dataU['produk_stok'] = $qtyNew;
            $updateData = DB::table('tb_produk')->where('produk_id', $data['keranjang_produk_id'])->update($dataU);

            if ($updateData) {
                $operation = DB::table('tb_keranjang')->insert($data);
                if ($operation == 1) {
                    $response['success'] = true;
                    $response['title'] = 'Success';
                    $response['message'] = 'Berhasil Menambahkan Data';
                } else {
                    $response['success'] = false;
                    $response['title'] = 'Failed';
                    $response['message'] = 'Gagal Mengubah Data!';
                }
            }

        } else {
            $response['success'] = false;
            $response['title'] = 'Failed';
            $response['message'] = 'Stok tidak mencukupi!';
        }
        return $response;
    }

    public function plusQty(Request $request)
    {
        $data = $request->input();

        $operationProduk = DB::table('tb_produk')->where('produk_id', $data['produk_id'])->get()->toArray();
        $produk = convertArray($operationProduk);

        $operationKeranjang = DB::table('tb_keranjang')->where('keranjang_id', $data['keranjang_id'])->get()->toArray();
        $keranjang = convertArray($operationKeranjang);

        $qtyNew = (int)$keranjang[0]['keranjang_qty'] + 1;

        if ((int)$produk[0]['produk_stok'] >= $qtyNew) {
            // data update produk
            $stokNew = (int)$produk[0]['produk_stok'] - 1;
            $sellNew = (int)$produk[0]['produk_terjual'] + 1;
            $dataUP['produk_terjual'] = $sellNew;
            $dataUP['produk_stok'] = $stokNew;

            // data update keranjang
            $dataUK['keranjang_qty'] = $qtyNew;
            $dataUK['keranjang_subtotal'] = $produk[0]['produk_harga_jual'] * $qtyNew;

            $updateData = DB::table('tb_produk')->where('produk_id', $data['produk_id'])->update($dataUP);

            if ($updateData) {
                $operation = DB::table('tb_keranjang')->where('keranjang_id', $data['keranjang_id'])->update($dataUK);
                if ($operation == 1) {
                    $response['success'] = true;
                } else {
                    $response['success'] = false;
                }
            }
        }else{
            $response['success'] = false;
            $response['title'] = 'Failed';
            $response['message'] = 'Stok tidak mencukupi!';
        }
        return $response;
    }

    public function minusQty(Request $request)
    {
        $data = $request->input();

        $operationProduk = DB::table('tb_produk')->where('produk_id', $data['produk_id'])->get()->toArray();
        $produk = convertArray($operationProduk);

        $operationKeranjang = DB::table('tb_keranjang')->where('keranjang_id', $data['keranjang_id'])->get()->toArray();
        $keranjang = convertArray($operationKeranjang);

        // data update produk
        $stokNew = (int)$produk[0]['produk_stok'] + 1;
        $sellNew = (int)$produk[0]['produk_terjual'] - 1;
        $dataUP['produk_terjual'] = $sellNew;
        $dataUP['produk_stok'] = $stokNew;

        // data update keranjang
        $qtyNew = (int)$keranjang[0]['keranjang_qty'] - 1;
        $dataUK['keranjang_qty'] = $qtyNew;
        $dataUK['keranjang_subtotal'] = $produk[0]['produk_harga_jual'] * $qtyNew;


        $updateData = DB::table('tb_produk')->where('produk_id', $data['produk_id'])->update($dataUP);

        if ($updateData) {
            $operation = DB::table('tb_keranjang')->where('keranjang_id', $data['keranjang_id'])->update($dataUK);
            if ($operation == 1) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }
        }

        return $response;
    }

    public function destroy(Request $request)
    {
        $data = $request->input();

        $operationProduk = DB::table('tb_produk')->where('produk_id', $data['produk_id'])->get()->toArray();
        $produk = convertArray($operationProduk);

        // data update produk
        $stokNew = (int)$produk[0]['produk_stok'] + (int)$data['keranjang_qty'];
        $sellNew = (int)$produk[0]['produk_terjual'] - (int)$data['keranjang_qty'];
        $dataUP['produk_terjual'] = $sellNew;
        $dataUP['produk_stok'] = $stokNew;

        $updateData = DB::table('tb_produk')->where('produk_id', $data['produk_id'])->update($dataUP);

        if ($updateData) {
            $operation = DB::table('tb_keranjang')->where('keranjang_id', $data['keranjang_id'])->delete();
            if ($operation == 1) {
                $response['success'] = true;
                $response['title'] = 'Success';
                $response['message'] = 'Berhasil Menambahkan Data';
            } else {
                $response['success'] = false;
                $response['title'] = 'Failed';
                $response['message'] = 'Gagal Mengubah Data!';
            }
        }
        return $response;
    }

    public function bayar(Request $request)
    {
        $session = session()->get('userdata');
        $data = $request->input();

        $data['transaksi_id'] = uniqid();
        $data['transaksi_user_id'] = $session['user_id'];
        $data['transaksi_active'] = 1;
        $data['transaksi_status'] = 1;
        $data['transaksi_tanggal'] = date('Y-m-d H:i:s');

        $operation = DB::table('tb_transaksi')->insert($data);

        if ($operation) {
            $response['success'] = true;
            $response['title'] = 'Success';
            $response['message'] = 'Transaksi Berhasil !';
        } else {
            $response['success'] = false;
            $response['title'] = 'Failed';
            $response['message'] = 'Transaksi Gagal !';
        }

        return $response;
    }

    public function truncateCart(Request $request)
    {
        $session = session()->get('userdata');
        $dataUK['keranjang_transaksi_status'] = 0;
        $deleteCart = DB::table('tb_keranjang')->where('keranjang_user_id', $session['user_id'])->update($dataUK);
        return $deleteCart;
    }

    // Script Lama

    // public function cetak(Request $request)
    // {
    //     $session = session()->get('userdata');

    //     $operationKeranjang = DB::table('v_keranjang')->where('keranjang_user_id', $session['user_id'])->get()->toArray();
    //     $keranjang = convertArray($operationKeranjang);


    //     $customPaper = array(0, 0, 219, 'auto');
    //     $pdf = PDF::loadview('transaksi::struk', ['keranjang' => $keranjang]);
    //     $output =  $pdf->output();

    //     return new Response($output, 200, [
    //         'Content-Type' => 'application/pdf',
    //         // 'Content-Disposition' =>  'inline',
    //         'filename' => "'strukNota.pdf'"
    //     ]);
    // }

    // Script Baru 

    public function cetak(Request $request)
    {
        $session = session()->get('userdata');

        $operationTransaksi = DB::table('tb_transaksi')->where([
            ['transaksi_no', $request->input('transaksi_no')],
            ['transaksi_active', 1],
        ])->get()->toArray();
        $transaksi = convertArray($operationTransaksi);

        $operationKeranjang = DB::table('v_keranjang')->where([
            ['keranjang_user_id', $session['user_id']],
            ['keranjang_transaksi_status', 1],
        ])->get()->toArray();
        $keranjang = convertArray($operationKeranjang);
        $html = '';

        $html .= '<div style="font-family: Calibri, sans-serif; width: 58mm ; font-size: 14px; line-height: 0.8;" >'
            . '<div>'
            . '<table align="center" style="margin-bottom: 10px;">'
            . '<tr>'
            . '<td align="center" style="font-size: 24px;">Si <span style="font-weight: 600">Kato</span></td>'
            . '</tr>'
            // .'<tr>'
            //     .'<td align="center">'. $data['config'][0]['conf_value'].'</td>'
            // .'</tr>'
            // .'<tr>'
            //     .'<td align="center">'. $data['config'][1]['conf_value'].'</td>'
            // .'</tr>'
            . '</table>'
            . '</div>'
            . '<div>'
            . '<table>'
            . '<tr>'
            . '<td> ' . date("d M Y   -   H:i:s", strtotime($transaksi[0]['transaksi_tanggal'])) . ' </td>'
            . '</tr>'
            . '<tr>'
            . '<td>No. Nota </br>' . $transaksi[0]['transaksi_no'] . ' </td>'
            . '</tr>'
            // .'<tr>'
            // 	.'<td>Kasir : &nbsp;&nbsp;&nbsp; '. $this->session->userdata('user_nama') .'</td>'
            // .'</tr>'
            . '</table>'
            . '</div>'
            . '<span text-align: justify;">=======================================</span>'
            . '<div>'
            // 	.'<div>';
            // 		$no = 1;
            // 		foreach ($data['struk'] as $bi => $bv) {
            // 		$html .= '<span style="width:100%">'.$bv['produk_nama'].'</span>'
            // 		.'<div>'
            // 			.'<span width="110px">'.$bv['keranjang_qty'].$bv['satuan_kode'].' </span>'
            // 			.'<span width="50px">X &nbsp;'.$bv['produk_harga_jual'].' </span>'
            // 			.'<span width="40px">=</span>'
            // 			.'<span width="40px">'.$bv['keranjang_subtotal'].'</span>'
            // 		.'</div>';
            // 		}
            // $html.='</div>'
            . '<table >';

        $no = 1;
        foreach ($keranjang as $bi => $bv) {

            $html .=    '<tr>'
                . '<td width="200px">' . $bv['produk_nama'] . '</td>'
                . '</tr>'
                . '<tr >'
                . '<td width="70px">' . $bv['keranjang_qty'] . $bv['satuan_kode'] . '</td> '
                . '<td width="80px">X &nbsp;' . $bv['produk_harga_jual'] . '</td>'
                . '<td width="30px"> = </td>'
                . '<td width="80px">' . $bv['keranjang_subtotal'] . '</td>'
                . '</tr>';
        }
        $html .= '<tr>'

            . '</tr>'
            . '</table>'
            . '</div>'
            . '<span text-align: justify; font-weight:500">=======================================</span>'

            . '<div>'
            . '<table>'
            . '<tr>'
            // .'<td width="10px">&nbsp;</td>'
            . '<td width="50px">TOTAL &nbsp;&nbsp:</td>'
            . '<td width="30px" style="float:right;">' . number_format($transaksi[0]['transaksi_total_bayar'], 2, ',', '.') . '</td>'
            . '</tr>'
            . '<tr>'
            // .'<td width="50px">&nbsp;</td>'
            . '<td width="30px">TUNAI &nbsp;&nbsp;: </td>'
            . '<td width="30px" style="float:right;">' . number_format($transaksi[0]['transaksi_jumlah_uang'], 2, ',', '.') . '</td>'
            . '</tr>'

            . '<tr>'
            // .'<td width="10px">&nbsp;</td>'
            . '<td width="100px">KEMBALIAN : </td>'
            . '<td width="30px" style="float:right;">' . number_format($transaksi[0]['transaksi_kembalian'], 2, ',', '.') . '</td>'
            . '</tr>'
            . '</table>'
            . '</div>'
            . '<span text-align: justify; font-weight:500">=======================================</span>'

            . '<table align="center">'
            . '<tr align="center">'
            . '<td align="center" style="font-size: 14px">'
            . 'Terima Kasih Atas Kunjungan Anda'
            . '</td>'
            . '</tr>'
            . '<tr align="center">'
            . '<td align="center">'
            . 'Layanan Telp'
            . '</td>'
            . '</tr>'
            . '<tr align="center" style="margin-bottom: 10px">'
            . '<td align="center">'
            // .$data['config'][2]['conf_value']
            . '</td>'
            . '</tr>'
            . '</table>'
            . '</div>';
        // dd($html);
        return ($html);
    }
}
