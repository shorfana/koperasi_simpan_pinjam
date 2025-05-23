<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman; // Pastikan ini mengarah ke model Pinjaman kamu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function show(){
        // --- Data untuk Grafik Peminjaman Bulanan ---
        $loansData = Pinjaman::select(
                DB::raw('EXTRACT(YEAR FROM tanggal) as year'),
                DB::raw('EXTRACT(MONTH FROM tanggal) as month'),
                DB::raw('COUNT(kode_pinjaman) as total_loans') // Menghitung jumlah pinjaman
            )
            ->where('is_deleted', '0')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $labels = []; // Label for the X-axis (month and year)
        $data = [];   // Data for the Y-axis (number of loans)
        $totalLoansCount = 0; // To display the overall total

        // Month names in Indonesian
        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        foreach ($loansData as $loan) {
            // Format label as "Month Year" (e.g., "Jan 2023")
            $labels[] = $monthNames[$loan->month] . ' ' . $loan->year;
            $data[] = $loan->total_loans;
            $totalLoansCount += $loan->total_loans;
        }

        // --- Data untuk Grafik Peminjaman per Petugas ---
        // Mengambil total nominal pinjaman per petugas (createdby)
        $loansByEmployeeData = Pinjaman::select(
                'createdby',
                DB::raw('SUM(nominal_pinjaman) as total_nominal_pinjaman')
            )
            ->where('is_deleted', '0')
            ->groupBy('createdby')
            ->orderBy('total_nominal_pinjaman', 'desc') // Urutkan dari yang terbesar
            ->get();

        $employeeLabels = []; // Nama petugas
        $employeeData = [];   // Total nominal pinjaman

        foreach ($loansByEmployeeData as $employeeLoan) {
            $employeeLabels[] = $employeeLoan->createdby;
            $employeeData[] = (float) $employeeLoan->total_nominal_pinjaman; // Pastikan ini float/numeric
        }

        return view('admin/dashboard', [
            'title' => 'Dashboard',
            'chartLabels' => json_encode($labels, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP),
            'chartData' => json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP),
            'totalLoansCount' => $totalLoansCount,
            'employeeChartLabels' => json_encode($employeeLabels, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP),
            'employeeChartData' => json_encode($employeeData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP),
        ]);
    }


    public function showMonthlyLoansChart()
    {
        // Ambil data peminjaman, kelompokkan berdasarkan tahun dan bulan
        // dan hitung total peminjaman untuk setiap bulan.
        // Menggunakan YEAR() dan MONTH() dari kolom 'tanggal'.
        $loansData = Pinjaman::select(
                DB::raw('YEAR(tanggal) as year'),
                DB::raw('MONTH(tanggal) as month'),
                DB::raw('COUNT(kode_pinjaman) as total_loans') // Menghitung jumlah pinjaman
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $labels = []; // Label untuk sumbu X (bulan dan tahun)
        $data = [];   // Data untuk sumbu Y (jumlah peminjaman)
        $totalLoansCount = 0; // Untuk menampilkan total keseluruhan

        // Nama-nama bulan dalam bahasa Indonesia
        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        foreach ($loansData as $loan) {
            // Format label menjadi "Bulan Tahun" (misal: "Jan 2023")
            $labels[] = $monthNames[$loan->month] . ' ' . $loan->year;
            $data[] = $loan->total_loans;
            $totalLoansCount += $loan->total_loans;
        }

        // Kembalikan view dan lemparkan data ke dalamnya
        return view('dashboard.loans_chart', [ // Ganti 'dashboard.loans_chart' dengan path view kamu
            'chartLabels' => json_encode($labels), // Encode ke JSON untuk JavaScript
            'chartData' => json_encode($data),     // Encode ke JSON untuk JavaScript
            'totalLoansCount' => $totalLoansCount
        ]);
    }

}
