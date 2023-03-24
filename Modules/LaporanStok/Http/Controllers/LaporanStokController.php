<?php

namespace Modules\LaporanStok\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB; 

use DataTables;
class LaporanStokController extends Controller
{
    public function index()
    {
        return view('main::index', [
            'title' => 'Laporan Stok',
            'content' => view('laporanstok::index')
        ]);
    }

    public function initTable(Request $request) 
    {
        $startDate = $request->Input('startDate');
        $endDate = $request->Input('endDate');

        if ($request->ajax()) {
            $data = DB::table('v_stok')->where([
                ['stok_kategori', $request->input('stok_kategori')],
            ])->get()->toArray();

            if(isset($startDate) || isset($endDate)){
                $data = DB::table('v_stok')->where([
                    ['stok_kategori', $request->input('stok_kategori')],
                ])->whereBetween('stok_tanggal', [date("Y-m-d H:i:s", strtotime($startDate . ' 00:00:00')), date("Y-m-d H:i:s", strtotime($endDate. ' 23:59:59'))])->orderBy('stok_tanggal', 'desc')->get()->toArray();
            }else{
                $data = DB::table('v_stok')->where([
                    ['stok_kategori', $request->input('stok_kategori')],
                ])->orderBy('stok_tanggal', 'desc')->get()->toArray();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $id = $row->stok_id;
                    $btn = '<div >
                                        <a href="#" onclick="onCetak(this)" data-no="' . $id . '" title="Cetak Invoice" class="btn btn-primary btn-sm"><i class="align-middle fa fa-print me-1 fs-5 fw-light text-white"> </i>Cetak</a>
                                </div>
                                ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('laporanstok.index');
    }

    public function cetakLaporan(Request $request)
    {
        $html = '';
        $startDate = $request->Input('startDate');
        $endDate = $request->Input('endDate');
        $kategori = '';
        if($request->input('stok_kategori') == 1){
            $kategori .= 'Masuk'; 
        }else{
            $kategori .= 'Keluar'; 
        }

        if(isset($startDate) || isset($endDate)){
            $operationStok = DB::table('v_stok')->where([
                ['stok_kategori', $request->input('stok_kategori')],
            ])->whereBetween('stok_tanggal', [date("Y-m-d H:i:s", strtotime($startDate . ' 00:00:00')), date("Y-m-d H:i:s", strtotime($endDate. ' 23:59:59'))])->get()->toArray();
        }else{
            $operationStok = DB::table('v_stok')->where([
                ['stok_kategori', $request->input('stok_kategori')],
            ])->get()->toArray();
        }

        $data['stok'] = convertArray($operationStok);

        $html .= '<div style="font-family: Arial, Helvetica, sans-serif; align-items: center">'
                    .'<div style="width: 100%">'
                        .'<table align="center" style="margin-bottom: 10px; border: none">'
                            .'<tr>'
                                .'<td align="center" style="font-size: 25px; border: none">Si <span style="font-weight: 600">Kato</span></td>'
                            .'</tr>'
                            .'<tr>'
                                .'<td align="center" style="font-size: 30px; border: none; font-weight:600">Laporan Stok '.$kategori.'</td>'
                            .'</tr>'
                        .'</table>'
                    .'</div></br></br></br>';

       
        // print_r($data['stok']); exit;
        $tS = $startDate ? date('d/m/Y', strtotime($startDate)): '( - )';
        $tE = $endDate ? date('d/m/Y', strtotime($endDate)) : '( - )';


        $html .= '<div style="margin-left:55px;">'
                    .'<span style="font-size: 16px; padding: 20px;">Laporan stok '.$kategori.' mulai dari tanggal '.$tS.' s/d '.$tE.'</span></br>'
                .'</div> </br>' ;

        $html .= '<table style="border:1px solid black; border-collapse:collapse;margin-left:55px;" class="table table-bordered table-striped">'
                    .'<thead >'
                        .'<tr style="background-color: #f2f2f2 !important; height: 30px" >'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="50px">No</th>'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="250px">Tanggal</th>'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="200px">Produk</th>'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="200px">Label</th>'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="175px">Jumlah</th>'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="200px">Keterangan</th>'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="200px">Supplier</th>'
                        .'</tr>'
                    .'</thead>'
                    .'<tbody>';

        $no = 1;
        foreach($data['stok'] as $dti => $dtv){

            $html .= '<tr>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" > &nbsp&nbsp &nbsp&nbsp&nbsp'.$no++.'</td>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp&nbsp'. date("d/m/Y", strtotime($dtv['stok_tanggal'])) .'</td>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp&nbsp'. $dtv['produk_kode'].'</br>&nbsp&nbsp'.$dtv['produk_nama'].'</td>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp&nbsp'. $dtv['stok_label'].'</td>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp&nbsp'. $dtv['stok_jumlah'].'</td>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp&nbsp'. $dtv['stok_keterangan'].'</td>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp&nbsp'. $dtv['supplier_nama'].'</td>'
                    .'</tr>';
        }
        $html .= '</tbody>'
                .'</table>'
                .'</div>';
        return($html);
    }

    public function cetakInvoice(Request $request)
    {
        $html = '';
        $data = $request->input();
        $operation = DB::table('v_stok')->where([
            ['stok_id', $data['stok_id']],
        ])->get()->toArray();
        $result = convertArray($operation[0]);
        
        $html .= '<div style="font-family: Arial, Helvetica, sans-serif; align-items: center">'
                    .'<div style="width: 100%">'
                        .'<table align="center" style="margin-bottom: 10px; border: none">'
                            .'<tr>'
                                .'<td align="center" style="font-size: 25px; border: none">Si <span style="font-weight: 600">Kato</span></td>'
                            .'</tr>'
                            .'<tr>'
                                .'<td align="center" style="font-size: 30px; border: none; font-weight:600">Invoice</td>'
                            .'</tr>'
                        .'</table>'
                    .'</div></br></br></br>';

        $html .= '<div style="margin-left:55px;">'
                    .'<span style="font-size: 16px; padding: 20px;">Tanggal Invoice : '.date('d m Y', strtotime($result['stok_tanggal'])).'</span></br>'
                .'</div> </br>' ;
        $html .= '<div style="margin-left:55px;">'
                    .'<span style="font-size: 16px; padding: 20px;">Supplier : '.$result['supplier_nama'].'</span></br>'
                .'</div> </br>' ;

        $html .= '<table style="border:1px solid black; border-collapse:collapse;margin-left:55px;" class="table table-bordered table-striped">'
                    .'<thead >'
                        .'<tr style="background-color: #f2f2f2 !important; height: 30px" >'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="200px">Kode Produk</th>'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="200px">Nama Produk</th>'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="175px">Jumlah</th>'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="200px">Beban Produk</th>'
                            .'<th style="border:1px solid black; border-collapse:collapse" width="200px">Keterangan</th>'
                        .'</tr>'
                    .'</thead>';
        
        $beban='';
        if($result['stok_produk_beban'] == '' || $result['stok_produk_beban'] == null){
            $beban .= '0e';
        }else{
            $beban .= $result['stok_produk_beban'];
        }
        $html .= '<tbody>'
                    .'<tr>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp;&nbsp;'. $result['produk_kode'].'</td>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp;&nbsp;'. $result['produk_nama'].'</td>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp;&nbsp;'. $result['stok_jumlah'].'</td>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp;&nbsp;'. $beban .' %</td>'
                        .'<td style="border:1px solid black; border-collapse:collapse; height:40px" >&nbsp;&nbsp;'. $result['stok_keterangan'].'</td>'
                    .'</tr>'
                .'</tbody>';
        $html .= '</table>'
                .'<table style="align-items: center;margin-left:55px;">'
                    .'<tr style="align-items: center; height: 500px ">'
                        .'<td width="500px" style="align-items: center; text-align: center;">'
                            .$result['supplier_nama'].'</br>(&nbsp;&nbsp; Supplier &nbsp;&nbsp; )'
                        .'</td>'
                        .'<td width="500px" style="align-items: center; text-align: center;">'
                            .'(&nbsp;&nbsp; Admin &nbsp;&nbsp; )'
                        .'</td>'
                    .'</tr>'
                .'</table>'
                .'</div>';
        return($html);
    }
}
