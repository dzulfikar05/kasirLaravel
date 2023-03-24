<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Form Satuan
            </div>
            <div class="card-body">
                <form action="javascript:onSave(this)" method="post" id="form_satuan" name="form_satuan" autocomplete="off">
                    <input type="hidden" name="satuan_id" id="satuan_id">
                    <div class="form-label">
                        <label class="mb-2 required" for="satuan_kode">Kode</label>
                        <input id="satuan_kode" required name="satuan_kode" class="form-control mb-3" type="text"
                            placeholder="kode">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="satuan_nama">Nama</label>
                        <input id="satuan_nama" required name="satuan_nama" class="form-control mb-3" type="text"
                            placeholder="Nama">
                    </div>
                    <label class="form-check mt-2">
                        <input id="satuan_active" name="satuan_active" class="form-check-input" type="checkbox"
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
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Tabel Satuan
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100" id="table_satuan">
                    <thead class="text-center">
                        <tr class="fw-bolder">
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
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
@include('satuan::javascript')
