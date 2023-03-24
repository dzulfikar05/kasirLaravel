<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        return view('main::index', [
            'title' => 'Dashboard',
            'content' => view('dashboard::index')
        ]);
    }

    public function getDataCard()
    {
        $date = date('Y-m-d');

        // Operation Transaksi
        $getCountTransaksi = DB::table('tb_transaksi')->where([
            ['transaksi_active', 1],
        ])->whereBetween('transaksi_tanggal', [date("Y-m-d H:i:s", strtotime($date . ' 00:00:00')), date("Y-m-d H:i:s", strtotime($date . ' 23:59:59'))])->count();
        $data['countTransaksi'] = $getCountTransaksi;
        
        // Operation Produk
        $getCountProduk = DB::table('tb_produk')->where([
            ['produk_deleted_at', null],
        ])->count();
        $data['countProduk'] = $getCountProduk;
        
        // Operation Pengadaan
        $getCountPengadaan = DB::table('tb_stok')->where([
            ['stok_kategori', 1],
            ['stok_tanggal', $date],
        ])->count();
        $data['countPengadaan'] = $getCountPengadaan;
        
        // Operation Income
        $getCountIncome = DB::table('tb_transaksi')->select(DB::raw("(sum(transaksi_total_bayar)) as income"))->where([
            ['transaksi_active', 1],
        ])->whereBetween('transaksi_tanggal', [date("Y-m-d H:i:s", strtotime($date . ' 00:00:00')), date("Y-m-d H:i:s", strtotime($date. ' 23:59:59'))])->get()->toArray();
        $dataIncome = convertArray($getCountIncome[0]);
        $data['countIncome'] = $dataIncome['income'];
        

        return $data;
    }

    public function getChartTerlaris()
    {
        // Operation Terlaris
        $getTerlaris = DB::table('tb_produk')->where([
            ['produk_deleted_at', null],
            ['produk_terjual', '!=', 0],
        ])->orderBy('produk_terjual', 'DESC')->limit(10)->get()->toArray();
        $terlaris = convertArray($getTerlaris);

        return $terlaris;
    }
}
