<div class="modal viewForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Data Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- <form action="javascript:onSave(this)" method="post" id="form_user" name="form_user"
                    autocomplete="off"> --}}

                    <div class="form-label">
                        <label for="search_produk" class="mb-2">Pencarian Produk</label>
                        <input id="search_produk" name="search_produk" class="form-control mb-3" onkeyup="searchProduk()" type="text" placeholder="Masukkan barcode produk">
                    </div>

                    <div class="form-label mt-5">
                        <label class="mb-2">Hasil Pencarian</label>
                        <div class="result">

                        </div>
                        {{-- <div class="card bg-light mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-2 d-none d-md-block">

                                        <img src="https://asset.kompas.com/crops/PdKQ8JEec1uH477e64QGdeYVWWI=/28x0:612x389/750x500/data/photo/2021/03/29/6061aaa779b88.png" class="rounded-3" height="75px" width="75px" style="object-fit: cover" alt="product image">
                                    </div>
                                    <div class="col-8 col-md-6">

                                        <span class="">Kode : </span></br>
                                        <span class="">Nama : </span></br>
                                        <span class="">Stok : 24</span>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <div class="row">
                                            <div class="d-flex flex-row">
                                                <button class="btn btn-primary w-40px  d-none d-md-block">+</button>
                                                <input type="text" class="form-control mx-1 w-75px" >
                                                <button class="btn btn-primary w-40px  d-none d-md-block">-</button>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-end mt-2 mt-md-0">

                                                <button class="btn btn-primary ">Tambahkan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    
                {{-- </form> --}}
            </div>

        </div>
    </div>
</div>
