<?php

namespace Modules\LaporanTransaksi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB; 

use DataTables;
use Symfony\Component\Console\Input\Input;

class LaporanTransaksiController extends Controller
{
    public function index()
    {
        return view('main::index', [
            'title' => 'Laporan Transakasi',
            'content' => view('laporantransaksi::index')
        ]);
        // return view('dashboard::index');
    }

    public function initTable(Request $request)
    {
        $startDate = $request->Input('startDate');
        $endDate = $request->Input('endDate');
        
        if ($request->ajax()) {
            if(isset($startDate) || isset($endDate)){
                $data = DB::table('v_laporantransaksi')->select(DB::raw("(sum(transaksi_total_bayar)) as income, transaksi_tanggal"))->where([
                    ['transaksi_active', 1],
                ])->groupBy(DB::raw("DATE_FORMAT(transaksi_tanggal, '%Y-%m-%d')"))->whereBetween('transaksi_tanggal', [date("Y-m-d H:i:s", strtotime($startDate . ' 00:00:00')), date("Y-m-d H:i:s", strtotime($endDate. ' 23:59:59'))])->orderBy('transaksi_tanggal', 'desc')->get()->toArray();
            }else{
                $data = DB::table('v_laporantransaksi')->select(DB::raw("(sum(transaksi_total_bayar)) as income, transaksi_tanggal"))->where([
                    ['transaksi_active', 1],
                ])->groupBy(DB::raw("DATE_FORMAT(transaksi_tanggal, '%Y-%m-%d')"))->orderBy('transaksi_tanggal', 'desc')->get()->toArray();
            }
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $id = date('Y-m-d', strtotime($row->transaksi_tanggal));
                    $btn = '<div >
                                        <a href="#" onclick="onDetail(this)" data-date="' . $id . '" title="Detail Transaksi" class="btn btn-warning btn-sm"><i class="align-middle fa fa-eye fs-5 fw-light text-dark"> </i></a>
                                </div>
                                ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('kategorilowongan.index');
    }

    public function totalPendapatan(Request $request)
    {
        $startDate = $request->Input('startDate');
        $endDate = $request->Input('endDate');
        
        if(isset($startDate) || isset($endDate)){
            $data = DB::table('v_laporantransaksi')->select(DB::raw("(sum(transaksi_total_bayar)) as income, transaksi_tanggal"))->where([
                ['transaksi_active', 1],
            ])->whereBetween('transaksi_tanggal', [date("Y-m-d H:i:s", strtotime($startDate . ' 00:00:00')), date("Y-m-d H:i:s", strtotime($endDate. ' 23:59:59'))])->get()->toArray();
        }else{
            $data = DB::table('v_laporantransaksi')->select(DB::raw("(sum(transaksi_total_bayar)) as income, transaksi_tanggal"))->where([
                ['transaksi_active', 1],
            ])->get()->toArray();
        }
        
        return $data;
    }

    public function detail(Request $request) 
    {
        if ($request->ajax()) {
            $data = DB::table('v_laporantransaksi')->where([
                ['transaksi_tanggal','LIKE','%'.$request->input('date').'%'],
            ])->get()->toArray();

            // print_r('<pre>'); print_r($request->input('date')); print_r('</pre>');exit;
            // print_r('<pre>'); print_r($data); print_r('</pre>');exit;
                            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $id = $row->transaksi_no;
                    $btn = '<div >
                                        <a href="#" onclick="onCetak(this)" data-no="' . $id . '" title="Cetak Nota" class="btn btn-primary btn-sm"><i class="align-middle fa fa-print me-1 fs-5 fw-light text-white"> </i>Cetak</a>
                                </div>
                                ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('kategorilowongan.index');
    }

    public function cetak(Request $request)
    {
        $operationTransaksi = DB::table('tb_transaksi')->where([
            ['transaksi_no', $request->input('transaksi_no')],
            ['transaksi_active', 1],
        ])->get()->toArray();
        $transaksi = convertArray($operationTransaksi);

        $operationKeranjang = DB::table('v_keranjang')->where([
            ['keranjang_transaksi_no', $request->input('transaksi_no')],
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
            // 			.'<span width="50px">X &nbsp;'.$bv['produk_harga'].' </span>'
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

    public function cetakLaporan(Request $request)
    {
        $html = '';
        $startDate = $request->Input('startDate');
        $endDate = $request->Input('endDate');

        if(isset($startDate) || isset($endDate)){
            $operationTransaksi = DB::table('v_laporantransaksi')->select(DB::raw("(sum(transaksi_total_bayar)) as income, transaksi_tanggal"))->where([
                ['transaksi_active', 1],
            ])->groupBy(DB::raw("DATE_FORMAT(transaksi_tanggal, '%Y-%m-%d')"))->whereBetween('transaksi_tanggal', [date("Y-m-d H:i:s", strtotime($startDate . ' 00:00:00')), date("Y-m-d H:i:s", strtotime($endDate. ' 23:59:59'))])->orderBy('transaksi_tanggal', 'desc')->get()->toArray();
        }else{
            $operationTransaksi = DB::table('v_laporantransaksi')->select(DB::raw("(sum(transaksi_total_bayar)) as income, transaksi_tanggal"))->where([
                ['transaksi_active', 1],
            ])->groupBy(DB::raw("DATE_FORMAT(transaksi_tanggal, '%Y-%m-%d')"))->orderBy('transaksi_tanggal', 'desc')->get()->toArray();
        }

        if(isset($startDate) || isset($endDate)){
            $operationCountTransaksi = DB::table('v_laporantransaksi')->select(DB::raw("(sum(transaksi_total_bayar)) as income, transaksi_tanggal"))->where([
                ['transaksi_active', 1],
            ])->whereBetween('transaksi_tanggal', [date("Y-m-d H:i:s", strtotime($startDate . ' 00:00:00')), date("Y-m-d H:i:s", strtotime($endDate. ' 23:59:59'))])->orderBy('transaksi_tanggal', 'desc')->get()->toArray();
        }else{
            $operationCountTransaksi = DB::table('v_laporantransaksi')->select(DB::raw("(sum(transaksi_total_bayar)) as income, transaksi_tanggal"))->where([
                ['transaksi_active', 1],
            ])->orderBy('transaksi_tanggal', 'desc')->get()->toArray();
        }

        $data['transaksi'] = convertArray($operationTransaksi);
        $data['total_transaksi'] = convertArray($operationCountTransaksi);

        $html .= '<div style="font-family: Arial, Helvetica, sans-serif; align-items: center">'
                    .'<div style="width: 100%">'
                        .'<table align="center" style="margin-bottom: 10px; border: none">'
                            .'<tr>'
                                .'<td align="center" style="font-size: 25px; border: none">Si <span style="font-weight: 600">Kato</span></td>'
                            .'</tr>'
                            .'<tr>'
                                .'<td align="center" style="font-size: 30px; border: none; font-weight:600">Laporan Penjualan</td>'
                            .'</tr>'
                        .'</table>'
                    .'</div></br></br></br>';

       
        // print_r($data['transaksi']); exit;
        $tS = $startDate ? date('d/m/Y', strtotime($startDate)): '( - )';
        $tE = $endDate ? date('d/m/Y', strtotime($endDate)) : '( - )';

        $totalIn = "Rp " . number_format($data['total_transaksi'][0]['income'],2,',','.');

        $html .= '<div style="margin-left:55px;">'
                    .'<span style="font-size: 16px; padding: 20px;">Laporan penjualan mulai dari tanggal '.$tS.' s/d '.$tE.'</span></br>'
                    .'<span style="font-size: 16px; padding: 20px;">Total Pendapatan : '.$totalIn.'</span>'
                .'</div> </br>' ;

        $html .= '<table style="border:1px solid black; border-collapse:collapse;margin-left:55px;" class="table table-bordered table-striped">'
                    .'<thead >'
                        .'<tr style="background-color: #f2f2f2 !important; height: 30px" >'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="50px">No</th>'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="230px">Tanggal</th>'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="400px">Total Pendapatan</th>'
                            // .'<th style="border:1px solid black; border-collapse:collapse" width="200px">Kasir</th>'
                        .'</tr>'
                    .'</thead>'
                    .'<tbody>';

        $no = 1;
        foreach($data['transaksi'] as $dti => $dtv){

            $html .= '<tr>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" > &nbsp&nbsp &nbsp&nbsp&nbsp'.$no++.'</td>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp&nbsp'. date("d/m/Y", strtotime($dtv['transaksi_tanggal'])) .'</td>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp&nbsp Rp '. number_format($dtv['income'],2,',','.') .'</td>'
                        // .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp&nbsp'. $dtv['user_nama'] .'</td>'
                    .'</tr>';
        }
        $html .= '</tbody>'
                .'</table>'
                .'</div>';

        // print_r('<pre>'); print_r($html); print_r('</pre>');exit;

        return($html);
    }

}
