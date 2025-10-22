@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Produk Baru</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('market.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="nama_produk" class="col-md-4 col-form-label text-md-right">Nama Produk</label>
                            <div class="col-md-6">
                                <input id="nama_produk" type="text" class="form-control @error('nama_produk') is-invalid @enderror" name="nama_produk" value="{{ old('nama_produk') }}" required autocomplete="nama_produk" autofocus>
                                @error('nama_produk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jenis_beras" class="col-md-4 col-form-label text-md-right">Jenis Beras</label>
                            <div class="col-md-6">
                                <input id="jenis_beras" type="text" class="form-control @error('jenis_beras') is-invalid @enderror" name="jenis_beras" value="{{ old('jenis_beras') }}" required autocomplete="jenis_beras">
                                @error('jenis_beras')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nama_petani" class="col-md-4 col-form-label text-md-right">Nama Petani</label>
                            <div class="col-md-6">
                                <input id="nama_petani" type="text" class="form-control @error('nama_petani') is-invalid @enderror" name="nama_petani" value="{{ old('nama_petani') }}" required autocomplete="nama_petani">
                                @error('nama_petani')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lokasi_gudang" class="col-md-4 col-form-label text-md-right">Lokasi Gudang</label>
                            <div class="col-md-6">
                                <input id="lokasi_gudang" type="text" class="form-control @error('lokasi_gudang') is-invalid @enderror" name="lokasi_gudang" value="{{ old('lokasi_gudang') }}" required autocomplete="lokasi_gudang">
                                @error('lokasi_gudang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deskripsi" class="col-md-4 col-form-label text-md-right">Deskripsi</label>
                            <div class="col-md-6">
                                <textarea id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="harga" class="col-md-4 col-form-label text-md-right">Harga per Kg</label>
                            <div class="col-md-6">
                                <input id="harga" type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga') }}" required min="0">
                                @error('harga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="stok" class="col-md-4 col-form-label text-md-right">Stok (Kg)</label>
                            <div class="col-md-6">
                                <input id="stok" type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{ old('stok') }}" required min="0">
                                @error('stok')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Tambah Produk
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection