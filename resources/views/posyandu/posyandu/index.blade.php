<div class="tab-pane fade show active" id="posyandu-tab-pane" role="tabpanel" aria-labelledby="posyandu-tab" tabindex="0">
    <div class="d-flex justify-content-between mb-3">
        <form class="d-flex">
            <input id="searchInput1" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        </form>
        <div class="d-flex gap-3">
            @role('Front Office')
                <button class="btn btn-secondary-color" data-bs-toggle="modal" data-bs-target="#createModal">
                    Tambah Posyandu
                </button>
            @endrole
        </div>
    </div>
    <div class="table-responsive">
        <table id="dataTable1" class="table table-hover" style="width:100%">
            <thead class="table primary-thead">
                <tr>
                    <th>No</th>
                    <th>Nama Posyandu</th>
                    <th>Puskesmas</th>
                    <th>Kelurahan</th>
                    <th>Kecamatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posyandus as $posyandu)
                    <tr>
                        @php
                            $counter = 1; // Inisialisasi counter manual
                        @endphp
                        <td>{{ $counter++ }}</td>
                        <td>{{ $posyandu->nama_posyandu }}</td>
                        <td>{{ $posyandu->puskesmas->nama_puskesmas }}</td>
                        <td>{{ $posyandu->kelurahan->nama }}</td>
                        <td>{{ $posyandu->kelurahan->kecamatan->nama }}</td>
                        <td>
                            <a class="primary-color fs-5 text-decoration-none"
                                href="{{ route('posyandu.show', $posyandu->id) }}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $posyandu->id }}">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </button>
                            {{-- <form action="{{ route('posyandu.destroy', $posyandu->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form> --}}
                        </td>
                    </tr>
                    @include('posyandu.posyandu.edit', ['posyandu' => $posyandu])
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput1');
        const table = document.getElementById('dataTable1');
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