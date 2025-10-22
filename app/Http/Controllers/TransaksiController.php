<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TopUp;
use App\Models\Expenditure;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil transaksi market (purchases and sales)
        $marketTransactions = Transaksi::where('id_penjual', $user->id_user)
            ->orWhere('id_pembeli', $user->id_user)
            ->with(['penjual', 'pembeli', 'pasar'])
            ->get()
            ->map(function ($trx) use ($user) {
                $isSale = $trx->id_penjual == $user->id_user;
                return (object) [
                    'id' => $trx->id_transaksi,
                    'type' => $isSale ? 'sale' : 'purchase',
                    'type_label' => $isSale ? 'Hasil Penjualan' : 'Pembelian di Market',
                    'amount' => $trx->harga_akhir * $trx->jumlah,
                    'description' => $isSale
                        ? 'Penjualan ' . $trx->jumlah . ' kg ke ' . ($trx->pembeli->nama ?? 'Unknown') . ' di ' . ($trx->pasar->nama_pasar ?? 'Unknown')
                        : 'Pembelian ' . $trx->jumlah . ' kg dari ' . ($trx->penjual->nama ?? 'Unknown') . ' di ' . ($trx->pasar->nama_pasar ?? 'Unknown'),
                    'date' => $trx->tanggal,
                    'status' => $trx->status_transaksi,
                    'created_at' => $trx->created_at,
                ];
            });

        // Ambil top-ups
        $topUps = TopUp::where('user_id', $user->id_user)
            ->get()
            ->map(function ($topup) {
                return (object) [
                    'id' => $topup->id,
                    'type' => 'topup',
                    'type_label' => 'Topup Saldo',
                    'amount' => $topup->amount,
                    'description' => 'Topup saldo via ' . ucfirst(str_replace('_', ' ', $topup->payment_method)) . ' (Ref: ' . $topup->reference_code . ')',
                    'date' => $topup->created_at->toDateString(),
                    'status' => $topup->status,
                    'created_at' => $topup->created_at,
                ];
            });

        // Ambil expenditures
        $expenditures = Expenditure::where('user_id', $user->id_user)
            ->get()
            ->map(function ($exp) {
                return (object) [
                    'id' => $exp->id,
                    'type' => 'expenditure',
                    'type_label' => 'Pengeluaran Saldo',
                    'amount' => $exp->amount,
                    'description' => $exp->description,
                    'date' => $exp->date,
                    'status' => $exp->status,
                    'created_at' => $exp->created_at,
                ];
            });

        // Gabungkan dan urutkan berdasarkan tanggal terbaru
        $activities = $marketTransactions->concat($topUps)->concat($expenditures)->sortByDesc('created_at');

        // Kirim ke view
        return view('transaksi.index', compact('activities'));
    }

    public function destroy(Request $request, $type, $id)
    {
        switch ($type) {
            case 'sale':
            case 'purchase':
                $transaksi = Transaksi::findOrFail($id);
                $transaksi->delete();
                break;
            case 'topup':
                $topup = TopUp::findOrFail($id);
                $topup->delete();
                break;
            case 'expenditure':
                $expenditure = Expenditure::findOrFail($id);
                $expenditure->delete();
                break;
            default:
                return redirect()->route('transaksi.index')->with('error', 'Jenis aktivitas tidak valid.');
        }

        return redirect()->route('transaksi.index')->with('success', 'Aktivitas transaksi berhasil dihapus!');
    }
}
