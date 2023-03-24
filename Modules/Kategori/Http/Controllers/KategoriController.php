<?php

namespace Modules\Kategori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB; 

use DataTables;

class KategoriController extends Controller
{

    public function index()
    {
        return view('main::index', [
            'title' => 'Kategori',
            'content' => view('kategori::index')
        ]);
        // return view('dashboard::index');
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tb_kategori')->where([
                ['kategori_deleted_at', null],
            ])->get()->toArray();
            // print_r($data); exit;

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->kategori_id;
                    $btn = '<div >
                                        <a href="#" onclick="onEdit(this)" data-id="' . $id . '" title="Edit Data" class="btn btn-warning btn-sm"><i class="align-middle fa fa-pencil fw-light text-dark"> </i></a>
                                        <a href="#" onclick="onDelete(this)" data-id="' . $id . '" title="Delete Data" class="btn btn-danger btn-sm"><i class="align-middle fa fa-trash fw-light"> </i></a>
                                </div>
                                ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('kategorilowongan.index');
    }

    public function edit(Request $request)
    {
        $id = $request->input('kategori_id');

        $operation = DB::table('tb_kategori')->where('kategori_id', $id)->get()->toArray();
        return $operation;
    }

    public function store(Request $request)
    {
        $response = [];

        $data = $request->input();
        $data['kategori_id'] = uniqid();
        $data['kategori_created_at'] = date('Y-m-d H:i:s');

        if (isset($data['kategori_active'])) {
            $data['kategori_active'] = 1;
        } else {
            $data['kategori_active'] = 0;
        }

        $operation = DB::table('tb_kategori')->insert($data);

        if ($operation == 1) {
            $response['success'] = true;
            $response['title'] = 'Success';
            $response['message'] = 'Berhasil Menambahkan Data';
        } else {
            $response['success'] = false;
            $response['title'] = 'Failed';
            $response['message'] = 'Gagal Mengubah Data!';
        }

        return $response;
    }

    public function update(Request $request)
    {
        $response = [];

        $data = $request->input();
        $data['kategori_updated_at'] = date('Y-m-d H:i:s');

        if (isset($data['kategori_active'])) {
            $data['kategori_active'] = 1;
        } else {
            $data['kategori_active'] = 0;
        }

        $operation = DB::table('tb_kategori')->where('kategori_id', $data['kategori_id'])->update($data);

        if ($operation == 1) {
            $response['success'] = true;
            $response['title'] = 'Success';
            $response['message'] = 'Berhasil Mengubah Data!';
        } else {
            $response['success'] = false;
            $response['title'] = 'Failed';
            $response['message'] = 'Gagal Mengubah Data!';
        }
        return $response;
    }

    public function destroy(Request $request)
    {
        $response = [];
        $id = $request->input('kategori_id');

        $data = [
            'kategori_deleted_at' => date('Y-m-d H:i:s'),
            'kategori_active' => null
        ];
        $operation = DB::table('tb_kategori')->where('kategori_id', $id)->update($data);

        if ($operation == 1) {
            $response['success'] = true;
            $response['title'] = 'Success';
            $response['message'] = 'Berhasil Mengubah Data!';
        } else {
            $response['success'] = false;
            $response['title'] = 'Failed';
            $response['message'] = 'Gagal Mengubah Data!';
        }

        return $response;
    }

    public function combobox()
    {
        $operation = DB::table('tb_kategori')->where('kategori_active', 1)->get()->toArray();
        return $operation;
    }
}
