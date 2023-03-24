<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                Form Supplier
            </div>
            <div class="card-body">
                <form action="javascript:onSave(this)" method="post" id="form_supplier" name="form_supplier" autocomplete="off">
                    <input type="hidden" name="supplier_id" id="supplier_id">
                    <div class="form-label">
                        <label class="mb-2 required" for="supplier_kode">Kode</label>
                        <input id="supplier_kode" required name="supplier_kode" class="form-control mb-3" type="text"
                            placeholder="kode">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="supplier_nama">Nama</label>
                        <input id="supplier_nama" required name="supplier_nama" class="form-control mb-3" type="text"
                            placeholder="Nama">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="supplier_telepon">Telepon</label>
                        <input id="supplier_telepon" required name="supplier_telepon" class="form-control mb-3" type="number"
                            placeholder="Telepon">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="supplier_alamat">Alamat</label>
                        <textarea id="supplier_alamat" required name="supplier_alamat" class="form-control mb-3" rows="2"
                            placeholder="Alamat"></textarea>
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="supplier_keterangan">Keterangan</label>
                        <textarea id="supplier_keterangan" required name="supplier_keterangan" class="form-control mb-3" rows="2"
                            placeholder="Keterangan"></textarea>
                    </div>
                    <label class="form-check mt-2">
                        <input id="supplier_active" name="supplier_active" class="form-check-input" type="checkbox"
                            value="1">
                        <span class="form-check-label">
                            Active
                        </span>
                    </label>
                    <div class="form-group mt-5 d-flex justify-content-end">
                        <button type="button" onclick="onReset()" class="btn btn-light me-3"><i class="align-middle"
                                data-feather="rotate-ccw"> </i> Reset</button>
                        <button type="submit" class="btn btn-success"><i class="align-middle" data-feather="save"> </i>
                            Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                Tabel Supplier
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100" id="table_supplier">
                    <thead class="text-center">
                        <tr class="fw-bolder">
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kontak</th>
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
@include('supplier::javascript')
