<div class="modal fade" id="editModal{{ $role->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $role->id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Role Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row gap-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Nama Role</label>
                            <input type="text" id="name" class="form-control" value="{{ $role->name }}"
                                name="name" placeholder="Name" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary-color w-100 mb-1">Simpan</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
