@extends('layout.index')
@section('title', 'Detail Puskesmas')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="p-4">Detail Puskesmas</h4>
                <x-card class="h-100">
                    <a href="{{ route('puskesmas.index') }}" class="btn btn-secondary-color mb-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div class="card border-secondary-subtle rounded-4 mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <strong>Nama Puskesmas</strong>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-8">
                                    {{ $puskesmas->nama_puskesmas }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <strong>Kecamatan</strong>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-8">
                                    {{ $puskesmas->kecamatan->nama }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <strong>Alamat</strong>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-8">
                                    {{ $puskesmas->alamat }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <strong>RT</strong>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-8">
                                    {{ $puskesmas->rt }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <strong>RW</strong>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-8">
                                    {{ $puskesmas->rw }}
                                </div>
                            </div>
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
