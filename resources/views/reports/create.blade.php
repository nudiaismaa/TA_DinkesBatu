@extends('layout.index')
@section('title', 'Tambah Laporan Perkembangan')
@section('content')
<div class="container-fluid d-flex flex-grow-1 justify-content-center align-items-start">
    <div class="col-12">
        <h4 class="p-4">Lapor Pemeriksaan Anak</h4>
        <div class="card p-3 shadow rounded-4">
            <div class="card-body">
                <div id="existingDataAlert" class="alert alert-info alert-dismissible fade show" style="display: none;">
                    <strong>Informasi:</strong> Pemeriksaan untuk anak ini sudah pernah dilakukan hari ini. Data yang sudah ada akan ditampilkan di form. Anda dapat melengkapi atau memperbarui data yang masih kosong.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

                <form class="form" method="POST" action="{{ route('pemeriksaan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="existing_pemeriksaan_id" id="existing_pemeriksaan_id">
                    <div class="row gap-3 mb-5">
                        <div class="col-12">
                            <input type="hidden" name="posyandu_id" value="{{ Auth::user()->posyandu->first()->id }}">
                            <label for="anak_id" class="form-label">Anak <span class="text-danger">*</span></label>
                            <select class="choices form-select" name="anak_id" id="anak_id" required>
                                <option value="">-- Pilih Anak --</option>
                                @foreach ($anak->where('posyandu_id', Auth::user()->posyandu->first()->id) as $a)
                                <option value="{{ $a->id }}">{{ $a->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="berat_badan" class="form-label">Berat Badan</label>
                                <input type="number" id="berat_badan" class="form-control" name="berat_badan"
                                    placeholder="Masukkan Berat Badan (Kg)" step="0.01">
                            </div>
                            <div class="col-6">
                                <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
                                <input type="number" id="tinggi_badan" class="form-control" name="tinggi_badan"
                                    placeholder="Masukkan Tinggi Badan (Cm)" step="0.01">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="lingkar_kepala" class="form-label">Lingkar Kepala</label>
                                <input type="number" id="lingkar_kepala" class="form-control" name="lingkar_kepala"
                                    placeholder="Masukkan Lingkar Kepala (Cm)" step="0.01">
                            </div>
                            <div class="col-6">
                                <label for="status_imunisasi" class="form-label">Status Imunisasi</label>
                                <select class="form-select" name="status_imunisasi" id="status_imunisasi">
                                    <option value="Belum Diberikan">Tidak Ada Imunisasi</option>
                                    <option value="Diberikan">Diberikan Imunisasi</option>
                                </select>
                            </div>
                        </div>
                        <div id="imunisasiFields" style="display: none;">
                            <div class="col-12">
                                <label for="jenis_imunisasi" class="form-label">Jenis Imunisasi</label>
                                <select class="form-select" name="jenis_imunisasi" id="jenis_imunisasi">
                                    @foreach ($jenisImunisasi as $imunisasi)
                                    <option value="{{ $imunisasi->id }}">
                                        {{ $imunisasi->nama_imunisasi }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="keterangan" class="form-label">Keterangan Imunisasi</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="catatan_pemeriksaan" class="form-label">Catatan</label>
                            <textarea type="text" id="catatan_pemeriksaan" class="form-control" name="catatan_pemeriksaan" rows="4"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary-color w-100" id="submitBtn">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const anakSelect = new Choices('#anak_id', {
            searchEnabled: true,
            searchPlaceholderValue: "Cari nama anak...",
            noResultsText: 'Tidak ada hasil yang ditemukan',
            itemSelectText: 'Tekan untuk memilih',
            removeItemButton: true,
            placeholderValue: "-- Pilih Anak --",
        });

        const statusImunisasi = document.getElementById('status_imunisasi');
        const imunisasiFields = document.getElementById('imunisasiFields');
        const existingDataAlert = document.getElementById('existingDataAlert');
        const submitBtn = document.getElementById('submitBtn');

        statusImunisasi.addEventListener('change', function() {
            if (this.value === 'Diberikan') {
                imunisasiFields.style.display = 'block';
            } else {
                imunisasiFields.style.display = 'none';
            }
        });

        anakSelect.passedElement.element.addEventListener('change', function() {
            const anakId = this.value;

            clearForm();

            if (anakId) {
                checkTodayExamination(anakId);
            }
        });

        function checkTodayExamination(anakId) {
            if (!anakId) return;

            disableForm(true);

            fetch('{{ route('pemeriksaan.check-today') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            anak_id: anakId
                        })
                    })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        fillForm(data.data);
                        showAlert();
                        submitBtn.textContent = 'Perbarui Data';
                    } else {
                        clearForm();
                        hideAlert();
                        submitBtn.textContent = 'Simpan';
                        disableForm(false);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengecek data pemeriksaan');
                    disableForm(false);
                    hideAlert();
                });
        }

        function fillForm(data) {
            clearForm();

            if (data.id) {
                document.getElementById('existing_pemeriksaan_id').value = data.id;
            }

            const fields = {
                'berat_badan': data.berat_badan,
                'tinggi_badan': data.tinggi_badan,
                'lingkar_kepala': data.lingkar_kepala,
                'catatan_pemeriksaan': data.catatan_pemeriksaan
            };

            for (const [fieldId, value] of Object.entries(fields)) {
                const field = document.getElementById(fieldId);
                if (value) {
                    field.value = value;
                    field.disabled = true;
                } else {
                    field.value = '';
                    field.disabled = false;
                }
            }

            const statusImunisasi = document.getElementById('status_imunisasi');
            if (data.status_imunisasi) {
                statusImunisasi.value = data.status_imunisasi;
                statusImunisasi.disabled = true;

                if (data.status_imunisasi === 'Diberikan') {
                    imunisasiFields.style.display = 'block';

                    const jenisImunisasi = document.getElementById('jenis_imunisasi');
                    const keterangan = document.getElementById('keterangan');

                    if (data.jenis_imunisasi && data.jenis_imunisasi.length > 0) {
                        jenisImunisasi.value = data.jenis_imunisasi[0];
                        jenisImunisasi.disabled = true;
                    } else {
                        jenisImunisasi.value = '';
                        jenisImunisasi.disabled = false;
                    }

                    if (data.keterangan) {
                        keterangan.value = data.keterangan;
                        keterangan.disabled = true;
                    } else {
                        keterangan.value = '';
                        keterangan.disabled = false;
                    }
                }
            } else {
                statusImunisasi.value = 'Belum Diberikan';
                statusImunisasi.disabled = false;
                imunisasiFields.style.display = 'none';
            }
        }

        function clearForm() {
            document.getElementById('existing_pemeriksaan_id').value = '';

            const fields = ['berat_badan', 'tinggi_badan', 'lingkar_kepala', 'catatan_pemeriksaan'];
            fields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.value = '';
                    field.disabled = false;
                }
            });

            const statusImunisasi = document.getElementById('status_imunisasi');
            statusImunisasi.value = 'Belum Diberikan';
            statusImunisasi.disabled = false;

            const jenisImunisasi = document.getElementById('jenis_imunisasi');
            if (jenisImunisasi) {
                jenisImunisasi.value = '';
                jenisImunisasi.disabled = false;
            }

            const keterangan = document.getElementById('keterangan');
            if (keterangan) {
                keterangan.value = '';
                keterangan.disabled = false;
            }

            imunisasiFields.style.display = 'none';

            submitBtn.textContent = 'Simpan';

            hideAlert();
        }

        function disableForm(disabled) {
            const form = document.querySelector('.form');
            const inputs = form.querySelectorAll('input:not([type="hidden"]), select, textarea');

            inputs.forEach(input => {
                if (input.id !== 'anak_id' && input.id !== 'submitBtn') {
                    input.disabled = disabled;
                }
            });
        }

        function showAlert() {
            existingDataAlert.style.display = 'block';
        }

        function hideAlert() {
            existingDataAlert.style.display = 'none';
        }
    });
</script>
@endsection