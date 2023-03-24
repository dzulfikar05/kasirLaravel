<div class="row">
    <div class="col-lg-8">
        <div class="row">
            <span>Tanggal <span class="ms-1">: <?= date('d M Y') ?></span></span>
            <span>Kasir <span style="margin-left: 25px" id="nama_kasir"></span></span>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="d-flex justify-content-end">
            <div class="row ">
                <span class=" d-flex justify-content-end">No. <span id="no_nota"> </span></span>
                <span class="mt-2 fs-4 d-flex justify-content-end">Grand Total</span>
                <span style="font-size: 42px" id="grandTotal" class="d-flex justify-content-end">0</span>
            </div>
        </div>
    </div>
    <div class="col-12">
        <button class="btn btn-primary" onclick="onShowBarang()">Pilih Produk</button>
    </div>
    <div class="col-lg-8 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100"
                        id="table_keranjang">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th>No</th>
                                <th>Barcode</th>
                                <th>Nama</th>
                                <th>Qty</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Sub Total</th>
                                <th style="width: 100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="form-label mb-3">
                    <label for="bayar" class="mb-2">Bayar</label>
                    <input id="totalBayar" name="totalBayar" type="hidden">
                    <input id="bayar" name="bayar" onkeyup="getKembalian()" class="form-control mb-3"
                        type="number">
                </div>
                <div class="form-label mb-4">
                    <label for="kembalian" class="mb-2">Kembalian</label>
                    <input id="kembalian" readonly name="kembalian" class="form-control mb-3 bg-light" type="text">
                </div>

                <div class="col-12 ">
                    <div class="row">
                        <div class="col-md-6">
                            <button onclick="bayar('bayar')" class="btn btn-success">Bayar</button>
                        </div>
                        <div class="col-md-6">
                            <button onclick="bayar('bayarcetak')" class="btn btn-success">Bayar & Cetak Nota</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@include('transaksi::form')
@include('transaksi::javascript')
@include('transaksi::struk')
