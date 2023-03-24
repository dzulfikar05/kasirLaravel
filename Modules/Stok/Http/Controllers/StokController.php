<?php

namespace Modules\Stok\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB; 

use DataTables;

class StokController extends Controller
{
    public function index()
    {
        return view('main::index', [
            'title' => 'Stok',
            'content' => view('stok::index')
        ]);
    }

    public function store(Request $request)
    {
        $response = [];

        $data = $request->input();
        $data['stok_id'] = uniqid();
        $data['stok_tanggal'] = date("Y-m-d", strtotime($data['stok_tanggal']));

        $operation = DB::table('tb_stok')->insert($data);
        if ($operation == 1) {
            $operationProduk = DB::table('tb_produk')->where('produk_id', $data['stok_produk_id'])->get()->toArray();
            $produk = convertArray($operationProduk);

            // data update produk
            $stokNew = '';
            if($data['stok_kategori'] == 1){
                $stokNew .= (int)$produk[0]['produk_stok'] + (int)$data['stok_jumlah'];
            }else{
                $stokNew .= (int)$produk[0]['produk_stok'] - (int)$data['stok_jumlah'];
            }
            
            $dataUP['produk_stok'] = $stokNew;

            if(isset($data['stok_produk_beban'])){
                $harga1 = (int)$produk[0]['produk_harga'] * (int)$data['stok_produk_beban'];
                $harga2 = (int)$harga1 / 100;
                $harga = (int)$produk[0]['produk_harga'] + (int)$harga2;
                $dataUP['produk_beban'] = $data['stok_produk_beban'];
                $dataUP['produk_harga_jual'] = $harga;
            }

            $updateData = DB::table('tb_produk')->where('produk_id', $data['stok_produk_id'])->update($dataUP);
            if($updateData){
                $response['success'] = true;
                $response['title'] = 'Success';
                $response['message'] = 'Berhasil Menambahkan Data';
            }
        } else {
            $response['success'] = false;
            $response['title'] = 'Failed';
            $response['message'] = 'Gagal Mengubah Data!';
        }

        return $response;
    }

    public function getOldData(Request $request)
    {
        $id = $_POST;

        $operation = DB::table('tb_produk')->where('produk_id', $id)->get()->toArray();
        return convertArray($operation[0]);
    }
}
