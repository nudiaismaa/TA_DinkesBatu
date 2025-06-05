@extends('layout.index')
@section('title', 'Jadwal Posyandu')
@section('content')
    <x-card class="h-100">
        <div class="row">
            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex">
                    @role('Posyandu')
                        <h4>Jadwal {{ Auth::user()->posyandu->first()->nama_posyandu }}</h4>
                    @else
                        <h4>Jadwal {{ Auth::user()->orangtua->anak->first()->posyandu->nama_posyandu }}</h4>
                    @endrole
                </div>
                <form class="d-flex">
                    <input id="searchInput" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                </form>
            </div>
            <div class="table-responsive">
                <table id="dataTable" class="table table-hover" style="width:100%">
                    <thead class="table primary-thead">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            @role('Posyandu')
                                <th>Aksi</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @role('Posyandu')
                            @php
                                $jadwal = Auth::user()->posyandu->first()->jadwal_posyandu;
                            @endphp
                        @endrole
                        @foreach ($jadwal as $j)
                            @php
                                $counter = 1;
                            @endphp
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ \Carbon\Carbon::parse($j->tanggal)->locale('id')->isoFormat('D MMMM Y') }}</td>
                                <td>{{ $j->deskripsi }}</td>
                                @role('Posyandu')
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editJadwalModal{{ $j->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('jadwalPosyandu.destroy', $j->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                @endrole
                                @include('posyandu.posyandu.jadwal.edit', ['jadwal' => $j])
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @role('Posyandu')
            @include('posyandu.posyandu.jadwal.create')
            <div class="d-flex justify-content-end mb-2">
                <button id="btn-tambah-data" class="btn btn-primary-color" data-bs-toggle="modal"
                    data-bs-target="#createJadwalModal">
                    Tambah Jadwal +
                </button>
            </div>
        @endrole
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
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('dataTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();
                for (let i = 0; i < rows.length; i++) {
                    const namaPosyanduCell = rows[i].getElementsByTagName('td')[1];
                    if (namaPosyanduCell) {
                        const namaPosyandu = namaPosyanduCell.textContent || namaPosyanduCell.innerText;
                        rows[i].style.display = namaPosyandu.toLowerCase().includes(filter) ? '' : 'none';
                    }
                }
            });
        });
    </script>
@endsection
