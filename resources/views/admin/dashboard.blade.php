@extends('admin_template')
@section('content')
<div class="row"> {{-- Tambahkan div dengan kelas row di sini --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Grafik Peminjaman Bulanan</h3>
                    {{-- Tautan "Lihat Laporan" telah dihapus sesuai permintaan --}}
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        {{-- Menampilkan total peminjaman yang dilempar dari controller --}}
                        <span class="text-bold text-lg" id="total-loans-display">{{ $totalLoansCount ?? 0 }}</span>
                        <span>Total Peminjaman</span>
                    </p>
                    {{-- Bagian persentase bisa kamu sesuaikan jika ada data perbandingan --}}
                    <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-success">
                            <i class="fas fa-arrow-up"></i> N/A %
                        </span>
                        <span class="text-muted">Sejak Bulan Lalu</span>
                    </p>
                </div>
                <div class="position-relative mb-4">
                    {{-- Elemen canvas tempat grafik akan digambar --}}
                    <canvas id="loans-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> Peminjaman
                    </span>
                    {{-- Kamu bisa menambahkan legenda lain jika ada lebih dari satu dataset --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Total Pinjaman per Petugas</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        {{-- Menampilkan total nominal pinjaman keseluruhan --}}
                        <span class="text-bold text-lg">Rp. {{ number_format(array_sum(json_decode($employeeChartData)), 0, ',', '.') }}</span>
                        <span>Total Nominal Pinjaman</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-info">
                            <i class="fas fa-users"></i> {{ count(json_decode($employeeChartLabels)) }} Petugas
                        </span>
                        <span class="text-muted">Yang Melayani Pinjaman</span>
                    </p>
                </div>
                <div class="position-relative mb-4">
                    <canvas id="loans-by-employee-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                        <i class="fas fa-square text-info"></i> Nominal Pinjaman
                    </span>
                </div>
            </div>
        </div>
        
    </div>
    </div> {{-- Tutup div row di sini --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mendefinisikan variabel JavaScript langsung dengan data JSON yang di-encode dari PHP.
        // Ini adalah cara yang lebih aman untuk menyisipkan data JSON ke dalam JavaScript.
        const chartLabels = {!! $chartLabels !!}; // Tidak perlu JSON.parse() lagi
        const chartData = {!! $chartData !!};     // Tidak perlu JSON.parse() lagi

        // Mendapatkan konteks 2D dari elemen canvas
        const ctx = document.getElementById('loans-chart').getContext('2d');

        // Membuat instance Chart.js baru
        new Chart(ctx, {
            type: 'bar', // Tipe grafik: 'bar' (batang) atau 'line' (garis)
            data: {
                labels: chartLabels, // Label untuk sumbu X (bulan dan tahun)
                datasets: [{
                    label: 'Jumlah Peminjaman', // Label untuk dataset ini
                    data: chartData, // Data nilai untuk sumbu Y
                    backgroundColor: 'rgba(60,141,188,0.9)', // Warna latar belakang batang/garis
                    borderColor: 'rgba(60,141,188,0.8)', // Warna border batang/garis
                    borderWidth: 1, // Lebar border
                    fill: false // Jika 'line' chart, false berarti tidak mengisi area di bawah garis
                }]
            },
            options: {
                responsive: true, // Membuat grafik responsif terhadap ukuran container
                maintainAspectRatio: false, // Memungkinkan grafik untuk tidak mempertahankan rasio aspek aslinya
                scales: {
                    y: {
                        beginAtZero: true, // Sumbu Y dimulai dari 0
                        title: {
                            display: true,
                            text: 'Jumlah Peminjaman' // Judul sumbu Y
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan' // Judul sumbu X
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Menyembunyikan legenda jika hanya ada satu dataset
                    },
                    tooltip: {
                        mode: 'index', // Tooltip akan menampilkan semua item pada indeks yang sama
                        intersect: false // Tooltip akan muncul bahkan jika kursor tidak tepat di atas elemen
                    }
                }
            }
        });
    });
    // --- Grafik Peminjaman per Petugas ---
        const employeeChartLabels = {!! $employeeChartLabels !!};
        const employeeChartData = {!! $employeeChartData !!};

        const ctxEmployee = document.getElementById('loans-by-employee-chart').getContext('2d');
        new Chart(ctxEmployee, {
            type: 'bar', // Atau 'pie' jika ingin melingkar
            data: {
                labels: employeeChartLabels,
                datasets: [{
                    label: 'Total Nominal Pinjaman',
                    data: employeeChartData,
                    backgroundColor: 'rgba(23,162,184,0.9)', // Warna biru muda/teal
                    borderColor: 'rgba(23,162,184,0.8)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nominal Pinjaman (Rp)'
                        },
                        // Format sumbu Y sebagai mata uang
                        ticks: {
                            callback: function(value, index, ticks) {
                                return 'Rp. ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Nama Petugas'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        // Format tooltip sebagai mata uang
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp. ' + context.parsed.y.toLocaleString('id-ID');
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
</script>
@endsection