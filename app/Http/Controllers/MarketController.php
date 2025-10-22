<?php

namespace App\Http\Controllers;

use App\Models\ProdukBeras;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index()
    {
        $products = ProdukBeras::all();
        return view('market.index', compact('products'));
    }

    public function show(ProdukBeras $product)
    {
        return view('market.show', compact('product'));
    }

    public function create()
    {
        return view('market.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'jenis_beras' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'nama_petani' => 'required|string|max:255',
            'lokasi_gudang' => 'required|string|max:255',
        ]);

        ProdukBeras::create([
            'nama_produk' => $request->nama_produk,
            'jenis_beras' => $request->jenis_beras,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'nama_petani' => $request->nama_petani,
            'lokasi_gudang' => $request->lokasi_gudang,
            'id_user' => auth()->id(), // Asumsi produk dibuat oleh user yang sedang login
        ]);

        return redirect()->route('market.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = ProdukBeras::findOrFail($id);
        return view('market.edit', compact('product'));
    }
    public function buy(Request $request, ProdukBeras $product)
    {
    $request->validate([
        'jumlah' => 'required|integer|min:1|max:'.$product->stok,
    ]);

    // Buat transaksi baru
    $transaksi = \App\Models\Transaksi::create([
        'id_user'   => auth()->id(),
        'id_produk' => $product->id_produk,
        'jumlah'    => $request->jumlah,
        'total'     => $product->harga * $request->jumlah,
        'status'    => 'pending',
    ]);

    // Kurangi stok produk
    $product->decrement('stok', $request->jumlah);

    return redirect()->route('market.show', $product->id_produk)
                     ->with('status', 'Pembelian berhasil dibuat, menunggu konfirmasi!');
    }
}