<div class="modal fade" id="movePosyanduModal{{ $anak->id }}" tabindex="-1" aria-labelledby="movePosyanduModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="movePosyanduModalLabel">Pindah Posyandu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('anak.move-posyandu') }}" method="POST">
                    @csrf
                    <input type="hidden" name="anak_id" value="{{ $anak->id }}">
                    <div class="row gap-3">
                        <div class="col-12">
                            <label for="posyandu_id" class="form-label">Posyandu Baru</label>
                            <select class="form-select" name="posyandu_id" id="posyandu_id" required>
                                <option value="">Pilih Posyandu</option>
                                @foreach ($posyandu as $p)
                                    <option value="{{ $p->id }}" {{ $p->id == $anak->posyandu_id ? 'disabled' : '' }}>
                                        {{ $p->nama_posyandu }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary-color w-100">Pindahkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>