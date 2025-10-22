@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Edit Produk</h1>
    <form action="{{ route('market.update', $product->id_produk) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="{{ $product->nama_produk }}">
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" value="{{ $product->harga }}">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection