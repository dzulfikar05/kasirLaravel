<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Form Kategori
            </div>
            <div class="card-body">
                <form action="javascript:onSave(this)" method="post" id="form_kategori" name="form_kategori" autocomplete="off">
                    <input type="hidden" name="kategori_id" id="kategori_id">
                    <div class="form-label">
                        <label class="mb-2 required" for="kategori_kode">Kode</label>
                        <input id="kategori_kode" required name="kategori_kode" class="form-control mb-3" type="text"
                            placeholder="kode">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="kategori_nama">Nama</label>
                        <input id="kategori_nama" required name="kategori_nama" class="form-control mb-3" type="text"
                            placeholder="Nama">
                    </div>
                    <label class="form-check mt-2">
                        <input id="kategori_active" name="kategori_active" class="form-check-input" type="checkbox"
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
                Tabel Kategori
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100" id="table_kategori">
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
@include('kategori::javascript')
