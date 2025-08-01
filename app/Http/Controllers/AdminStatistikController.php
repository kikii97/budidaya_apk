<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembudidaya;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminStatistikController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        // Ambil tahun yang dipilih dari parameter query, default ke tahun sekarang
        $selectedYear = $request->query('year', now()->year);

        // Dapatkan tahun yang tersedia (dari pembuatan user/pembudidaya terawal hingga tahun sekarang)
        $earliestUserYear = User::whereNotNull('created_at')->min('created_at') ? Carbon::parse(User::whereNotNull('created_at')->min('created_at'))->year : now()->year;
        $earliestPembudidayaYear = Pembudidaya::whereNotNull('created_at')->min('created_at') ? Carbon::parse(Pembudidaya::whereNotNull('created_at')->min('created_at'))->year : now()->year;
        $startYear = min($earliestUserYear, $earliestPembudidayaYear);

        // Debugging untuk memeriksa tahun terawal
        \Log::info('Earliest User Year: ' . $earliestUserYear);
        \Log::info('Earliest Pembudidaya Year: ' . $earliestPembudidayaYear);
        \Log::info('Start Year: ' . $startYear);

        $years = range($startYear, now()->year);

        // Ambil data bulanan untuk pengguna
        $userData = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $selectedYear)
            ->whereNotNull('created_at') // Tambahkan filter untuk data valid
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Ambil data bulanan untuk pembudidaya
        $pembudidayaData = Pembudidaya::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $selectedYear)
            ->whereNotNull('created_at') // Tambahkan filter untuk data valid
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Inisialisasi array untuk data chart (12 bulan)
        $userCounts = array_fill(1, 12, 0);
        $pembudidayaCounts = array_fill(1, 12, 0);

        // Isi data ke dalam array
        foreach ($userData as $month => $count) {
            $userCounts[$month] = $count;
        }
        foreach ($pembudidayaData as $month => $count) {
            $pembudidayaCounts[$month] = $count;
        }

        // Hitung total
        $totalUsers = array_sum($userCounts);
        $totalPembudidaya = array_sum($pembudidayaCounts);

        // Label bulan dalam bahasa Indonesia
        $labels = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Konfigurasi Chart.js dengan warna biru untuk keduanya
        $chart = [
            'data' => [
                'type' => 'bar',
                'data' => [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => 'Pengguna',
                            'data' => array_values($userCounts),
                            'backgroundColor' => '#007bff',
                            'borderColor' => '#0056b3',
                            'borderWidth' => 1,
                        ],
                        [
                            'label' => 'Pembudidaya',
                            'data' => array_values($pembudidayaCounts),
                            'backgroundColor' => '#007bff',
                            'borderColor' => '#0056b3',
                            'borderWidth' => 1,
                        ],
                    ],
                ],
                'options' => [
                    'responsive' => true,
                    'plugins' => [
                        'legend' => [
                            'display' => false,
                        ],
                        'title' => [
                            'display' => false,
                        ],
                    ],
                    'scales' => [
                        'x' => [
                            'stacked' => false,
                            'title' => [
                                'display' => true,
                                'text' => 'Bulan',
                            ],
                        ],
                        'y' => [
                            'stacked' => false,
                            'title' => [
                                'display' => true,
                                'text' => 'Jumlah',
                            ],
                            'beginAtZero' => true,
                        ],
                    ],
                ],
            ],
        ];

        // Data dashboard untuk konsistensi
        $jumlahPengguna = User::count();
        $jumlahPembudidaya = Pembudidaya::count();
        $jumlahKomoditas = \App\Models\Produk::count();

        return view('admin.statistik.index', compact(
            'jumlahPengguna',
            'jumlahPembudidaya',
            'jumlahKomoditas',
            'selectedYear',
            'years',
            'totalUsers',
            'totalPembudidaya',
            'chart'
        ));
    }
}