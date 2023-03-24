<?php

namespace Modules\Produk\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage;
use App\Imports\ImportProduk;
use Maatwebsite\Excel\Facades\Excel;

use DataTables;

class ProdukController extends Controller
{
    public function index()
    {
        return view('main::index',[
			'title' => 'Produk',
			'content' => view('produk::index')
		]);
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('v_produk')->where([
                    ['produk_deleted_at', null], 
                ])->get()->toArray();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $id = $row->produk_id;
                           $btn = '<div >
                                        <a href="#" onclick="onEdit(this)" data-id="'.$id.'" title="Edit Data" class="btn btn-warning btn-sm"><i class="align-middle fa fa-pencil fw-light text-dark"> </i></a>
                                        <a href="#" onclick="onDelete(this)" data-id="'.$id.'" title="Delete Data" class="btn btn-danger btn-sm"><i class="align-middle fa fa-trash fw-light"> </i></a>
                                </div>
                                ';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
       
        return view('produk.index');
    }

    public function store(Request $request){
        $response=[];

        $data = $request->input();
       
        $image = $request->file('produk_photo');

        $harga1 = (int)$data['produk_harga'] * (int)$data['produk_beban'];
        $harga2 = (int)$harga1 / 100;
        $harga = (int)$data['produk_harga'] + (int)$harga2;

        $data['produk_id'] = uniqid();
        $data['produk_stok'] = 0;
        $data['produk_terjual'] = 0;
        $data['produk_harga_jual'] = $harga;
        $data['produk_created_at'] = date('Y-m-d H:i:s');

        if(isset($data['produk_active'])){
            $data['produk_active'] = 1;
        }else{
            $data['produk_active'] = 0;
        }
        // print_r('<pre>');print_r($data);print_r('</pre>'); 

        // exit;
        if($image){
            $image->storeAs('public/uploads/produk', $image->hashName());
            $data['produk_photo'] = $image->hashName();
        }

        $operation = DB::table('tb_produk')->insert($data);
        if($operation == 1){
            $response['success'] = true;
            $response['title'] = 'Success';
            $response['message'] = 'Berhasil Menambahkan Data';
        }else{
            $response['success'] = false;
            $response['title'] = 'Failed';
            $response['message'] = 'Gagal Mengubah Data!';
        }

        return $response;
    }

    public function edit(Request $request){
        $id = $request->input('produk_id');

        $operation = DB::table('tb_produk')->where('produk_id', $id)->get()->toArray();

        return $operation;
    }

    public function update(Request $request)
    {
        $response=[];
        $image = $request->file('produk_photo');
        $data = $_POST;

        // set data
        $harga1 = (int)$data['produk_harga'] * (int)$data['produk_beban'];
        $harga2 = (int)$harga1 / 100;
        $harga = (int)$data['produk_harga'] + (int)$harga2;
        $data['produk_harga_jual'] = $harga;

        if(isset($data['produk_active'])){
            $data['produk_active'] = 1;
        }else{
            $data['produk_active'] = 0;
        }

        $data['produk_updated_at'] = date('Y-m-d H:i:s');
        if($image){
            $image->storeAs('public/uploads/produk', $image->hashName());
            $data['produk_photo'] = $image->hashName();
        }

        $operation = DB::table('tb_produk')->where('produk_id', $data['produk_id'])->update($data);

        if($operation == 1){
            $response['success'] = true;
            $response['title'] = 'Success';
            $response['message'] = 'Berhasil Mengubah Data!';
        }else{
            $response['success'] = false;
            $response['title'] = 'Failed';
            $response['message'] = 'Gagal Mengubah Data!';
        }
        return $response;
    }

    public function destroy(Request $request){
        $response = [];
        $id = $request->input('produk_id');

        $produk = DB::table('tb_produk')->where('produk_id', $id)->get()->toArray();
        $data = [
            'produk_deleted_at' => date('Y-m-d H:i:s'),
            'produk_active' => null
        ];
        $operation = DB::table('tb_produk')->where('produk_id', $id)->update($data);
        Storage::disk('local')->delete('public/uploads/produk/'.$produk[0]->produk_photo);

        if($operation == 1){
            $response['success'] = true;
            $response['title'] = 'Success';
            $response['message'] = 'Berhasil Mengubah Data!';
        }else{
            $response['success'] = false;
            $response['title'] = 'Failed';
            $response['message'] = 'Gagal Mengubah Data!';
        }
        return $response;
    }

    public function combobox()
    {
        $operation = DB::table('tb_produk')->where('produk_active', 1)->get()->toArray();
        return $operation;
    }

    // public function importExcel(Request $request) 
	// {
    //     $response = [];
	// 	// validasi
	// 	$validate = $this->validate($request, [
	// 		'produk_import_file' => 'required|mimes:csv,xls,xlsx'
	// 	]);
        
    //     // print_r($validate['produk_import_file']); exit;
	// 	// menangkap file excel
	// 	$file = $request->file('produk_import_file');
 
	// 	// membuat nama file unik
	// 	$nama_file = rand().$file->getClientOriginalName();
 
	// 	// upload ke folder file_siswa di dalam folder public
	// 	$file->move('excel_produk',$nama_file);
 
	// 	// import data
	// 	$operation = Excel::import(new ImportProduk, public_path('/excel_produk/'.$nama_file));
        
    //     if($operation){
    //         $response['success'] = true;
    //         $response['title'] = 'Success';
    //         $response['message'] = 'Successfully saved data.';
    //     }
	// 	// alihkan halaman kembali
	// 	return $response;
	// }
}
