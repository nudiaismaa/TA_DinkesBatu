@extends('layout.index')
@section('title', 'Detail Anak')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="p-4">Detail Anak</h4>
            <x-card class="h-100">
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('anak.index') }}" class="btn btn-secondary-color">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
                <div class="card border-secondary-subtle rounded-4 mb-3">
                    <div class="card-body w-50">
                        <h5 class="card-title mb-3">Data Anak</h5>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted">Nama Anak</td>
                                    <td><strong>{{ $anak->nama }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">NIK</td>
                                    <td><strong>{{ $anak->nik }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jenis Kelamin</td>
                                    <td><strong>
                                            {{ $anak->jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan' }}
                                        </strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Puskesmas</td>
                                    <td><strong> {{ $anak->posyandu->puskesmas->nama_puskesmas }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
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
                                        @if ($p->imunisasi->first() && $p->imunisasi->first()->status_imunisasi === 'Diberikan')
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
                                        @if ($p->status_imunisasi === 0)
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-check-circle-fill text-success fs-5"> Stunting</i>

                                        </div>
                                        @else
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-x-circle-fill text-danger fs-5"> Sehat</i>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="primary-color fs-5" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $p->id }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
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