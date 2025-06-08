@extends('layout.index')
@section('title', 'Daftar Orang Tua')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="p-4">Data Orang Tua</h4>
                <x-card class="h-100">
                    <div class="d-flex justify-content-between mb-3">
                        <form class="d-flex">
                            <input class="form-control me-2" id="searchInput" type="search" placeholder="Search" aria-label="Search">
                        </form>
                        @if (auth()->user()->hasRole('Posyandu'))
                            @include('orangtua.create')
                            <button id="btn-tambah-data" class="btn btn-secondary-color" data-bs-toggle="modal"
                                data-bs-target="#createOrangTuaModal">
                                Tambah Data Orang Tua
                            </button>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-center w-100">
                            <thead class="table primary-thead">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Orang Tua</th>
                                    <th>No. Telp</th>
                                    <th>Alamat</th>
                                    <th>Jumlah Anak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orangtua as $user)
                                    @php
                                        $counter = 1; // Inisialisasi counter manual
                                    @endphp
                                    @role('Posyandu')
                                        @if ($user->kelurahan->id == Auth::user()->posyandu->first()->kelurahan_id)
                                            <tr class="anak-row" id="user_{{ $user->id }}">
                                                <td class="row-number"></td>
                                                <td>{{ $user->user->name }}</td>
                                                <td>{{ $user->nomor_hp }}</td>
                                                <td>{{ $user->kelurahan->nama }}</td>
                                                <td>
                                                    @if ($user->anak->count() > 0)
                                                        {{ $user->anak->count() }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="primary-color fs-5"
                                                        href="{{ route('orangtua.show', $user->id) }}">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endif
                                        @elserole('Puskesmas')
                                        @if ($user->kelurahan->kecamatan_id == Auth::user()->puskesmas->first()->kecamatan_id)
                                            <tr class="anak-row" id="user_{{ $user->id }}">
                                                <td class="row-number"></td>

                                                <td>{{ $user->user->name }}</td>
                                                <td>{{ $user->nomor_hp }}</td>
                                                <td>{{ $user->kelurahan->nama }}</td>
                                                <td>
                                                    @if ($user->anak->count() > 0)
                                                        {{ $user->anak->count() }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="primary-color fs-5"
                                                        href="{{ route('orangtua.show', $user->id) }}">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr class="anak-row" id="user_{{ $user->id }}">
                                            <td class="row-number"></td>

                                            <td>{{ $user->user->name }}</td>
                                            <td>{{ $user->nomor_hp }}</td>
                                            <td>{{ $user->kelurahan->nama }}</td>
                                            <td>
                                                @if ($user->anak->count() > 0)
                                                    {{ $user->anak->count() }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <a class="primary-color fs-5" href="{{ route('orangtua.show', $user->id) }}">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endrole
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
        $(document).ready(function() {
            $('#btn-tambah-data').on('click', function() {
                // Initialize SmartWizard when the modal is opened
                $('#smartwizard').smartWizard({
                    theme: 'dots',
                    justified: true,
                    lang: {
                        next: 'Lanjut',
                        previous: 'Sebelumnya'
                    }
                });

                // Custom button actions
                $("#btn-next").on("click", function() {
                    $("#smartwizard").smartWizard("next");
                });

                $("#smartwizard").on("showStep", function(e, anchorObject, stepIndex, stepDirection,
                    stepPosition) {
                    $(".sw-btn-next, .sw-btn-prev").hide();
                    if (stepPosition === "last") {
                        $("#btn-next").hide(); // Sembunyikan tombol Next
                        $("#btn-submit").removeClass("d-none"); // Tampilkan tombol Submit
                    } else {
                        $("#btn-next").show(); // Tampilkan tombol Next
                        $("#btn-submit").addClass("d-none"); // Sembunyikan tombol Submit
                    }
                });
            });
        });
    </script>
@endsection
