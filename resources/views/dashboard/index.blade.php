@extends('layout.index')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid overflow-auto">
        <div class="row mb-3 g-3 align-items-stretch">
            @role('Puskesmas')
                <div class="col-md-4 col-sm-6 col-12">
                    <x-card class="h-100">
                        <x-slot name="icon">
                            <i class="bi bi-people-fill text-black fs-4"></i>
                        </x-slot>
                        <h5 class="card-title text-muted">Jumlah Anak</h5>
                        <p class="card-text">{{ $anakByPuskesmas }}</p>
                    </x-card>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <x-card class="h-100">
                        <x-slot name="icon">
                            <i class="bi bi-people-fill text-black fs-4"></i>
                        </x-slot>
                        <h5 class="card-title text-muted">Jumlah Orang Tua</h5>
                        <p class="card-text">{{ $countOrangTua }}</p>
                    </x-card>
                </div>
            @endrole
            @role('Posyandu')
                @php
                    $totalBerat = 0;
                    $totalTinggi = 0;
                    $totalPemeriksaan = 0;

                    foreach ($pemeriksaan as $a) {
                        $berat = $pemeriksaan->sum('berat_badan');
                        $tinggi = $pemeriksaan->sum('tinggi_badan');
                        $jumlah = $pemeriksaan->count();

                        $totalBerat += $berat;
                        $totalTinggi += $tinggi;
                        $totalPemeriksaan += $jumlah;
                    }

                    $avgBerat = $totalPemeriksaan > 0 ? $totalBerat / $totalPemeriksaan : null;
                    $avgTinggi = $totalPemeriksaan > 0 ? $totalTinggi / $totalPemeriksaan : null;
                @endphp
                <div class="col-md-4 col-sm-6 col-12">
                    <x-card class="h-100">
                        <x-slot name="icon">
                            <i class="bi bi-hospital-fill text-black fs-4"></i>
                        </x-slot>
                        <h5 class="card-title text-muted">Tempat Pemeriksaan</h5>
                        <p class="card-text">{{ Auth::user()->posyandu->first()->puskesmas->nama_puskesmas }}</p>
                    </x-card>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <x-card class="h-100">
                        <x-slot name="icon">
                            <i class="bi bi-hospital-fill text-black fs-4"></i>
                        </x-slot>
                        <h5 class="card-title text-muted">Avg. Berat Badan</h5>
                        <p class="card-text">{{ $avgBerat !== null ? number_format($avgBerat, 2) . ' kg' : 'Belum ada data' }}
                        </p>
                    </x-card>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <x-card class="h-100">
                        <x-slot name="icon">
                            <i class="bi bi-hospital-fill text-black fs-4"></i>
                        </x-slot>
                        <h5 class="card-title text-muted">Avg. Tinggi Badan</h5>
                        <p class="card-text">{{ $avgTinggi !== null ? number_format($avgTinggi, 2) . ' cm' : 'Belum ada data' }}
                        </p>
                    </x-card>
                </div>
            @endrole
        </div>
        @role('Posyandu|Puskesmas|Dinkes Kota Batu')
            <div class="row mb-3 g-3 align-items-stretch">
                <div class="col-12">
                    <x-card class="h-100">
                        <h5 class="card-title text-muted">Hasil Pemeriksaan Standar Kesehatan Anak</h5>
                        <div id="hasilStandarChart"></div>
                    </x-card>
                </div>
            </div>
        @endrole
        @role('Orang Tua')
            @php
                $dataByAnak = $pemeriksaan->groupBy('anak_id')->map(function ($item) {
                    return [
                        'tanggal' => $item->pluck('tanggal_pemeriksaan'),
                        'tinggi_badan' => $item->pluck('tinggi_badan'),
                        'lingkar_kepala' => $item->pluck('lingkar_kepala'),
                        'berat_badan' => $item->pluck('berat_badan'),
                    ];
                });
            @endphp

            <div class="row mb-3 g-3 align-items-stretch">
                <div class="col-md-6">
                    <label for="anakSelect" class="form-label">Pilih Anak:</label>
                    <select class="form-select" id="anakSelect">
                        @foreach ($anak as $a)
                            @if ($a->orangtua_id == auth()->user()->orangtua->id)
                                <option value="{{ $a->id }}">{{ $a->nama }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <x-card class="h-100">
                        <h5 class="card-title text-muted">Hasil Pemeriksaan Anak</h5>
                        <div id="progressChart" height="400"></div>
                    </x-card>
                </div>
            </div>
        @endrole
    </div>
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
    @role('Posyandu|Puskesmas|Dinkes Kota Batu')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get the pemeriksaan data from Laravel
                const pemeriksaanData = @json($pemeriksaan);

                // Prepare data structure
                const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                const categories = [...monthNames];

                // Initialize series data for each category
                const seriesData = {
                    'Sangat Pendek': new Array(12).fill(0),
                    'Pendek': new Array(12).fill(0),
                    'Normal': new Array(12).fill(0),
                    'Tinggi': new Array(12).fill(0),
                };

                // Process each pemeriksaan record
                pemeriksaanData.forEach(p => {
                    const date = new Date(p.tanggal_pemeriksaan);
                    const month = date.getMonth();

                    switch (p.hasil_standar) {
                        case 0:
                            seriesData['Sangat Pendek'][month]++;
                            break;
                        case 1:
                            seriesData['Pendek'][month]++;
                            break;
                        case 2:
                            seriesData['Normal'][month]++;
                            break;
                        case 3:
                            seriesData['Tinggi'][month]++;
                            break;
                        default:
                            seriesData['Sangat Pendek'][month]++;
                    }
                });

                // Format data for ApexCharts
                const series = [{
                        name: 'Sangat Pendek',
                        data: seriesData['Sangat Pendek'],
                        color: '#dc3545' // Red
                    },
                    {
                        name: 'Pendek',
                        data: seriesData['Pendek'],
                        color: '#fd7e14' // Orange
                    },
                    {
                        name: 'Normal',
                        data: seriesData['Normal'],
                        color: '#28a745' // Green
                    },
                    {
                        name: 'Tinggi',
                        data: seriesData['Tinggi'],
                        color: '#17a2b8' // Cyan
                    },

                ];

                // Chart options
                const options = {
                    series: series,
                    chart: {
                        type: 'bar',
                        height: 500,
                        stacked: false,
                        // stackType: '100%', // Remove this for absolute values
                        toolbar: {
                            show: true
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '70%',
                            endingShape: 'rounded',
                            dataLabels: {
                                position: 'top' // Position of the data labels
                            }
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: categories,
                        title: {
                            text: 'Bulan'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Jumlah'
                        },
                        min: 0
                    },
                    legend: {
                        position: 'bottom',
                        markers: {
                            radius: 2
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + " anak";
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom',
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }]
                };

                // Render chart
                const chart = new ApexCharts(document.querySelector("#hasilStandarChart"), options);
                chart.render();
            });
        </script>
    @endrole

    @role('Orang Tua')
        <script>
            const dataByAnak = @json($dataByAnak);
            document.addEventListener("DOMContentLoaded", function() {
                const anakSelect = document.getElementById('anakSelect');
                const chartEl = document.querySelector("#progressChart");

                let chart;

                function renderChart(data) {
                    const options = {
                        chart: {
                            type: 'line',
                            height: 500
                        },
                        series: [{
                                name: 'Tinggi Badan (cm)',
                                data: data.tinggi_badan
                            },
                            {
                                name: 'Lingkar Kepala (cm)',
                                data: data.lingkar_kepala
                            },
                            {
                                name: 'Berat Badan (kg)',
                                data: data.berat_badan
                            }
                        ],
                        xaxis: {
                            categories: data.tanggal,
                            title: {
                                text: 'Tanggal Pemeriksaan'
                            },
                            labels: {
                                formatter: function(value) {
                                    return new Date(value).toLocaleDateString('id-ID', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric'
                                    });
                                }
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Nilai'
                            }
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 3
                        },
                        markers: {
                            size: 4
                        },
                        tooltip: {
                            shared: true,
                            intersect: false
                        },
                        legend: {
                            position: 'top'
                        }
                    };

                    if (chart) {
                        chart.updateOptions(options);
                    } else {
                        chart = new ApexCharts(chartEl, options);
                        chart.render();
                    }
                }

                anakSelect.addEventListener("change", function() {
                    const anakId = anakSelect.value;
                    const data = dataByAnak[anakId];
                    if (data) {
                        renderChart(data);
                    }
                });

                if (anakSelect.value) {
                    renderChart(dataByAnak[anakSelect.value]);
                }
            });
        </script>
    @endrole
@endsection
