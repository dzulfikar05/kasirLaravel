<div class="row">
    @include('produk::form')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Tabel Produk</div>
            </div>
            <div class="card-body">
                <div class="form-group d-flex justify-content-end mb-3">
                    <button type="button" onclick="showForm()" class="btn btn-primary me-3"><i class="align-middle" data-feather="plus"> </i> Tambah</button>
                    <button type="button" onclick="initTable()" class="btn btn-light "><i class="align-middle" data-feather="rotate-ccw"> </i> Refresh</button>
                    {{-- <button type="button" onclick=/"showExcel()" class="btn btn-success ms-3 "><i class="align-middle" data-feather="file"> </i> Import Excel</button> --}}
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100" id="table_produk">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th>No</th>
                                <th>Barcode</th>
                                <th>Produk</th>
                                <th>Harga Beli</th>
                                <th>Bobot</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('produk::javascript')