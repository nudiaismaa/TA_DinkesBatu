<div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pemeriksaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="text-muted">Tanggal Pemeriksaan</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Berat Badan</td>
                            <td>{{ $p->berat_badan }} kg</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tinggi Badan</td>
                            <td>{{ $p->tinggi_badan }} cm</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Lingkar Kepala</td>
                            <td>{{ $p->lingkar_kepala }} cm</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status Imunisasi</td>
                            <td>
                                @if ($p->imunisasi && $p->imunisasi->status_imunisasi === 'Diberikan')
                                <div class="d-flex flex-column">
                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                </div>
                                @else
                                <div class="d-flex flex-column">
                                    <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jenis Imunisasi</td>
                            <td>
                                @if ($p->imunisasi && $p->imunisasi->status_imunisasi === 'Diberikan')
                                <small class="text-muted">
                                    {{ $p->imunisasi->first()->jenis_imunisasi->pluck('nama_imunisasi')->join(', ') }}
                                </small>
                                @else
                                <small class="text-muted">Tidak ada imunisasi</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Pemberian</td>
                            <td>
                                {!! optional($p->imunisasi)->tanggal_pemberian ?: '<small class="text-muted">Belum Diberikan</small>' !!}

                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Keterangan Imunisasi</td>
                            <td>{!! optional($p->imunisasi)->keterangan ?? '<small class="text-muted">Belum Ada</small>' !!}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Catatan Pemeriksaan</td>
                            <td>{{ $p->catatan_pemeriksaan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>