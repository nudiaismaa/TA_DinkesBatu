@extends('layout.index')
@section('title', 'Detail Orang Tua')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('orangtua.anak.create')
                <h4 class="p-4">Detail Orang Tua</h4>
                <x-card class="h-100">
                    <a href="{{ route('orangtua.index') }}" class="btn btn-secondary-color mb-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div class="card border-secondary-subtle rounded-4 mb-3">
                        <div class="card-body table-responsive w-50">
                            <h5 class="mb-3">Orang Tua</h5>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="text-muted">Nama Orang Tua</td>
                                        <td><strong>{{ $orangtua->user->name }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">NIK</td>
                                        <td><strong>{{ $orangtua->nik }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Nomor HP</td>
                                        <td><strong>{{ $orangtua->nomor_hp }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Alamat</td>
                                        <td><strong>{{ $orangtua->alamat_domisili }}</strong></td>
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
                                        <th>Nama Anak</th>
                                        <th>Usia(dalam bulan)</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Anak ke</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orangtua->anak as $anak)
                                        <tr id="anak{{ $anak->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $anak->nama }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(\Carbon\Carbon::now()) }}
                                                Bulan
                                            </td>
                                            <td>{{ $anak->jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan' }}</td>
                                            <td>{{ $anak->anak_ke }}</td>
                                            <td>
                                                <a class="primary-color fs-5" data-bs-toggle="modal"
                                                    data-bs-target="#detailAnakModal{{ $anak->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a class="primary-color fs-5" data-bs-toggle="modal"
                                                    data-bs-target="#movePosyanduModal{{ $anak->id }}">
                                                    <i class="bi bi-database"></i>
                                                </a>
                                                @include('orangtua.anak.detail', ['anak' => $anak])
                                                @include('orangtua.anak.movePosyandu', ['anak' => $anak])
                                            </td>
                                        </tr>
                                        @include('orangtua.anak.edit', [
                                            'anak' => $anak,
                                            'orangtua' => $orangtua,
                                        ])
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if (auth()->user()->hasRole('Posyandu'))
                        <div class="d-flex justify-content-end mb-2">
                            <button id="btn-tambah-data" class="btn btn-primary-color" data-bs-toggle="modal"
                                data-bs-target="#createAnakModal">
                                Tambah Anak +
                            </button>
                        </div>
                    @endif
                </x-card>
                @if (session('success'))
                    <x-toast status='success' title='Berhasil!'>
                        {{ session('success') }}
                    </x-toast>
                @endif
            </div>
        </div>
    </div>
@endsection
