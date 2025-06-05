@extends('layout.index')
@section('title', 'Profil Anak')
@section('content')
    <div class="container-fluid overflow-auto">
        @role('Puskesmas')
        <div class="row mb-3">
            <div class="col-md-4">
                <select class="form-select" id="posyandu-filter">
                    <option value="">Semua Posyandu</option>
                    @foreach($posyandus as $posyandu)
                        <option value="{{ $posyandu->id }}">{{ $posyandu->nama_posyandu }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endrole

        <div class="row mb-3 g-3 align-items-stretch" id="anak-container">
            @foreach ($anak as $a)
                <div class="col-md-6 col-lg-4 col-sm-12" data-posyandu="{{ $a->posyandu_id }}">
                    <x-card class="h-100">
                        <p class="text-muted mb-0">Nama</p>
                        <h5 class="card-title mb-3">{{ $a->nama }}</h4>
                            <div class="row gap-3">
                                <div class="col-5">
                                    <p class="text-muted mb-1">Usia</p>
                                    <p class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($a->tanggal_lahir)->diffInMonths(\Carbon\Carbon::now()) }}
                                        Bulan</p>
                                </div>
                                <div class="col-5">
                                    <p class="text-muted mb-1">Jenis Kelamin</p>
                                    <p class="fw-semibold">
                                        {!! $a->jenis_kelamin == 'L'
                                            ? '<i class="bi bi-gender-male text-primary fw-semibold"></i> Laki - Laki'
                                            : '<i class="bi bi-gender-female text-primary fw-semibold"></i> Perempuan' !!}
                                    </p>
                                </div>
                                <div class="col-5">
                                    <p class="text-muted mb-1">Berat Badan</p>
                                    <p class="fw-semibold">{{ $a->berat_badan_saat_lahir ?? '-' }} Kg</p>
                                </div>
                                <div class="col-5">
                                    <p class="text-muted mb-1">Tinggi Badan</p>
                                    <p class="fw-semibold">
                                        {{ $a->pemeriksaan->sortByDesc('tanggal_pemeriksaan')->first()->tinggi_badan ?? '-' }}
                                        Cm
                                    </p>
                                </div>
                                <div class="col-5">
                                    <p class="text-muted mb-1">Tinggi Badan</p>
                                    <p class="fw-semibold">
                                        {{ $a->pemeriksaan->sortByDesc('tanggal_pemeriksaan')->first()->lingkar_kepala ?? '-' }}
                                        Cm
                                    </p>
                                </div>
                            </div>
                    </x-card>
                </div>
            @endforeach
        </div>
    </div>
    @if (session('success'))
        <x-toast status='success' title='Berhasil!'>
            {{ session('success') }}
        </x-toast>
    @endif
    @if (session('error'))
        <x-toast status='error' title='Gagal!'>
            {{ session('error') }}
        </x-toast>
    @endif
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#posyandu-filter').on('change', function() {
            const selectedPosyandu = $(this).val();
            
            $('.col-md-6').each(function() {
                const card = $(this);
                const posyanduId = card.data('posyandu');
                
                if (!selectedPosyandu || selectedPosyandu === posyanduId) {
                    card.show();
                } else {
                    card.hide();
                }
            });
        });
    });
</script>
@endsection
