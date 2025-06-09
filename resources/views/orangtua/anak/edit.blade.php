<div class="modal fade" id="editAnakModal{{ $anak->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Anak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('anak.update', ['id' => $anak->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="posyandu_id"
                        value="{{ optional(Auth::user()->posyandu->first())->id }}">
                    <input type="hidden" name="orangtua_id" value="{{ $anak->orangtua_id }}">
                    <input type="hidden" name="kelurahan_id" value="{{ $anak->orangtua->kelurahan_id }}">
                    <div class="row gap-3">
                        <div class="col-12">
                            <label for="nama{{ $anak->id }}" class="form-label">Nama Anak</label>
                            <input type="text" id="nama{{ $anak->id }}" class="form-control" name="nama"
                                value="{{ $anak->nama }}" required>
                        </div>
                        <div class="col-12">
                            <label for="tanggal_lahir{{ $anak->id }}" class="form-label">Tanggal Lahir
                                {{ $anak->tanggal_lahir }}</label>
                            <input type="date" id="tanggal_lahir{{ $anak->id }}" class="form-control"
                                name="tanggal_lahir" value="{{ $anak->tanggal_lahir }}" required>
                        </div>
                        <div class="col-12">
                            <label for="nik{{ $anak->id }}" class="form-label">NIK</label>
                            <input type="text" id="nik{{ $anak->id }}" name="nik" class="form-control"
                                value="{{ $anak->nik }}" required>
                        </div>
                        <div class="col-12">
                            <label for="jenis_kelamin{{ $anak->id }}" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin{{ $anak->id }}" name="jenis_kelamin"
                                required>
                                <option disabled>Pilih Jenis Kelamin...</option>
                                <option value="L" {{ $anak->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki -
                                    Laki
                                </option>
                                <option value="P" {{ $anak->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="berat_badan_saat_lahir{{ $anak->id }}" class="form-label">Berat Badan
                                Saat
                                Lahir (kg)</label>
                            <input type="number" id="berat_badan_saat_lahir{{ $anak->id }}"
                                name="berat_badan_saat_lahir" class="form-control"
                                value="{{ $anak->berat_badan_saat_lahir }}" step="0.001" min="0" required>
                        </div>
                        <div class="col-12">
                            <label for="alamat{{ $anak->id }}" class="form-label">Alamat</label>
                            <input type="text" id="alamat{{ $anak->id }}" name="alamat" class="form-control"
                                value="{{ $anak->alamat }}" required>
                        </div>
                        <div class="col-12">
                            <label for="anak_ke{{ $anak->id }}" class="form-label">Anak Ke</label>
                            <input type="number" id="anak_ke{{ $anak->id }}" name="anak_ke" class="form-control"
                                value="{{ $anak->anak_ke }}" required>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-primary-color w-100">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
