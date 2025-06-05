<div class="modal fade" id="createJadwalModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal Posyandu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('jadwalPosyandu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row gap-3">
                        <input type="hidden" name="posyandu_id"
                            value="{{ optional(Auth::user()->posyandu->first())->id }}">
                        <div class="col-12">
                            <label for="tanggal" class="form-label">Tanggal Pelaksanaan</label>
                            <input type="date" id="tanggal" class="form-control" name="tanggal" required>
                        </div>
                        <div class="col-12">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <input type="text" id="deskripsi" name="deskripsi" class="form-control"
                                placeholder="Tambahkan Deskripsi..." required>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary-color w-100 mb-1">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
