<div class="d-flex justify-content-center ">
    <div class="col-12 ">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <form action="javascript:onSave(this)" method="post" id="form_stok" name="form_stok" autocomplete="off">
                        <input type="hidden" name="stok_id" id="stok_id">
                        <div class="form-label ">
                            <label class="mb-2 fs-4 required" for="stok_kategori">Pilih Kategori</label>
                            <select id="stok_kategori" name="stok_kategori" class="w-100" onchange="showBeban()"
                                style="width: 100%">
                                <option value="" selected disabled>- Pilih -</option>
                                <option value="1">Masuk</option>
                                <option value="2">Keluar</option>
                            </select>
                        </div>
                        <div class="form-label mt-5 col-md-3">
                            <label class="mb-2 required" for="stok_tanggal">Tanggal</label>
                            <input id="stok_tanggal" required name="stok_tanggal" class="form-control mb-3"
                                type="date">
                        </div>
                        <div class="form-label ">
                            <label class="mb-2 col-12" for="stok_label">Label</label>
                            <input id="stok_label" required name="stok_label" class="form-control mb-3" type="text">
                        </div>
                        <div class="row">
                            <div class="form-label col-md-4">
                                <label class="mb-2 col-12" for="stok_produk_id">Produk</label>
                                <select id="stok_produk_id" name="stok_produk_id" class="w-100" style="width: 100%">
                                    <option value="">- Pilih -</option>
                                </select>
                            </div>
                            <div class="form-label col-md-4">
                                <label class="mb-2 col-12" for="stok_jumlah">Jumlah</label>
                                <input id="stok_jumlah" required name="stok_jumlah" class="form-control mb-3"
                                    type="number">
                            </div>
                            <div class="form-label  col-md-4 col-beban">
                                <label class="mb-2 col-12" for="stok_produk_beban">Beban Produk</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="stok_produk_beban"
                                        name="stok_produk_beban">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-label">
                            <label class="mb-2 col-12" for="stok_supplier_id">Supplier</label>
                            <select id="stok_supplier_id" name="stok_supplier_id" class="w-100" style="width: 100%">
                                <option value="">- Pilih -</option>
                            </select>
                        </div>

                        <div class="form-label">
                            <label class="mb-2 " for="stok_keterangan">Keterangan</label>
                            <textarea id="stok_keterangan" name="stok_keterangan" class="form-control mb-3" rows="3" placeholder="Keterangan"></textarea>
                        </div>

                        <div class="form-group mt-5 d-flex justify-content-end">
                            <button type="button" onclick="onReset()" class="btn btn-light me-3"><i
                                    class="align-middle" data-feather="rotate-ccw"> </i> Reset</button>
                            <button type="submit" class="btn btn-success"><i class="align-middle" data-feather="save">
                                </i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('stok::javascript')
