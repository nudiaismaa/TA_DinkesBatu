<div class="modal fade" id="editJadwalModal{{ $j->id }}" tabindex="-1"
    aria-labelledby="editModalLabel{{ $j->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal Posyandu</h5>
                <button type="button" class="btn-close" jadwal-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('jadwalPosyandu.update', $j->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="posyandu_id" value="{{ $j->posyandu_id }}">
                    <div class="row gap-3">
                        <input type="hidden" name="posyandu_id"
                            value="{{ optional(Auth::user()->posyandu->first())->id }}">
                        <div class="col-12">
                            <label for="tanggal" class="form-label">Tanggal Pelaksanaan</label>
                            <input type="date" id="tanggal" value="{{ $j->tanggal }}" class="form-control"
                                name="tanggal" required>
                        </div>
                        <div class="col-12">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <input type="text" id="deskripsi" value="{{ $j->deskripsi }}" name="deskripsi"
                                class="form-control" placeholder="Tambahkan Deskripsi..." required>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary-color w-100 mb-1">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
