<div class="modal fade" id="editAccountModal{{ $data->id }}" tabindex="-1"
    aria-labelledby="editModalLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Puskesmas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user_puskesmas.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row gap-3">
                        <div class="col-12">
                            <label for="puskesmas_id" class="form-label">Puskesmas</label>
                            <select class="form-select" name="puskesmas_id" id="puskesmas_id">
                                @foreach ($puskesmas as $p)
                                    <option value="{{ $p->id }}"
                                        {{ $data->puskesmas->first() && $p->id == $data->puskesmas->first()->id ? 'selected' : '' }}>
                                        {{ $p->nama_puskesmas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" id="name" class="form-control" name="name"
                                value="{{ $data->name }}" placeholder="Nama Akun Anda..." required>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" name="email"
                                value="{{ $data->email }}" placeholder="example@mail.com" required>
                        </div>
                        <div class="col-12">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" name="password" value=""
                                placeholder="********">
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
