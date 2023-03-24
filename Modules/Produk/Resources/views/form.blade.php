<style>
     #produk_import_file{
        opacity: 0.0;
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height:100%;
    }
    #file_upload{
        position: relative;
        border: 2px dashed #3051d3;
        border-radius: 10px;
        width: 100%;
        height: 100px;
        line-height: 30px;
        text-align: center;
    }
</style>
<div class="modal viewForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:onSave(this)" method="post" id="form_produk" name="form_produk"
                    autocomplete="off">
                    <input type="hidden" name="produk_id" id="produk_id">
                    <div class="form-label">
                        <label class="mb-2 required" for="produk_kode">Kode</label>
                        <input id="produk_kode" required name="produk_kode" class="form-control mb-3" type="text"
                            placeholder="Kode">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="produk_nama">Nama</label>
                        <input id="produk_nama" required name="produk_nama" class="form-control mb-3" type="text"
                            placeholder="Nama">
                    </div>
                    <div class="form-label ">
                        <label class="mb-2 col-12" for="produk_kategori_id">Kategori</label>
                        <select id="produk_kategori_id" name="produk_kategori_id" class="w-100" style="width: 100%">
                            <option value="">- Pilih -</option>
                        </select>
                    </div>
                    <div class="form-label ">
                        <label class="mb-2 col-12" for="produk_satuan_id">Satuan</label>
                        <select id="produk_satuan_id" name="produk_satuan_id" class="w-100" style="width: 100%">
                            <option value="">- Pilih -</option>
                        </select>
                    </div>
                    <div class="form-label row">
                        <div class="col-md-6">
                            <label class="mb-2 required" for="produk_harga">Harga</label>
                            <input id="produk_harga" required name="produk_harga" class="form-control mb-3" type="number"placeholder="Harga">
                        </div>
                        <div class="col-md-6">
                            <label class="mb-2 required" for="produk_beban">Bobot</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="produk_beban" name="produk_beban">
                                <span class="input-group-text">%</span>
                            </div>
                            {{-- <input id="produk_harga" required name="produk_harga" class="form-control mb-3" type="number"placeholder="Harga"> --}}
                        </div>
                    </div>
                    {{-- <div class="form-label ">
                        <label class="mb-2 col-12" for="produk_supplier_id">Supplier</label>
                        <select id="produk_supplier_id" name="produk_supplier_id" class="w-100" style="width: 100%">
                            <option value="">- Pilih -</option>
                        </select>
                    </div> --}}
                    <div class="form-label">
                        <label class="mb-2 " for="produk_keterangan">Keterangan</label>
                        <textarea id="produk_keterangan"  name="produk_keterangan" class="form-control mb-3" rows="2"
                            placeholder="Keterangan"></textarea>
                    </div>
                    <div class="form-group col-12 row mb-2">
                        <label class="form-label col-12" for="produk_photo">Photo</label>
                        <div class="row">

                            <div class="picture-container  col-2">
                                <div class="picture">
                                    <img src="" class="picture-src" id="produk_photoPreview" title="">
                                    <input type="file" id="produk_photo" name="produk_photo">
                                </div>

                            </div>
                            <i class="col-10 remove-img d-flex justify-content-start fa fa-times text-danger fa-2x"
                                onclick="removePP(this)"></i>
                        </div>
                    </div>
                    <label class="form-check mt-2">
                        <input id="produk_active" name="produk_active" class="form-check-input" type="checkbox" value="1">
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
</div>
{{-- <div id="modalExcel" class="modal animate" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content animate-bottom">
            <div class="modal-header">
                <h5 class="modal-title">
                    Form Import Excel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="javascript:onImport('form_import_produk')" method="post" id="form_import_produk" name="form_import_produk" autocomplete="off" enctype="multipart/form-data">
                            
                            <div id="file_upload" class="d-flex align-items-center justify-content-center">
                                <span id="text_upload_file" class="text-muted fs-4">Import Excel File</span>
                                <input name="produk_import_file" id="produk_import_file" type="file" multiple="multiple">
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Send Files</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}