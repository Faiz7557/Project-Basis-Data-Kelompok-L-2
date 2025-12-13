<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pasar;
use App\Models\Transaksi;

use App\Models\FactUserDailyMetric;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        
        // Use the same verified logic as the API
        $gmv = FactUserDailyMetric::sum('total_income') + 
               Transaksi::whereDate('updated_at', $today)
                        ->whereIn('status_transaksi', ['disetujui', 'completed', 'confirmed'])
                        ->sum(DB::raw('harga_akhir * jumlah'));

        $totalTransactions = Transaksi::count();

        // Calculate Admin Stats
        $adminStats = [
            'gmv' => $gmv,
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', now())->count(),
            'total_tx_today' => Transaksi::whereDate('tanggal', now())->count(),
            'pending_nego' => \App\Models\Negosiasi::where('status', 'Menunggu')->count(),
        ];

        // Get recent transactions for the dashboard widget
        $recentTransactions = Transaksi::with(['penjual', 'pembeli'])
            ->latest()
            ->take(5)
            ->get();

        // Get latest users for the widget
        $latestUsers = User::latest()->take(5)->get();

        // Pass variables to view (totalProducts is just a placeholder for now or can use Pasar count)
        $totalUsers = $adminStats['total_users'];
        $totalProducts = Pasar::count(); 

        return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'totalTransactions', 'recentTransactions', 'latestUsers', 'adminStats'));
    }

    public function backup()
    {
        $data = [
            'users' => User::all(),
            'transactions' => Transaksi::all(),
            'generated_at' => now()->toDateTimeString(),
        ];
        
        $filename = 'backup_database_' . date('Y-m-d_H-i-s') . '.json';
        
        return response()->streamDownload(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT);
        }, $filename);
    }

    public function logs()
    {
        $logFile = storage_path('logs/laravel.log');
        if (!file_exists($logFile)) {
            return response('No logs found.', 404);
        }

        $logs = file_get_contents($logFile);
        $lines = explode("\n", $logs);
        $lastLines = array_slice($lines, -50); // Get last 50 lines
        
        return response('<pre>' . implode("\n", $lastLines) . '</pre>');
    }
}
