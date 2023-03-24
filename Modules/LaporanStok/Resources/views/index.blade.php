<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <span class="fw-bold text-secondary">Filter Date</span>
                        <input type="text" class="form-control mt-3 form-control-sm datepicker col-5 col-md-3" id="startDate" name="startDate" placeholder="dd/mm/yyyy">
                        <span class="mt-1 mx-2">s/d</span>
                        <input type="text" class="form-control form-control-sm datepicker col-5 col-md-3" id="endDate" name="endDate" placeholder="dd/mm/yyyy">
                    </div>
                    {{-- <div class="col-md-6">
                        <span class="fw-bold text-secondary">Keterangan </span>
                        <p class="mt-3">Total Pendapatan</p>
                        <span class="fs-1 sum_income">Rp. 0</span>
                    </div> --}}
                    <div class="col-md-6 ms-0 ms-md-5 mt-4 mt-md-0">
                        <span class="fw-bold text-secondary">Filter Kategori </span>

                        <div class="form-input mt-3">
                            <select id="stok_kategori" required name="stok_kategori" class="form-control"
                                placeholder="PIlih Kategori Stok">
                                <option value="" selected disabled>- Pilih Kategori Stok -</option>
                                <option value="1">Masuk</option>
                                <option value="2">Keluar</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <button class="ms-3 btn btn-primary" onclick="initTable()" ><i class="fa fa-search"></i> Cari</button>
                    </div> --}}
                </div>
                <div class="row mt-4">
                    <div class="d-flex justify-content-start mb-3 col-md-6">
                        <button type="button" onclick="onFilter(false)" class="btn btn-sm bg-primary text-white"
                            title="Cari"><i class="ml-1 fa fa-search"> </i> Cari</button>
                        <button type="button" onclick="onFilter(true)" class="btn btn-sm bg-danger text-white mx-2"
                            title="Reset"><i class="ml-1 fa fa-times"> </i> Reset </button>
                        <button type="button" onclick="cetakLaporan()" class="btn btn-sm btn-success text-white mx-2"
                            title="Cetak Laporan"><i class="ml-1 fa fa-print"> </i> Cetak </button>
                    </div>
                </div>
                <div class="d-flex flex-row mt-5">
                    <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100"
                        id="table_masuk">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Label</th>
                                <th>Jumlah</th>
                                <th>Beban</th>
                                <th>Keterangan</th>
                                <th>Supplier</th>
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
<div class="laporan d-none"></div>
<div class="invoice d-none"></div>
@include('laporanstok::javascript')
