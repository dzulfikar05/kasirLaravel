<div class="row">
    <div class="col-xl-6 col-xxl-5 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Transaksi</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="badge badge-primary-light rounded-circle">
                                        <i class="align-middle m-2" data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-1 text-transaksi">0</h1>
                            <div class="mb-0">
                                {{-- <span class="badge badge-primary-light"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> --}}
                                <span class="text-muted">Transaksi Berhasil di Hari Ini</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Produk</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="badge badge-warning-light rounded-circle ">
                                        <i class="align-middle m-2" data-feather="package"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-1 text-produk">0</h1>
                            <div class="mb-0">
                                {{-- <span class="badge badge-success-light"> <i class="mdi mdi-arrow-bottom-right"></i> 5.25% </span> --}}
                                <span class="text-muted">Total Produk</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Income</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="badge badge-success-light rounded-circle">
                                        <i class="align-middle m-2" data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-1 text-income">0</h1>
                            <div class="mb-0">
                                {{-- <span class="badge badge-danger-light"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25% </span> --}}
                                <span class="text-muted">Pendapatan di Hari Ini</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Pengadaan</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="badge badge-danger-light rounded-circle">
                                        <i class="align-middle m-2" data-feather="inbox"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-1 text-pengadaan">0</h1>
                            <div class="mb-0">
                                {{-- <span class="badge badge-success-light"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span> --}}
                                <span class="text-muted">Pengadaan Barang di Hari Ini</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-xxl-7">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Produk Terlaris</h5>
            </div>
            <div class="card-body pt-2 pb-3">
                <div id="chartTerlaris" style="height: 300px; width: 100%"></div>
            </div>
        </div>
    </div>
</div>

@include('dashboard::javascript')