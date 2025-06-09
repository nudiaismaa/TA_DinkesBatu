<div class="tab-pane fade" id="akun-posyandu-tab-pane" role="tabpanel" aria-labelledby="akun-posyandu-tab" tabindex="0">
    <div class="d-flex justify-content-between mb-3">
        <form class="d-flex">
            <input id="searchInput" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        </form>
        <div class="d-flex gap-3">
            <button class="btn btn-secondary-color" data-bs-toggle="modal" data-bs-target="#createAccountModal">
                Tambah Akun
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table id="dataTable" class="table table-hover" style="width:100%">
            <thead class="table primary-thead">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Posyandu</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr id="user_{{ $user->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ $user->posyandu->first() ? $user->posyandu->first()->nama_posyandu : 'N/A' }}
                        </td>
                        <td>
                            <form action="{{ route('user_posyandu.toggle-active', $user->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('POST')
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-active" type="checkbox" role="switch"
                                        id="toggle_{{ $user->id }}" data-id="{{ $user->id }}"
                                        {{ $user->isActive() ? 'checked' : '' }}>
                                    <label class="form-check-label" for="toggle_{{ $user->id }}">
                                        {{ $user->userStatus->name }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editAccountModal{{ $user->id }}">
                                 <i class="bi bi-pencil-square"></i>
                                Edit
                            </button>
                            <form action="{{ route('user_posyandu.destroy', $user->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @include('posyandu.akun_posyandu.edit', ['data' => $user, 'posyandu' => $posyandus])
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('dataTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            for (let i = 0; i < rows.length; i++) {
                const namaAnakCell = rows[i].getElementsByTagName('td')[1];
                if (namaAnakCell) {
                    const namaAnak = namaAnakCell.textContent || namaAnakCell.innerText;
                    rows[i].style.display = namaAnak.toLowerCase().includes(filter) ? '' : 'none';
                }
            }
        });
    });
</script>
