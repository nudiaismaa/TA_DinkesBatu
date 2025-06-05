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
                        <p class="card-text">{{ $anak->count() }}</p>
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

                    foreach ($anak as $a) {
                        $berat = $a->pemeriksaan->sum('berat_badan');
                        $tinggi = $a->pemeriksaan->sum('tinggi_badan');
                        $jumlah = $a->pemeriksaan->count();

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
                        <p class="card-text">{{ $avgTinggi !== null ? number_format($avgTinggi, 2) . ' kg' : 'Belum ada data' }}
                        </p>
                    </x-card>
                </div>
            @endrole
        </div>
            <div class="row g-3 align-items-stretch">
                <div class="col-md-6 col-sm-8 col-12">
                    <x-card class="h-100">
                        <h5 class="card-title text-muted">Statistik Tinggi Badan</h5>
                        <div id="heightChart"></div>
                    </x-card>
                </div>
                <div class="col-md-6 col-sm-8 col-12">
                    <x-card class="h-100">
                        <h5 class="card-title text-muted">Statistik Berat Badan</h5>
                        <div id="weightChart"></div>
                    </x-card>
                </div>
                <div class="col-md-6 col-sm-8 col-12">
                    <x-card class="h-100">
                        <h5 class="card-title text-muted">Statistik Lingkar Kepala</h5>
                        <div id="headChart"></div>
                    </x-card>
                </div>
            </div>
        
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var allAnakData = {!! json_encode($anak ?? []) !!};
            var userRoles = {!! json_encode($userRoles ?? []) !!};
            var currentOrangtuaId = {!! json_encode(auth()->user()->orangtua->id ?? null) !!};

            // Filter data berdasarkan role
            var filteredAnakData = allAnakData;

            if (userRoles.includes('Orang Tua')) {
                
                // Filter hanya anak yang memiliki orangtua_id sesuai dengan user yang login
                filteredAnakData = allAnakData.filter(function(anak) {
                    return anak.orangtua_id == currentOrangtuaId;
                });
            }
            // Anda bisa menambahkan filter untuk role lainnya di sini

            // Proses data untuk chart
            if (filteredAnakData.length > 0) {
                // Siapkan variabel untuk chart data
                var seriesDataTinggi = [];
                var seriesDataBerat = [];
                var seriesDataLingkarKepala = [];
                var categories = [];

                filteredAnakData.forEach(function(anak) {
                    categories.push(anak.nama);

                    var pemeriksaanTinggi = [];
                    var pemeriksaanBerat = [];
                    var pemeriksaanLingkarKepala = [];
                    var dates = [];

                    // Cek dan urutkan pemeriksaan jika ada
                    if (anak.pemeriksaan && Array.isArray(anak.pemeriksaan)) {
                        var sortedPemeriksaan = [...anak.pemeriksaan].sort((a, b) =>
                            new Date(a.tanggal_pemeriksaan) - new Date(b.tanggal_pemeriksaan));

                        sortedPemeriksaan.forEach(function(pemeriksaan) {
                            pemeriksaanTinggi.push(pemeriksaan.tinggi_badan || 0);
                            pemeriksaanBerat.push(pemeriksaan.berat_badan || 0);
                            pemeriksaanLingkarKepala.push(pemeriksaan.lingkar_kepala || 0);
                            dates.push(new Date(pemeriksaan.tanggal_pemeriksaan)
                            .toLocaleDateString());
                        });
                    }

                    seriesDataTinggi.push({
                        name: anak.nama,
                        data: pemeriksaanTinggi,
                        dates: dates
                    });

                    seriesDataBerat.push({
                        name: anak.nama,
                        data: pemeriksaanBerat,
                        dates: dates
                    });

                    seriesDataLingkarKepala.push({
                        name: anak.nama,
                        data: pemeriksaanLingkarKepala,
                        dates: dates
                    });
                });

                // Fungsi untuk membuat opsi chart
                function createChartOptions(title, seriesData, yaxisTitle) {
                    return {
                        chart: {
                            type: 'line',
                            height: '100%'
                        },
                        series: seriesData,
                        xaxis: {
                            categories: seriesData.length > 0 ? seriesData[0].dates : [],
                            title: {
                                text: 'Tanggal Pemeriksaan'
                            }
                        },
                        yaxis: {
                            title: {
                                text: yaxisTitle
                            },
                            min: 0
                        },
                        stroke: {
                            width: 2,
                            curve: 'smooth'
                        },
                        markers: {
                            size: 5
                        },
                        tooltip: {
                            enabled: true,
                        },
                        colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444']
                    };
                }

                // Render charts
                var heightChart = new ApexCharts(
                    document.querySelector("#heightChart"),
                    createChartOptions(
                        'Perkembangan Tinggi Badan',
                        seriesDataTinggi,
                        'Tinggi Badan (cm)'
                    )
                );

                var weightChart = new ApexCharts(
                    document.querySelector("#weightChart"),
                    createChartOptions(
                        'Perkembangan Berat Badan',
                        seriesDataBerat,
                        'Berat Badan (kg)'
                    )
                );

                var headChart = new ApexCharts(
                    document.querySelector("#headChart"),
                    createChartOptions(
                        'Perkembangan Lingkar Kepala',
                        seriesDataLingkarKepala,
                        'Lingkar Kepala (cm)'
                    )
                );

                heightChart.render();
                weightChart.render();
                headChart.render();
            } else {
                console.log('Tidak ada data anak yang sesuai dengan role');
            }
        });
    </script>
@endsection
