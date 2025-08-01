<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembudidaya;
use App\Models\Produk;
use App\Models\Order;
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
        $userYear = $request->query('user_year', now()->year);
        $commodityYear = $request->query('commodity_year', now()->year);
        $orderYear = $request->query('order_year', now()->year);

        // Dapatkan tahun yang tersedia untuk pengguna dan pembudidaya
        $earliestUserYear = User::whereNotNull('created_at')->min('created_at') ? Carbon::parse(User::whereNotNull('created_at')->min('created_at'))->year : now()->year;
        $earliestPembudidayaYear = Pembudidaya::whereNotNull('created_at')->min('created_at') ? Carbon::parse(Pembudidaya::whereNotNull('created_at')->min('created_at'))->year : now()->year;
        $userStartYear = min($earliestUserYear, $earliestPembudidayaYear);
        $userYears = range($userStartYear, now()->year);

        // Dapatkan tahun yang tersedia untuk komoditas
        $earliestProdukYear = Produk::whereNotNull('created_at')->min('created_at') ? Carbon::parse(Produk::whereNotNull('created_at')->min('created_at'))->year : now()->year;
        $commodityYears = range($earliestProdukYear, now()->year);

        // Dapatkan tahun yang tersedia untuk order
        $earliestOrderYear = Order::whereNotNull('created_at')->min('created_at') ? Carbon::parse(Order::whereNotNull('created_at')->min('created_at'))->year : now()->year;
        $orderYears = range($earliestOrderYear, now()->year);

        // Debugging untuk memeriksa tahun terawal
        \Log::info('Earliest User Year: ' . $earliestUserYear);
        \Log::info('Earliest Pembudidaya Year: ' . $earliestPembudidayaYear);
        \Log::info('Earliest Produk Year: ' . $earliestProdukYear);
        \Log::info('Earliest Order Year: ' . $earliestOrderYear);
        \Log::info('User Start Year: ' . $userStartYear);
        \Log::info('Selected User Year: ' . $userYear);
        \Log::info('Selected Commodity Year: ' . $commodityYear);
        \Log::info('Selected Order Year: ' . $orderYear);

        // Ambil data bulanan untuk pengguna
        $userData = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $userYear)
            ->whereNotNull('created_at')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Ambil data bulanan untuk semua pembudidaya (termasuk tanpa dokumen, ditolak, atau menunggu)
        $pembudidayaData = Pembudidaya::selectRaw('COALESCE(MONTH(created_at), MONTH(NOW())) as month, COUNT(*) as count')
            ->where(function ($query) use ($userYear) {
                $query->whereYear('created_at', $userYear)
                      ->orWhereNull('created_at'); // Include records with null created_at
            })
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Debugging: Log total pembudidaya yang dihitung
        \Log::info('Pembudidaya Data Count for ' . $userYear . ': ' . json_encode($pembudidayaData));

        // Inisialisasi array untuk data chart pengguna dan pembudidaya (12 bulan)
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

        // Daftar jenis komoditas
        $commodityTypes = [
            'Rumput Laut',
            'Udang',
            'Ikan Gurame',
            'Ikan Bandeng',
            'Ikan Lele',
            'Ikan Nila'
        ];

        // Inisialisasi array untuk data komoditas per bulan (hanya yang disetujui)
        $commodityData = [];
        foreach ($commodityTypes as $type) {
            $monthlyData = Produk::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $commodityYear)
                ->where('jenis_komoditas', $type)
                ->where('is_approved', 1) // Filter hanya komoditas yang disetujui
                ->whereNotNull('created_at')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month')
                ->toArray();

            $counts = array_fill(1, 12, 0);
            foreach ($monthlyData as $month => $count) {
                $counts[$month] = $count;
            }
            $commodityData[$type] = $counts;
        }

        // Hitung total komoditas (hanya yang disetujui)
        $totalCommodities = Produk::whereYear('created_at', $commodityYear)
            ->where('is_approved', 1)
            ->count();

        // Ambil data bulanan untuk order
        $orderData = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $orderYear)
            ->whereNotNull('created_at')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Inisialisasi array untuk data chart order (12 bulan)
        $orderCounts = array_fill(1, 12, 0);

        // Isi data ke dalam array
        foreach ($orderData as $month => $count) {
            $orderCounts[$month] = $count;
        }

        // Hitung total order
        $totalOrders = array_sum($orderCounts);

        // Label bulan dalam bahasa Indonesia
        $labels = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Warna untuk setiap jenis komoditas
        $colors = [
            ['background' => '#007bff', 'border' => '#0056b3'], // Blue (Rumput Laut)
            ['background' => '#28a745', 'border' => '#1e7e34'], // Green (Udang)
            ['background' => '#dc3545', 'border' => '#a71d2a'], // Red (Ikan Gurame)
            ['background' => '#ffc107', 'border' => '#d39e00'], // Yellow (Ikan Bandeng)
            ['background' => '#6f42c1', 'border' => '#563d7c'], // Purple (Ikan Lele)
            ['background' => '#17a2b8', 'border' => '#117a8b'], // Cyan (Ikan Nila)
        ];

        // Konfigurasi Chart.js untuk pengguna dan pembudidaya
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
                            'backgroundColor' => '#28a745',
                            'borderColor' => '#1e7e34',
                            'borderWidth' => 1,
                        ],
                    ],
                ],
                'options' => [
                    'responsive' => true,
                    'plugins' => [
                        'legend' => [
                            'display' => true,
                            'position' => 'right',
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

        // Konfigurasi Chart.js untuk komoditas
        $commodityChart = [
            'data' => [
                'type' => 'bar',
                'data' => [
                    'labels' => $labels,
                    'datasets' => array_map(function ($type, $index) use ($commodityData, $colors) {
                        return [
                            'label' => $type,
                            'data' => array_values($commodityData[$type]),
                            'backgroundColor' => $colors[$index]['background'],
                            'borderColor' => $colors[$index]['border'],
                            'borderWidth' => 1,
                        ];
                    }, $commodityTypes, array_keys($commodityTypes)),
                ],
                'options' => [
                    'responsive' => true,
                    'plugins' => [
                        'legend' => [
                            'display' => true,
                            'position' => 'right',
                        ],
                        'title' => [
                            'display' => false,
                        ],
                    ],
                    'scales' => [
                        'x' => [
                            'stacked' => true,
                            'title' => [
                                'display' => true,
                                'text' => 'Bulan',
                            ],
                        ],
                        'y' => [
                            'stacked' => true,
                            'title' => [
                                'display' => true,
                                'text' => 'Jumlah Komoditas',
                            ],
                            'beginAtZero' => true,
                        ],
                    ],
                ],
            ],
        ];

        // Konfigurasi Chart.js untuk order
        $orderChart = [
            'data' => [
                'type' => 'line',
                'data' => [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => 'Jumlah Order',
                            'data' => array_values($orderCounts),
                            'fill' => false,
                            'borderColor' => '#dc3545',
                            'borderWidth' => 2,
                            'tension' => 0.1,
                        ],
                    ],
                ],
                'options' => [
                    'responsive' => true,
                    'plugins' => [
                        'legend' => [
                            'display' => true,
                            'position' => 'right',
                        ],
                        'title' => [
                            'display' => false,
                        ],
                    ],
                    'scales' => [
                        'x' => [
                            'title' => [
                                'display' => true,
                                'text' => 'Bulan',
                            ],
                        ],
                        'y' => [
                            'title' => [
                                'display' => true,
                                'text' => 'Jumlah Order',
                            ],
                            'beginAtZero' => true,
                        ],
                    ],
                ],
            ],
        ];

        // Data dashboard untuk konsistensi
        $jumlahPengguna = User::count();
        $jumlahPembudidaya = Pembudidaya::count(); // Counts all pembudidaya, regardless of documents
        $jumlahKomoditas = Produk::where('is_approved', 1)->count();

        return view('admin.statistik.index', compact(
            'jumlahPengguna',
            'jumlahPembudidaya',
            'jumlahKomoditas',
            'userYear',
            'commodityYear',
            'orderYear',
            'userYears',
            'commodityYears',
            'orderYears',
            'totalUsers',
            'totalPembudidaya',
            'totalCommodities',
            'totalOrders',
            'chart',
            'commodityChart',
            'orderChart'
        ));
    }
}