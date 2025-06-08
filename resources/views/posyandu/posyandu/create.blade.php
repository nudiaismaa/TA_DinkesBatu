<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Posyandu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('posyandu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row gap-3">
                        <div class="col-12">
                            <label for="nama_posyandu" class="form-label">Nama Posyandu</label>
                            <input type="text" id="nama_posyandu" class="form-control" name="nama_posyandu"
                                placeholder="Nama Posyandu..." required>
                        </div>
                        <div class="col-12">
                            <label for="puskesmas_id" class="form-label">Puskesmas</label>
                            <select class="form-select" name="puskesmas_id" id="puskesmas_id">
                                <option value="">Pilih Puskesmas</option>
                                @foreach ($puskesmas as $p)
                                    <option value="{{ $p->id }}"
                                        data-kecamatan-id="{{ $p->kecamatan_id ?? '' }}">
                                        {{ $p->nama_puskesmas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="kelurahan_id" class="form-label">Alamat Posyandu</label>
                            <select class="form-select" name="kelurahan_id" id="kelurahan_id">
                                <option value="">Pilih Kelurahan</option>
                                @foreach ($kelurahans as $k)
                                    <option value="{{ $k->id }}" data-kelurahan-id="{{ $k->kecamatan_id }}"
                                        style="display: none;">
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="rt" class="form-label">RT</label>
                            <input type="number" id="rt" name="rt" class="form-control"
                                placeholder="Nomor RT..." required>
                        </div>
                        <div class="col-12">
                            <label for="rw" class="form-label">RW</label>
                            <input type="number" id="rw" name="rw" class="form-control"
                                placeholder="Nomor RW..." required>
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

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const puskesmasSelect = document.getElementById('puskesmas_id');
            const kelurahanSelect = document.getElementById('kelurahan_id');
            const kelurahanOptions = kelurahanSelect.querySelectorAll('option[data-kelurahan-id]');

            puskesmasSelect.addEventListener('change', function() {
                // Reset kelurahan dropdown
                kelurahanSelect.value = '';

                // Hide all kelurahan options first
                kelurahanOptions.forEach(option => {
                    option.style.display = 'none';
                });

                // Show the default "Pilih Kelurahan" option
                kelurahanSelect.querySelector('option[value=""]').style.display = 'block';

                const selectedPuskesmas = this.options[this.selectedIndex];
                const kecamatanId = selectedPuskesmas.getAttribute('data-kecamatan-id');

                // If a puskesmas is selected and has kecamatan_id
                if (this.value && kecamatanId) {
                    // Show kelurahans that belong to the selected kecamatan
                    kelurahanOptions.forEach(option => {
                        if (option.getAttribute('data-kelurahan-id') === kecamatanId) {
                            option.style.display = 'block';
                        }
                    });
                }
            });

            // Trigger change event initially in case there's a default selected puskesmas
            puskesmasSelect.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
