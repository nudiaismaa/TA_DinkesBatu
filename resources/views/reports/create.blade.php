@extends('layout.index')
@section('title', 'Tambah Laporan Perkembangan')
@section('content')
    <div class="container-fluid d-flex flex-grow-1 justify-content-center align-items-start">
        <div class="col-12">
            <h4 class="p-4">Lapor Pemeriksaan Anak</h4>
            <div class="card p-3 shadow rounded-4">
                <div class="card-body">
                    <form class="form" method="POST" action="{{ route('pemeriksaan.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row gap-3 mb-5">
                            <div class="col-12">
                                <input type="hidden" name="posyandu_id" value="{{ Auth::user()->posyandu->first()->id }}">
                                <label for="anak_id" class="form-label">Anak</label>
                                <select class="choices form-select" name="anak_id" id="anak_id">
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
                                        placeholder="Masukkan Berat Badan (Kg)" step="0.01" min="0">

                                </div>
                                <div class="col-6">
                                    <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
                                    <input type="number" id="tinggi_badan" class="form-control" name="tinggi_badan"
                                        placeholder="Masukkan Tinggi Badan (Cm)" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="lingkar_kepala" class="form-label">Lingkar Kepala</label>
                                    <input type="number" id="lingkar_kepala" class="form-control" name="lingkar_kepala"
                                        placeholder="Masukkan Lingkar Kepala (Cm)" step="0.01" min="0">
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
                                <button type="submit" class="btn btn-primary-color w-100">Simpan</button>
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

            statusImunisasi.addEventListener('change', function() {
                if (this.value === 'Diberikan') {
                    imunisasiFields.style.display = 'block';
                } else {
                    imunisasiFields.style.display = 'none';
                }
            });
        });
    </script>
@endsection
