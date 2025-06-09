@extends('layout.index')
@section('title', 'Laporan Perkembangan Anak')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                {{-- @include('users.create') --}}
                <x-card class="h-100">
                    <div class="d-flex justify-content-between mb-3">
                        <form class="d-flex">
                            <input id="searchInput" class="form-control me-2" type="search" placeholder="Search"
                                aria-label="Search">
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover" style="width:100%">
                            <thead class="table primary-thead">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anak</th>
                                    <th>Usia (Dalam Bulan)</th>
                                    <th>Jenis Kelamin</th>
                                    @role('Posyandu')
                                        <th>Status</th>
                                    @endrole
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (Auth::user()->hasRole('Posyandu'))
                                    @foreach ($anak as $a)
                                        @if ($a->posyandu_id == Auth::user()->posyandu->first()->id && $a->isActive())
                                            <tr class="anak-row">
                                                <td class="row-number"></td>
                                                <td>{{ $a->nama }}</td>
                                                <td>{{ \Carbon\Carbon::parse($a->tanggal_lahir)->diffInMonths(\Carbon\Carbon::now()) }}
                                                    Bulan</td>
                                                <td>{{ $a->jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan' }}</td>
                                                <td>
                                                    <form action="{{ route('anak.toggle-active', $a->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input toggle-active" type="checkbox"
                                                                role="switch" id="toggle_{{ $a->id }}"
                                                                data-id="{{ $a->id }}" checked>
                                                            <label class="form-check-label"
                                                                for="toggle_{{ $a->id }}">
                                                                Aktif
                                                            </label>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a class="primary-color fs-5" data-bs-toggle="modal"
                                                        data-bs-target="#detailAnakModal{{ $a->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @include('orangtua.anak.detail', ['anak' => $a])
                                                </td>
                                            </tr>
                                            @include('orangtua.anak.edit', [
                                                'anak' => $a,
                                            ])
                                        @endif
                                    @endforeach

                                    <!-- Kemudian tampilkan anak tidak aktif -->
                                    @foreach ($anak as $a)
                                        @if ($a->posyandu_id == Auth::user()->posyandu->first()->id && !$a->isActive())
                                            <tr class="anak-row">
                                                <td class="row-number"></td>
                                                <td>{{ $a->nama }}</td>
                                                <td>{{ \Carbon\Carbon::parse($a->tanggal_lahir)->diffInMonths(\Carbon\Carbon::now()) }}
                                                    Bulan</td>
                                                <td>{{ $a->jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan' }}</td>
                                                <td>
                                                    <form action="{{ route('anak.toggle-active', $a->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input toggle-active" type="checkbox"
                                                                role="switch" id="toggle_{{ $a->id }}"
                                                                data-id="{{ $a->id }}">
                                                            <label class="form-check-label text-muted"
                                                                for="toggle_{{ $a->id }}">
                                                                Tidak Aktif
                                                            </label>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a class="primary-color fs-5" data-bs-toggle="modal"
                                                        data-bs-target="#detailAnakModal{{ $a->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @include('orangtua.anak.detail', ['anak' => $a])
                                                </td>
                                            </tr>
                                            @include('orangtua.anak.edit', [
                                                'anak' => $a,
                                            ])
                                        @endif
                                    @endforeach
                                @else
                                    <!-- Tampilan untuk Orang Tua -->
                                    @foreach ($anak as $a)
                                        <tr class="anak-row">
                                            <td class="row-number"></td>
                                            <td>{{ $a->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($a->tanggal_lahir)->diffInMonths(\Carbon\Carbon::now()) }}
                                                Bulan</td>
                                            <td>{{ $a->jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan' }}</td>
                                            <td>
                                                <a class="primary-color fs-5"
                                                    href="{{ route('pemeriksaan.show', $a->id) }}">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
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
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateRowNumbers() {
                let counter = 1;
                $('.anak-row:visible').each(function() {
                    $(this).find('.row-number').text(counter++);
                });
            }

            // Inisialisasi nomor urut pertama kali
            updateRowNumbers();
            $('#searchInput').on('keyup', function() {
                const value = $(this).val().toLowerCase();

                $('.anak-row').each(function() {
                    const row = $(this);
                    const text = row.text().toLowerCase();

                    row.toggle(text.indexOf(value) > -1);
                });

                updateRowNumbers();
            });
        });
    </script>
@endsection
