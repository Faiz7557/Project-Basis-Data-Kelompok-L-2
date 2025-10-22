<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::with('user')->latest()->get();
        return view('inventory.index', compact('inventory'));
    }

    public function create()
    {
        $users = User::all();
        return view('inventory.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'id_user' => 'required|exists:users,id_user',
        ]);

        Inventory::create($request->all());

        return redirect()->route('inventory.index')
                         ->with('success', 'Data inventory baru berhasil ditambahkan.');
    }

    public function show(Inventory $inventory)
    {
        // Not used
    }

    public function edit(Inventory $inventory)
    {
        $users = User::all();
        return view('inventory.edit', compact('inventory', 'users'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
            'id_user' => 'required|exists:users,id_user',
        ]);

        $inventory->update($request->all());

        return redirect()->route('inventory.index')
                         ->with('success', 'Data inventory berhasil diperbarui.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')
                         ->with('success', 'Data inventory berhasil dihapus.');
    }
}