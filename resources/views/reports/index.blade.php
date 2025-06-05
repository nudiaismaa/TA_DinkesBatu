@extends('layout.index')
@section('title', 'Laporan Perkembangan Anak')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                {{-- @include('users.create') --}}
                <x-card class="h-100">
                    <div class="row">
                        @role('Posyandu|Puskesmas|Dinkes Kota Batu|Super Admin')
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex gap-2">
                                    <form class="d-flex">
                                        <input id="searchInput" class="form-control me-2" type="search" placeholder="Search"
                                            aria-label="Search">
                                    </form>
                                    @role('Puskesmas')
                                        <form class="d-flex">
                                            <select class="form-select" id="select-posyandu">
                                                <option value="">Pilih Posyandu</option>
                                                @foreach ($posyandus as $posyandu)
                                                    @if ($posyandu->puskesmas_id == Auth::user()->puskesmas->first()->id)
                                                        <option value="{{ $posyandu->id }}">
                                                            {{ $posyandu->nama_posyandu }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </form>
                                    @endrole
                                    @role('Dinkes Kota Batu')
                                        <form class="d-flex">
                                            <select class="form-select" id="select-puskesmas">
                                                <option value="">Pilih Puskesmas</option>
                                                @foreach ($puskesmas as $p)
                                                    <option value="{{ $p->id }}">
                                                        {{ $p->nama_puskesmas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    @endrole
                                </div>
                                <div>
                                    <a href="{{ route('pemeriksaan.export') }}"
                                        class="btn btn-primary-color d-flex align-items-center gap-2" id="exportButton">
                                        <i class="bi bi-download"></i> Ekspor
                                    </a>
                                </div>
                            </div>
                        @endrole
                    </div>

                    <div class="table-responsive text-center">
                        <table id="dataTable" class="table table-hover" style="width:100%">
                            <thead class="table primary-thead">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anak</th>
                                    <th>Usia (Dalam Bulan)</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1; // Inisialisasi counter manual
                                @endphp
                                @foreach ($anak as $a)
                                    @if (auth()->user()->hasRole('Posyandu'))
                                        @if ($a->posyandu_id == auth()->user()->posyandu->first()->id)
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
                                        @endif
                                    @elseif(auth()->user()->hasRole('Puskesmas'))
                                        @if ($a->posyandu->puskesmas_id == auth()->user()->puskesmas->first()->id)
                                            <tr class="anak-row" data-posyandu="{{ $a->posyandu_id }}">
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
                                        @endif
                                    @else
                                        <tr class="anak-row" data-puskesmas="{{ $a->posyandu->puskesmas_id }}">
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
                                    @endif
                                @endforeach
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
        $(document).ready(function() {
            // Fungsi untuk mengupdate nomor urut dengan benar
        function updateRowNumbers() {
            let counter = 1;
            $('.anak-row:visible').each(function() {
                $(this).find('.row-number').text(counter++);
            });
        }

        // Inisialisasi nomor urut pertama kali
        updateRowNumbers();

        // Filter berdasarkan Puskesmas
        $('#select-puskesmas').on('change', function() {
            const selectedPuskesmas = $(this).val();
            
            $('.anak-row').each(function() {
                const row = $(this);
                const puskesmasId = row.data('puskesmas');
                
                if (!selectedPuskesmas || puskesmasId == selectedPuskesmas) {
                    row.show();
                } else {
                    row.hide();
                }
            });
            
            updateRowNumbers();
        });

        // Filter berdasarkan Posyandu
        $('#select-posyandu').on('change', function() {
            const selectedPosyandu = $(this).val();
            
            $('.anak-row').each(function() {
                const row = $(this);
                const posyanduId = row.data('posyandu');
                
                if (!selectedPosyandu || posyanduId == selectedPosyandu) {
                    row.show();
                } else {
                    row.hide();
                }
            });
            
            updateRowNumbers();
        });

        // Pencarian
        $('#searchInput').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            
            $('.anak-row').each(function() {
                const row = $(this);
                const text = row.text().toLowerCase();
                
                row.toggle(text.indexOf(value) > -1);
            });
            
            updateRowNumbers();
        });

            $('#exportButton').on('click', function(e) {
                e.preventDefault();

                let exportUrl = $(this).attr('href');
                let selectedPuskesmas = $('#select-puskesmas').val();
                let selectedPosyandu = $('#select-posyandu').val();

                if (selectedPuskesmas) {
                    exportUrl += '?puskesmas_id=' + selectedPuskesmas;
                }

                if (selectedPosyandu) {
                    exportUrl += (selectedPuskesmas ? '&' : '?') + 'posyandu_id=' + selectedPosyandu;
                }

                window.location.href = exportUrl;
            });

        });
    </script>
@endsection
