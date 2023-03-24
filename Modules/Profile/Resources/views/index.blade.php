<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center my-5">
                    <img id="photoUser" src="" class="rounded-circle" height="200px" width="200px"
                        style="object-fit: cover" alt="Photo Profile">
                </div>
                {{-- <div class="row mt-5">
                    <div class="col-5">
                        <p class="text-muted">Nama</p>
                        <p class="text-muted">Username</p>
                        <p class="text-muted">Email</p>
                    </div>
                    <div class="col-7">
                        <p class="show-user_nama"></p>
                        <p class="show-user_username"></p>
                        <p class="show-user_email"></p>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="javascript:onSave(this)"  method="post" id="form_user" name="form_user"
                    autocomplete="off">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group col-12 row mb-2">
                        <label class="form-label col-12" for="user_photo">Photo Profile</label>
                        <div class="row">

                            <div class="picture-container  col-2">
                                <div class="picture">
                                    <img src="" class="picture-src" id="user_photoPreview" title="">
                                    <input type="file" id="user_photo" name="user_photo">
                                </div>

                            </div>
                            <i class="col-10 remove-img d-flex justify-content-start fa fa-times text-danger fa-2x"
                                onclick="removePP(this)"></i>
                        </div>
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="user_nama">Nama</label>
                        <input id="user_nama" required name="user_nama" class="form-control mb-3" type="text"
                            placeholder="Nama">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="user_username">Username</label>
                        <input id="user_username" required name="user_username" class="form-control mb-3" type="text"
                            placeholder="Username">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="user_email">Email</label>
                        <input id="user_email" required name="user_email" class="form-control mb-3" type="email"
                            placeholder="Email">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="user_password">Password</label>
                        <input id="user_password" name="user_password" class="form-control mb-3" type="password"
                            placeholder="Password">
                    </div>
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
@include('profile::javascript')
