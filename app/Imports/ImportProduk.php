<?php

namespace App\Imports;

use Modules\Produk\Entities\Produk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportProduk implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 5;
    }

    public function model(array $row)
    {
        return new Produk([
            'barang_id' => uniqid(),
            'barang_kode' => $row[2],
            'barang_nama' => $row[3],
            'barang_deskripsi' => $row[4],
            'barang_harga' => $row[5],
            'barang_harga_jual' => $row[6],
            'barang_margin' => (int)$row[6] - (int)$row[5],
            'barang_is_active' => 1,
            'barang_created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
