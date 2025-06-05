<div class="tab-pane fade show active" id="puskesmas-tab-pane" role="tabpanel" aria-labelledby="puskesmas-tab"
    tabindex="0">
    <div class="d-flex justify-content-between mb-3">
        <form class="d-flex">
            <input id="searchInput" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        </form>
        <div class="d-flex gap-3">
            <button class="btn btn-secondary-color" data-bs-toggle="modal" data-bs-target="#createModal">
                Tambah Puskesmas
            </button>

        </div>
    </div>
    <div class="table-responsive">
        <table id="dataTable" class="table table-hover" style="width:100%">
            <thead class="table primary-thead">
                <tr>
                    <th>No</th>
                    <th>Nama Puskesmas</th>
                    <th>Wilayah</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($puskesmas as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama_puskesmas }}</td>
                        <td>{{ $data->kecamatan->nama }}</td>
                        <td>{{ $data->alamat }}</td>
                        <td>
                            <a class="primary-color fs-5 text-decoration-none"
                                href="{{ route('puskesmas.show', $data->id) }}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $data->id }}">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </button>
                            {{-- <form action="{{ route('puskesmas.destroy', $data->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form> --}}
                        </td>
                    </tr>
                    @include('puskesmas.puskesmas.edit', ['data' => $data])
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
