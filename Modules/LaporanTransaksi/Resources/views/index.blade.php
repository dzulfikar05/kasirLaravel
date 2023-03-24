<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-2">
                                <span class="fw-bold text-secondary">Filter Date</span>
                                <input type="text" class="form-control mt-3 form-control-sm datepicker col-5 col-md-3" id="startDate" name="startDate" placeholder="dd/mm/yyyy">
                                <span class="mt-1 mx-2">s/d</span>
                                <input type="text" class="form-control form-control-sm datepicker col-5 col-md-3" id="endDate" name="endDate" placeholder="dd/mm/yyyy">
                            </div>
                            <div class="col-md-6">
                                <span class="fw-bold text-secondary">Keterangan </span>
                                <p class="mt-3">Total Pendapatan</p>
                                <span class="fs-1 sum_income">Rp. 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="d-flex justify-content-start mb-3 col-md-6">
                        <button type="button" onclick="onFilter(false)" class="btn btn-sm bg-primary text-white" title="Cari" ><i class="ml-1 fa fa-search"> </i> Cari</button>
                        <button type="button" onclick="onFilter(true)" class="btn btn-sm bg-danger text-white mx-2" title="Reset" ><i class="ml-1 fa fa-times"> </i> Reset </button>
                        <button type="button" onclick="cetakLaporan()" class="btn btn-sm btn-success text-white mx-2" title="Cetak Laporan" ><i class="ml-1 fa fa-print"> </i> Cetak </button>
                    </div>
                    <div class="d-flex justify-content-start justify-content-md-end mb-3 col-md-6">
                        {{-- <a href="#" onclick="onCetakLaporan()" class="btn btn-sm bg-pos text-white" style="border-radius: 10px; font-size: 12px">Cetak Laporan <i class="ml-1 fas fa-file-pdf"> </i></a> --}}
                    </div>
                </div>
                <div class="form-group d-flex justify-content-end mb-3">
                    <button type="button" onclick="initTable()" class="btn btn-light "><i class="align-middle"
                            data-feather="rotate-ccw"> </i> Refresh</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100"
                        id="table_laporantransaksi">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Income</th>
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

@include('laporantransaksi::detail')
@include('laporantransaksi::javascript')
