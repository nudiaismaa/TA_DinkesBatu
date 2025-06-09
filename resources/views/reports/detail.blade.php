@extends('layout.index')
@section('title', 'Detail Anak')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="p-4">Detail Anak</h4>
                <x-card class="h-100">
                    <div class="d-flex justify-content-between mb-3">
                        @if (auth()->user()->hasRole('Orang Tua'))
                            <a href="{{ route('laporan.show') }}" class="btn btn-secondary-color">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        @else
                            <a href="{{ route('pemeriksaan.index') }}" class="btn btn-secondary-color">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        @endif
                        <a href="{{ route('pemeriksaan.export-excel', $anak->id) }}"
                            class="btn btn-primary-color d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-excel"></i> Ekspor
                        </a>
                    </div>
                    <div class="card border-secondary-subtle rounded-4 mb-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Data Anak</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="text-muted">Nama Anak</td>
                                                <td><strong>{{ $anak->nama }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tanggal Lahir</td>
                                                <td><strong>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->locale('id')->isoFormat('D MMMM Y') }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Jenis Kelamin</td>
                                                <td><strong>
                                                        {{ $anak->jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan' }}
                                                    </strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">NIK</td>
                                                <td><strong> {{ $anak->nik }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="text-muted">Anak Ke</td>
                                                <td><strong>{{ $anak->anak_ke }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Berat Badan saat Lahir</td>
                                                <td><strong>{{ number_format($anak->berat_badan_saat_lahir, 2) }} kg</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Puskesmas</td>
                                                <td><strong> {{ $anak->posyandu->puskesmas->nama_puskesmas }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Posyandu</td>
                                                <td><strong> {{ $anak->posyandu->nama_posyandu }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-hover text-center w-100">
                                <thead class="table primary-thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pemeriksaan</th>
                                        <th>Berat Badan</th>
                                        <th>Tinggi Badan</th>
                                        <th>Lingkar Kepala</th>
                                        <th>Status Imunisasi</th>
                                        <th>Standar Kesehatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pemeriksaan as $p)
                                        <tr id="anak{{ $anak->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($p->tanggal_pemeriksaan)->format('d-m-Y') }}
                                            </td>
                                            <td>{{ $p->berat_badan }} kg</td>
                                            <td>{{ $p->tinggi_badan }} cm</td>
                                            <td>{{ $p->lingkar_kepala }} cm</td>
                                            <td>
                                                @if ($p->imunisasi && $p->imunisasi->status_imunisasi === 'Diberikan')
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                                    </div>
                                                @else
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    @switch($p->hasil_standar)
                                                        @case(0)
                                                            <i class="bi bi-x-circle-fill text-danger fs-5"> Sangat Pendek</i>
                                                            <small class="text-muted">Z-Score &lt; -3 SD</small>
                                                        @break

                                                        @case(1)
                                                            <i class="bi bi-exclamation-circle-fill text-warning fs-5"> Pendek</i>
                                                            <small class="text-muted">-3 SD ≤ Z-Score &lt; -2 SD</small>
                                                        @break

                                                        @case(2)
                                                            <i class="bi bi-check-circle-fill text-success fs-5"> Normal</i>
                                                            <small class="text-muted">-2 SD ≤ Z-Score ≤ +3 SD</small>
                                                        @break

                                                        @case(3)
                                                            <i class="bi bi-arrow-up-circle-fill text-info fs-5"> Tinggi</i>
                                                            <small class="text-muted">Z-Score &gt; +3 SD</small>
                                                        @break

                                                        @default
                                                            <i class="bi bi-question-circle-fill text-secondary fs-5"> Tidak
                                                                Diketahui</i>
                                                    @endswitch
                                                </div>
                                            </td>
                                            <td>
                                                <a class="primary-color fs-5" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $p->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @can('edit pemeriksaan')
                                                    <a class="primary-color fs-5"
                                                        href="{{ route('pemeriksaan.edit', $p->id) }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @endcan
                                                @include('reports.detailModal', [
                                                    'pemeriksaan' => $p,
                                                    'anak' => $anak,
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </x-card>
                @if (session('success'))
                    <x-toast>
                        <x-slot name="title">
                            Berhasil!
                        </x-slot>
                        {{ session('success') }}
                    </x-toast>
                @endif
            </div>
        </div>
    </div>
@endsection
