@extends('layouts.main')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-white">Manajemen Inventaris</h2>
        <a href="{{ route('inventory.create') }}" class="bg-green-600 text-white px-5 py-2 rounded-lg font-bold hover:bg-green-700 transition duration-300">
            Tambah Stok Masuk
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6 shadow-lg">
            {{ $message }}
        </div>
    @endif

    <div class="bg-white/30 backdrop-blur-xl p-6 rounded-2xl shadow-lg">
        <table class="w-full text-left text-white">
            <thead>
                <tr class="border-b border-white/20">
                    <th class="p-4 font-bold">ID</th>
                    <th class="p-4 font-bold">Penanggung Jawab</th>
                    <th class="p-4 font-bold">Jumlah (Kg)</th>
                    <th class="p-4 font-bold">Tanggal Masuk</th>
                    <th class="p-4 font-bold">Tanggal Keluar</th>
                    <th class="p-4 font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventory as $inv)
                <tr class="border-b border-white/10 hover:bg-white/10">
                    <td class="p-4">{{ $inv->id_inventory }}</td>
                    <td class="p-4">{{ $inv->user->nama ?? 'N/A' }}</td>
                    <td class="p-4">{{ number_format($inv->jumlah) }}</td>
                    <td class="p-4">{{ $inv->tanggal_masuk }}</td>
                    <td class="p-4">{{ $inv->tanggal_keluar ?? '-' }}</td>
                    <td class="p-4">
                        <form action="{{ route('inventory.destroy', $inv->id_inventory) }}" method="POST" class="flex space-x-2">
                            <a href="{{ route('inventory.edit', $inv->id_inventory) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg font-semibold hover:bg-yellow-600 transition duration-300">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg font-semibold hover:bg-red-700 transition duration-300" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center p-4">Belum ada data inventaris.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection