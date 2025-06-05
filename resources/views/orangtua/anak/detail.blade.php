<div class="modal fade" id="detailAnakModal{{ $anak->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Anak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start table-responsive">
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
                            <td class="text-muted">Posyandu</td>
                            <td><strong>{{ $anak->posyandu->nama_posyandu }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jenis Kelamin</td>
                            <td><strong>
                                    @if ($anak->jenis_kelamin == 'L')
                                    Laki-laki
                                    @elseif ($anak->jenis_kelamin == 'P')
                                    Perempuan
                                    @else
                                    -
                                    @endif
                                </strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Alamat</td>
                            <td><strong>{{ $anak->alamat }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Lahir</td>
                            <td><strong>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Usia</td>
                            <td><strong>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(\Carbon\Carbon::now()) }}
                                    bulan</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Anak Ke</td>
                            <td><strong>{{ $anak->anak_ke }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Berat Badan saat Lahir</td>
                            <td><strong>{{ number_format($anak->berat_badan_saat_lahir, 1) }} kg</strong></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <h5>Riwayat Posyandu</h5>
                <table class="table table-hover" style="width:100%">
                    <thead class="table primary-thead">
                        <th>No</th>
                        <th>Nama Posyandu</th>
                        <th>Tanggal Pindah</th>
                    </thead>
                    <tbody>
                        @forelse($anak->riwayat as $index => $riwayat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $riwayat->posyandu->nama_posyandu }}</td>
                                <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_pindah)->format('d F Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada riwayat perpindahan posyandu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="modal-footer d-flex justify-content-between align-items-center">
                @role('Posyandu')
                <div class="me-auto">
                    <form action="{{ route('anak.destroy', $anak->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-danger p-0 border-0 bg-transparent">
                            <i class="bi bi-trash fs-5"></i>
                        </button>
                    </form>
                </div>
                <div class="mr-auto">
                    <button type="button" class="btn btn-primary-color" data-bs-toggle="modal"
                        data-bs-target="#editAnakModal{{ $anak->id }}">
                        Edit <i class="bi bi-pen fs-6"></i>
                    </button>
                    <button type="button" class="btn btn-secondary-color" data-bs-dismiss="modal">Tutup</button>
                </div>
                @endrole
            </div>
        </div>
    </div>
</div>