<div class="modal fade" id="assignModal{{ $role->id }}" tabindex="-1" aria-labelledby="assignModal{{ $role->id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Permissions to {{ $role->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row gap-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Role Name</label>
                            <input type="text" class="form-control" value="{{ $role->name }}" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Permissions</label>
                            @foreach ($permissions as $permission)
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                    name="permission[]"
                                    value="{{ $permission->name }}" 
                                    id="permission_{{ $permission->id }}_{{ $role->id }}"
                                    {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label" for="permission_{{ $permission->id }}_{{ $role->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endforeach

                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">Save Permissions</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>