<div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $data->id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Puskesmas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('puskesmas.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row gap-3">
                        <div class="col-12">
                            <label for="nama_puskesmas" class="form-label">Nama Puskesmas</label>
                            <input type="text" id="nama_puskesmas" class="form-control" name="nama_puskesmas"
                                value="{{ $data->nama_puskesmas }}" placeholder="Nama Puskesmas..." required>
                        </div>
                        <div class="col-12">
                            <label for="kecamatan_id" class="form-label">Nama Kecamatan</label>
                            <select class="form-select" name="kecamatan_id" id="kecamatan_id">
                                <option selected value="{{ $data->kecamatan_id }}"></option>
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}"
                                        {{ $kecamatan->id == $data->kecamatan_id ? 'selected' : '' }}>
                                        {{ $kecamatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat Puskesmas</label>
                            <input type="text" id="alamat" class="form-control" name="alamat"
                                value="{{ $data->alamat }}" placeholder="Alamat Puskesmas..." required>
                        </div>
                        <div class="col-12">
                            <label for="rt" class="form-label">RT</label>
                            <input type="number" id="rt" name="rt" class="form-control"
                                value="{{ $data->rt }}" placeholder="Nomor RT..." required>
                        </div>
                        <div class="col-12">
                            <label for="rw" class="form-label">RW</label>
                            <input type="number" id="rw" name="rw" class="form-control"
                                value="{{ $data->rw }}" placeholder="Nomor RW..." required>
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
