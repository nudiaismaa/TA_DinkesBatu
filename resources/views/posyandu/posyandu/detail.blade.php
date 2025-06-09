@extends('layout.index')
@section('title', 'Detail Posyandu')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="p-4">Detail Posyandu</h4>
                <x-card class="h-100">
                    <a href="{{ route('posyandu.index') }}" class="btn btn-secondary-color mb-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div class="card border-secondary-subtle rounded-4 mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <strong>Nama Posyandu</strong>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-8">
                                    {{ $posyandu->nama_posyandu }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <strong>Kelurahan</strong>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-8">
                                    {{ $posyandu->kelurahan->nama }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <strong>RW</strong>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-8">
                                    {{ $posyandu->rt }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <strong>RW</strong>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-8">
                                    {{ $posyandu->rw }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Jadwal Posyandu</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover text-center w-100">
                                <thead class="table primary-thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posyandu->jadwal_posyandu as $jadwal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d F Y') }}</td>
                                            <td>{{ $jadwal->deskripsi }}</td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </x-card>
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
            </div>
        </div>
    </div>
@endsection
