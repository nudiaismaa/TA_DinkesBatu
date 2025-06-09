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
                $dataByAnak = $pemeriksaan->groupBy('anak_id')->map(function ($items, $anak_id) {
                    $anak = $items->first()->anak;
                    $tanggal_lahir = Carbon\Carbon::parse($anak->tanggal_lahir);
                    $bulan = [];
                    $tinggi_badan = [];
                    $marker_colors = [];
                    $standar_kategori = [];

                    foreach ($items as $item) {
                        $diffMonth = $tanggal_lahir->diffInMonths(Carbon\Carbon::parse($item->tanggal_pemeriksaan));
                        $bulan[] = $diffMonth;
                        $tinggi_badan[] = $item->tinggi_badan;

                        $standar_kategori[] = match ($item->hasil_standar) {
                            0 => 'Sangat Pendek',
                            1 => 'Pendek',
                            2 => 'Normal',
                            3 => 'Tinggi',
                            default => 'Tidak Diketahui',
                        };

                        $marker_colors[] = match ($item->hasil_standar) {
                            0 => '#dc3545',
                            1 => '#fd7e14',
                            2 => '#28a745',
                            3 => '#17a2b8',
                            default => '#7f8c8d',
                        };
                    }

                    return [
                        'bulan' => $bulan,
                        'tinggi_badan' => $tinggi_badan,
                        'marker_colors' => $marker_colors,
                        'standar_kategori' => $standar_kategori,
                        'nama_anak' => $anak->nama,
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
                    if (chart) {
                        chart.destroy(); // Hapus chart lama dulu
                    }

                    const scatterData = data.tinggi_badan.map((val, i) => ({
                        x: data.bulan[i],
                        y: val,
                        fillColor: data.marker_colors[i]
                    }));

                    const lineData = data.tinggi_badan.map((val, i) => ({
                        x: data.bulan[i],
                        y: val
                    }));

                    const options = {
                        chart: {
                            height: 500,
                            type: 'line',
                            zoom: {
                                enabled: true,
                                type: 'xy'
                            }
                        },
                        series: [{
                                name: 'Garis Pertumbuhan',
                                type: 'line',
                                data: lineData
                            },
                            {
                                name: 'Tinggi Badan',
                                type: 'scatter',
                                data: scatterData,
                                customCategories: data.standar_kategori // Pastikan ini diperbarui
                            }
                        ],
                        markers: {
                            size: 8,
                            strokeColors: '#ffffff',
                            strokeWidth: 2
                        },
                        stroke: {
                            width: [2, 0],
                            curve: 'smooth'
                        },
                        xaxis: {
                            title: {
                                text: 'Usia dalam Bulan'
                            },
                            type: 'numeric',
                            min: 1,
                            max: Math.max(...data.bulan),
                            categories: data.bulan,
                            labels: {
                                formatter: val => `Bulan ke-${val}`
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Tinggi Badan (cm)'
                            },
                            min: 0,
                            max: Math.max(...data.tinggi_badan) + 10
                        },
                        tooltip: {
                            shared: false,
                            intersect: true,
                            custom: function({
                                seriesIndex,
                                dataPointIndex,
                                w
                            }) {
                                const point = w.config.series[seriesIndex].data[dataPointIndex];
                                const kategori = w.config.series[seriesIndex].customCategories?.[
                                    dataPointIndex
                                ] || "Tidak Diketahui";

                                return `
                    <div style="padding: 5px">
                        <strong>Bulan ke-${point.x}</strong><br>
                        Tinggi Badan: ${point.y} cm<br>
                        Kategori: <strong>${kategori}</strong>
                    </div>
                `;
                            }
                        },
                        legend: {
                            show: true
                        },
                        colors: ['#007bff', '#000000']
                    };

                    chart = new ApexCharts(chartEl, options);
                    chart.render();
                }


                anakSelect.addEventListener("change", function() {
                    const anakId = anakSelect.value;
                    const data = dataByAnak[anakId];
                    if (data) renderChart(data);
                });

                if (anakSelect.value) {
                    // Render chart for the initially selected anak
                    renderChart(dataByAnak[anakSelect.value]);
                } else {
                    chartEl.innerHTML = '<p class="text-center">Tidak ada data untuk anak ini.</p>';
                }
            });
        </script>
    @endrole
@endsection
