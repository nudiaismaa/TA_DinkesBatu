<div class="modal fade" id="createOrangTuaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Orang Tua</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="smartwizard">
                            <ul class="nav nav-progress my-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-0">
                                        <div class="num">1</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-1">
                                        <span class="num">2</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-2">
                                        <span class="num">3</span>
                                    </a>
                                </li>
                            </ul>
                            <form action="{{ route('orangtua.store') }}" method="POST" class="form"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="tab-content">
                                    <div id="step-0" class="tab-pane" role="tabpanel" aria-labelledby="step-0">
                                        <div class="row gap-3">
                                            <div class="col-12">
                                                <label for="name" class="form-label">Nama Orang Tua</label>
                                                <input type="text" id="name" class="form-control" name="name"
                                                    placeholder="Nama Orang Tua..." required>
                                            </div>
                                            <div class="col-12">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" id="email" name="email" class="form-control"
                                                    placeholder="Email Orang Tua..." required>
                                            </div>
                                            <div class="col-12">
                                                <label for="nik" class="form-label">Nomor Induk Kependudukan
                                                    NIK</label>
                                                <input type="number" id="nik" name="nik" class="form-control"
                                                    placeholder="Nomor Induk Kependudukan..." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                                        <div class="row gap-3">
                                            <div class="col-12">
                                                <label for="alamat_ktp" class="form-label">Alamat KTP</label>
                                                <input type="text" id="alamat_ktp" name="alamat_ktp"
                                                    class="form-control" placeholder="Alamat KTP..." required>
                                            </div>
                                            <div class="col-12">
                                                <label for="alamat_domisili" class="form-label">Alamat
                                                    Domisili</label>
                                                <input type="alamat" id="alamat_domisili" name="alamat_domisili"
                                                    class="form-control" placeholder="Alamat Domisili..." required>
                                            </div>
                                            <div class="col-12 d-none">

                                                <input type="text" id="kelurahan_id" name="kelurahan_id"
                                                    class="form-control"
                                                    value="{{ auth()->user()->posyandu->first()->kelurahan->id }}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                                        <div class="row gap-3">
                                            <div class="col-12">
                                                <label for="Nomor HP" class="form-label fw-semibold">Nomor
                                                    HP</label>
                                                <input type="number" class="form-control" name="nomor_hp"
                                                    id="nomor_hp" placeholder="081*********">
                                            </div>
                                            <div class="col-12">
                                                <label for="password" class="form-label fw-semibold">Password</label>
                                                <input type="password" class="form-control" name="password"
                                                    id="password" placeholder="********">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary-color w-100 d-none"
                                    id="btn-submit">Daftar</button>
                            </form>
                            <button class="btn btn-primary-color w-100" id="btn-next">Lanjut</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
