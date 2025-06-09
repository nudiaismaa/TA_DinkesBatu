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
                    <tr class="anak-row" id="posyandu_{{ $posyandu->id }}">
                        <td class="row-number"></td>
                        <td>{{ $posyandu->nama_posyandu }}</td>
                        <td>{{ $posyandu->puskesmas->nama_puskesmas }}</td>
                        <td>{{ $posyandu->kelurahan->nama }}</td>
                        <td>{{ $posyandu->kelurahan->kecamatan->nama }}</td>
                        <td>
                            <a class="primary-color fs-5 text-decoration-none"
                                href="{{ route('posyandu.show', $posyandu->id) }}">
                                <i class="bi bi-eye"></i>
                            </a>
                            @role('Front Office')
                                
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $posyandu->id }}">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </button>
                            @endrole
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
        function updateRowNumbers() {
            let counter = 1;
            $('.anak-row:visible').each(function() {
                $(this).find('.row-number').text(counter++);
            });
        }

        // Inisialisasi nomor urut pertama kali
        updateRowNumbers();
        $('#searchInput1').on('keyup', function() {
            const value = $(this).val().toLowerCase();

            $('.anak-row').each(function() {
                const row = $(this);
                const text = row.text().toLowerCase();

                row.toggle(text.indexOf(value) > -1);
            });

            updateRowNumbers();
        });
    });
</script>
