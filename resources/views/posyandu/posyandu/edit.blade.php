<div class="modal fade" id="editModal{{ $posyandu->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $posyandu->id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Posyandu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('posyandu.update', $posyandu->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row gap-3">
                        <div class="col-12">
                            <label for="nama_posyandu" class="form-label">Nama Posyandu</label>
                            <input type="text" id="nama_posyandu" value="{{ $posyandu->nama_posyandu }}"
                                class="form-control" name="nama_posyandu" placeholder="Nama Posyandu..." required>
                        </div>
                        <div class="col-12">
                            <label for="puskesmas_id{{ $posyandu->id }}" class="form-label">Puskesmas</label>
                            <select class="form-select" name="puskesmas_id" id="puskesmas_id{{ $posyandu->id }}">
                                <option value="">Pilih Puskesmas</option>
                                @foreach ($puskesmas as $p)
                                    <option value="{{ $p->id }}" data-kecamatan-id="{{ $p->kecamatan_id }}"
                                        {{ $p->id == $posyandu->puskesmas_id ? 'selected' : '' }}>
                                        {{ $p->nama_puskesmas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="kelurahan_id{{ $posyandu->id }}" class="form-label">Kelurahan Posyandu</label>
                            <select class="form-select kelurahan-select" name="kelurahan_id"
                                id="kelurahan_id{{ $posyandu->id }}">
                                <option value="">Pilih Kelurahan</option>
                                @foreach ($kelurahans as $k)
                                    <option value="{{ $k->id }}" data-kelurahan-id="{{ $k->kecamatan_id }}"
                                        {{ $k->id == $posyandu->kelurahan_id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="rt" class="form-label">RT</label>
                            <input type="number" value="{{ $posyandu->rt }}" id="rt" name="rt"
                                class="form-control" placeholder="Nomor RT..." required>
                        </div>
                        <div class="col-12">
                            <label for="rw" class="form-label">RW</label>
                            <input type="number" value="{{ $posyandu->rw }}" id="rw" name="rw"
                                class="form-control" placeholder="Nomor RW..." required>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk mengupdate opsi kelurahan
        function updateKelurahanOptions(puskesmasSelect, kelurahanSelect) {
            const selectedPuskesmas = puskesmasSelect.options[puskesmasSelect.selectedIndex];
            const kecamatanId = selectedPuskesmas.getAttribute('data-kecamatan-id');
            const kelurahanOptions = kelurahanSelect.querySelectorAll('option[data-kelurahan-id]');

            // Sembunyikan semua opsi kecuali yang default
            kelurahanOptions.forEach(option => {
                option.style.display = 'none';
            });
            kelurahanSelect.querySelector('option[value=""]').style.display = 'block';

            // Tampilkan hanya kelurahan dari kecamatan yang sesuai
            if (kecamatanId) {
                kelurahanOptions.forEach(option => {
                    if (option.getAttribute('data-kelurahan-id') === kecamatanId) {
                        option.style.display = 'block';
                    }
                });
            }

            // Reset pilihan jika tidak sesuai
            const selectedOption = kelurahanSelect.options[kelurahanSelect.selectedIndex];
            if (selectedOption && selectedOption.style.display === 'none') {
                kelurahanSelect.value = '';
            }
        }

        // Inisialisasi untuk setiap modal edit
        @foreach ($posyandus as $posyandu)
            (function() {
                const modalId = 'editModal{{ $posyandu->id }}';
                const modalElement = document.getElementById(modalId);

                if (!modalElement) return;

                const puskesmasSelect = modalElement.querySelector('#puskesmas_id{{ $posyandu->id }}');
                const kelurahanSelect = modalElement.querySelector('#kelurahan_id{{ $posyandu->id }}');

                if (!puskesmasSelect || !kelurahanSelect) return;

                // Jalankan saat modal dibuka
                modalElement.addEventListener('show.bs.modal', function() {
                    updateKelurahanOptions(puskesmasSelect, kelurahanSelect);
                });

                // Jalankan saat puskesmas berubah
                puskesmasSelect.addEventListener('change', function() {
                    updateKelurahanOptions(puskesmasSelect, kelurahanSelect);
                });

                // Trigger awal
                updateKelurahanOptions(puskesmasSelect, kelurahanSelect);
            })();
        @endforeach
    });
</script>
