{{-- create.blade.php --}}
@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Link Kembali -->
    <div class="mb-6">
        <a href="{{ route('pasar.show', $produk) }}" class="btn-back-link">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail Produk
        </a>
    </div>

    <!-- Card Utama Form Negosiasi -->
    <div class="negotiation-form-card animate-fade-in">
        <div class="card-header-custom mb-4">
            <h1 class="text-white mb-0 font-weight-bold">
                <i class="fas fa-handshake me-2"></i>Ajukan Negosiasi
            </h1>
        </div>

        <div class="card-body">
            <!-- Detail Produk -->
            <div class="product-details-section mb-6">
                <h3 class="text-white mb-3"><i class="fas fa-info-circle me-1"></i>Detail Produk</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <i class="fas fa-box text-info me-1"></i>
                        <strong>Nama Produk:</strong>
                        <span>{{ $produk->nama_produk }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-seedling text-success me-1"></i>
                        <strong>Varietas:</strong>
                        <span>{{ $produk->varietas }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-star text-warning me-1"></i>
                        <strong>Kualitas:</strong>
                        <span>{{ $produk->kualitas }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-coins text-success me-1"></i>
                        <strong>Harga Awal:</strong>
                        <span>Rp {{ number_format($produk->harga_per_kg, 0, ',', '.') }}/kg</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-warehouse text-secondary me-1"></i>
                        <strong>Stok Tersedia:</strong>
                        <span>{{ number_format($produk->stok_kg, 0, ',', '.') }} kg</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-user text-primary me-1"></i>
                        <strong>Petani:</strong>
                        <span>{{ $produk->petani->nama }}</span>
                    </div>
                </div>
            </div>

            <!-- Form Negosiasi -->
            <form action="{{ route('negosiasi.store', $produk) }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="harga_penawaran" class="form-label text-white">Harga Penawaran (Rp/kg)</label>
                            <input type="number" name="harga_penawaran" id="harga_penawaran" value="{{ old('harga_penawaran') }}" 
                                   class="form-input-custom w-full" required min="1" step="1000"
                                   placeholder="Masukkan harga tawaran Anda">
                            @error('harga_penawaran')
                                <div class="error-message mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah_kg" class="form-label text-white">Jumlah (Kg)</label>
                            <input type="number" name="jumlah_kg" id="jumlah_kg" value="{{ old('jumlah_kg') }}" 
                                   class="form-input-custom w-full" required min="1" max="{{ $produk->stok_kg }}"
                                   placeholder="Masukkan jumlah kg">
                            <p class="text-light small mt-1">Maksimal: {{ number_format($produk->stok_kg, 0, ',', '.') }} kg</p>
                            @error('jumlah_kg')
                                <div class="error-message mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="pesan" class="form-label text-white">Pesan (Opsional)</label>
                            <textarea name="pesan" id="pesan" rows="4" 
                                      class="form-input-custom w-full" placeholder="Tulis pesan untuk petani...">{{ old('pesan') }}</textarea>
                            @error('pesan')
                                <div class="error-message mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-6">
                    <button type="submit" class="btn-submit-negotiate">
                        <i class="fas fa-paper-plane me-2"></i>Ajukan Negosiasi
                    </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .negotiation-form-card {
        background: linear-gradient(135deg, #4CAF50, #81C784);
        backdrop-filter: blur(10px);
        border: 1px solid #FF9800;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        color: #fff;
    }
    
    .negotiation-form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #FF9800, #4CAF50);
    }
    
    .negotiation-form-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }
    
    .card-header-custom {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        border-radius: 12px;
        padding: 20px;
        backdrop-filter: blur(5px);
        margin-bottom: 0;
    }
    
    .product-details-section {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
    }
    
    .info-grid {
        display: grid;
        gap: 1rem;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.05);
        padding: 12px;
        border-radius: 8px;
        border-left: 3px solid #FF9800;
    }
    
    .info-item strong {
        min-width: 140px;
        font-size: 0.95rem;
        color: #fff;
    }
    
    .info-item span {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.9);
        flex: 1;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #fff;
    }
    
    .form-input-custom {
        width: 100%;
        padding: 12px 16px;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 8px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-input-custom:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.3);
        border-color: #FF9800;
        box-shadow: 0 0 0 0.2rem rgba(255, 152, 0, 0.25);
    }
    
    .form-input-custom::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }
    
    .error-message {
        color: #f44336;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        background: rgba(244, 67, 54, 0.1);
        padding: 4px 8px;
        border-radius: 4px;
        border-left: 3px solid #f44336;
    }
    
    .btn-back-link {
        display: inline-flex;
        align-items: center;
        padding: 10px 16px;
        background: linear-gradient(135deg, #FF9800, #FFB74D);
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(255, 152, 0, 0.3);
    }
    
    .btn-back-link:hover {
        background: linear-gradient(135deg, #F57C00, #FF8F00);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(255, 152, 0, 0.4);
        color: #fff;
    }
    
    .btn-submit-negotiate {
        display: inline-flex;
        align-items: center;
        padding: 14px 32px;
        background: linear-gradient(135deg, #17a2b8, #20c997);
        color: #fff;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: none;
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
        cursor: pointer;
    }
    
    .btn-submit-negotiate:hover {
        background: linear-gradient(135deg, #138496, #1ea085);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(23, 162, 184, 0.4);
    }
    
    /* Animasi */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in { animation: fadeInUp 0.6s ease-out forwards; }
    
    /* Responsiveness */
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .info-item strong {
            min-width: auto;
        }
        
        .row .col-md-6,
        .row .col-md-12 {
            margin-bottom: 1rem;
        }
        
        .btn-submit-negotiate {
            width: 100%;
        }
    }
</style>
@endsection