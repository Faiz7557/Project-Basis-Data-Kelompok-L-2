<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TopUp;
use App\Models\Expenditure;

class DashboardController extends Controller {
    public function index()
    {
        $user = auth()->user();
        $saldo = $user->saldo;

        // Ambil aktivitas terbaru (misalnya 5 terakhir)
        $marketTransactions = Transaksi::where('id_penjual', $user->id_user)
            ->orWhere('id_pembeli', $user->id_user)
            ->with(['penjual', 'pembeli', 'pasar'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($trx) use ($user) {
                $isSale = $trx->id_penjual == $user->id_user;
                return (object) [
                    'type' => $isSale ? 'sale' : 'purchase',
                    'description' => $isSale
                        ? 'Penjualan ' . $trx->jumlah . ' kg'
                        : 'Pembelian ' . $trx->jumlah . ' kg',
                    'amount' => $trx->harga_akhir * $trx->jumlah,
                    'date' => $trx->tanggal,
                ];
            });

        $topUps = TopUp::where('user_id', $user->id_user)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($topup) {
                return (object) [
                    'type' => 'topup',
                    'description' => 'Topup saldo',
                    'amount' => $topup->amount,
                    'date' => $topup->created_at->toDateString(),
                ];
            });

        $expenditures = Expenditure::where('user_id', $user->id_user)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($exp) {
                return (object) [
                    'type' => 'expenditure',
                    'description' => $exp->description,
                    'amount' => $exp->amount,
                    'date' => $exp->date,
                ];
            });

        $activities = $marketTransactions->concat($topUps)->concat($expenditures)->sortByDesc('date')->take(5);

        return view('dashboard', compact('saldo', 'activities'));
    }
}
