<div class="modal fade" id="createAnakModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Anak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('anak.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="posyandu_id"
                        value="{{ optional(Auth::user()->posyandu->first())->id }}"> <input type="hidden"
                        name="orangtua_id" value="{{ $orangtua->id }}">
                    <input type="hidden" name="kelurahan_id" value="{{ $orangtua->kelurahan_id }}">
                    <div class="row gap-3 mb-5">
                        <div class="col-12">
                            <label for="nama" class="form-label">Nama Anak</label>
                            <input type="text" id="nama" class="form-control" name="nama"
                                placeholder="Nama Anak..." required>
                        </div>
                        <div class="col-12">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" class="form-control" name="tanggal_lahir" required>
                        </div>
                        <div class="col-12">
                            <label for="nik" class="form-label">Nomor Induk Kependudukan</label>
                            <input type="number" id="nik" name="nik" class="form-control"
                                placeholder="Nomor NIK..." required>
                        </div>
                        <div class="col-12">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" aria-label="Default select example" name="jenis_kelamin">
                                <option selected disabled>Pilih Jenis Kelamin...</option>
                                <option value="L">Laki - Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="berat_badan_saat_lahir" class="form-label">Berat Badan Saat Lahir</label>
                            <input type="number" id="berat_badan_saat_lahir" name="berat_badan_saat_lahir"
                                class="form-control" placeholder="Berat Badan..." step="0.001" required>
                        </div>
                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control"
                                placeholder="Alamat" required>
                        </div>
                        <div class="col-12">
                            <label for="anak_ke" class="form-label">Anak Ke</label>
                            <input type="number" id="anak_ke" name="anak_ke" class="form-control"
                                placeholder="Anak Ke..." required>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary-color w-100">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
