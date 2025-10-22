@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Judul dengan Box Orange -->
    <div class="title-box mb-6 mx-auto">
        <h1 class="text-2xl font-bold text-white m-0 d-flex align-items-center justify-content-center">
            <i class="fas fa-box-open me-3"></i>
            {{ $product->nama_produk }}
        </h1>
    </div>

    <!-- Card Utama Detail Produk -->
    <div class="product-detail-card animate-fade-in">
        <div class="row">
            <!-- Kolom Foto & Action Utama -->
            <div class="col-md-5 mb-4">
                <div class="image-section">
                    @if($product->foto)
                        <img src="{{ asset('storage/produk/' . $product->foto) }}" alt="{{ $product->nama_produk }}" class="product-detail-image">
                    @else
                        <div class="product-placeholder-large">
                            <i class="fas fa-image fs-1 text-muted mb-3"></i>
                            <span class="text-muted">Tidak ada foto produk</span>
                        </div>
                    @endif
                </div>
                
                <!-- Action Buttons Berdasarkan Role -->
                <div class="action-buttons mt-4">
                    @if(auth()->check())
                        @if(auth()->user()->peran == 'admin')
                            <div class="d-flex gap-2 mb-2">
                                <a href="{{ route('market.edit', $product->id_produk) }}" class="btn btn-warning btn-sm flex-fill">
                                    <i class="fas fa-edit me-1"></i>Edit Produk
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $product->id_produk }})">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </div>
                        @elseif(auth()->user()->peran == 'petani')
                            <!-- Asumsi petani bisa lihat detail produknya sendiri -->
                            <a href="{{ route('market.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-list me-1"></i>Kelola Produk Lain
                            </a>
                        @elseif(auth()->user()->peran == 'pengepul')
                            <!-- Pengepul: Beli Langsung atau Negosiasi -->
                            <div class="buy-section">
                                <h5 class="text-white mb-3"><i class="fas fa-shopping-cart me-2"></i>Beli Langsung</h5>
                                <form method="POST" action="{{ route('market.buy', ['market' => $product->id_produk]) }}" class="space-y-3">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label text-white">Jumlah (kg)</label>
                                        <input type="number" name="jumlah" min="1" max="{{ $product->stok }}" required  
                                               class="form-input-custom w-full" placeholder="Masukkan jumlah kg (stok: {{ $product->stok }} kg)">
                                        <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                                    </div>
                                    <div class="total-preview bg-white/20 p-3 rounded-lg">
                                        <p class="text-white mb-0"><strong>Total: Rp <span id="totalHarga">0</span></strong></p>
                                    </div>
                                    <button type="submit" class="btn-buy-direct w-full">
                                        <i class="fas fa-credit-card me-2"></i>Konfirmasi Pembelian
                                    </button>
                                </form>
                                <button class="btn-negotiate w-full mt-3" onclick="openNegotiation({{ $product->id_produk }})">
                                    <i class="fas fa-comments me-2"></i>Negosiasi Harga
                                </button>
                            </div>
                        @elseif(auth()->user()->peran == 'distributor')
                            <!-- Distributor: Hanya bisa beli dari pengepul, tampilkan pesan & link ke market pengepul (asumsi route) -->
                            <div class="alert alert-info text-center p-4 bg-white/20 border-white/30 rounded-lg">
                                <i class="fas fa-info-circle me-2"></i>
                                <h6 class="text-white mb-2">Informasi untuk Distributor</h6>
                                <p class="text-light mb-3">Anda hanya dapat membeli dari pengepul. Produk ini dijual oleh petani.</p>
                                <a href="{{ route('market.pengepul') }}" class="btn btn-outline-light btn-sm"> <!-- Asumsi route market pengepul -->
                                    <i class="fas fa-store me-1"></i>Cari Produk Pengepul
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- Guest: Hanya info login -->
                        <div class="alert alert-warning text-center p-4 bg-white/20 border-white/30 rounded-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            <p class="text-light mb-3">Login untuk membeli atau negosiasi produk.</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kolom Info Detail -->
            <div class="col-md-7 mb-4">
                <div class="info-section">
                    <div class="info-grid">
                        <div class="info-item">
                            <i class="fas fa-tag text-info me-2"></i>
                            <strong class="text-white">Jenis Beras:</strong>
                            <span class="text-light">{{ $product->jenis_beras }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-coins text-success me-2"></i>
                            <strong class="text-white">Harga:</strong>
                            <span class="text-light">Rp {{ number_format($product->harga, 0, ',', '.') }} / kg</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-user text-success me-2"></i>
                            <strong class="text-white">Petani:</strong>
                            <span class="text-light">{{ $product->nama_petani }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt text-warning me-2"></i>
                            <strong class="text-white">Lokasi Gudang:</strong>
                            <span class="text-light">{{ $product->lokasi_gudang }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-warehouse text-secondary me-2"></i>
                            <strong class="text-white">Stok Tersedia:</strong>
                            <span class="text-light">{{ $product->stok }} kg</span>
                        </div>
                        <div class="info-item full-width">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            <strong class="text-white">Deskripsi:</strong>
                            <p class="text-light mt-1">{{ $product->deskripsi }}</p>
                        </div>
                    </div>

                    <!-- Section Rating (Asumsi data rating dari model, sesuaikan) -->
                    @if(isset($product->rating) && $product->rating > 0)
                        <div class="rating-section mt-4 p-3 bg-white/20 rounded-lg">
                            <h6 class="text-white mb-2"><i class="fas fa-star me-2 text-warning"></i>Rating Petani</h6>
                            <div class="d-flex align-items-center">
                                <span class="text-warning fs-5">{{ $product->rating }}/5</span>
                                <div class="stars ms-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $product->rating ? 'text-warning' : 'text-light' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-light small mt-1">Berdasarkan {{ $product->review_count ?? 0 }} ulasan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-center mt-4">
            <a href="{{ route('market.index') }}" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Market
            </a>
        </div>
    </div>
</div>

<!-- Modal Negosiasi (Hanya untuk Pengepul) -->
@if(auth()->check() && auth()->user()->peran == 'pengepul')
<div class="modal fade" id="negotiationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white"><i class="fas fa-comments me-2"></i>Negosiasi Harga</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="negotiationForm" method="POST" action="{{ route('market.negotiate', $product->id_produk) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Harga Tawaran (Rp/kg)</label>
                        <input type="number" name="tawaran_harga" class="form-control" required min="0" step="1000" placeholder="Contoh: 12000">
                        <x-input-error :messages="$errors->get('tawaran_harga')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pesan untuk Petani (Opsional)</label>
                        <textarea name="pesan" class="form-control" rows="3" placeholder="Tulis alasan tawaran Anda atau detail tambahan..."></textarea>
                        <x-input-error :messages="$errors->get('pesan')" class="mt-2" />
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Tawaran
                    </button>
                </form>
                <div class="alert alert-info mt-3">
                    <small>Status negosiasi akan diberitahukan melalui notifikasi. Petani dapat menerima, menolak, atau balas tawaran.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    // Hitung total harga saat input jumlah berubah (untuk pengepul)
    document.querySelector('input[name="jumlah"]')?.addEventListener('input', function() {
        const jumlah = parseInt(this.value) || 0;
        const harga = {{ $product->harga }};
        const total = jumlah * harga;
        document.getElementById('totalHarga').textContent = new Intl.NumberFormat('id-ID').format(total);
    });

    function openNegotiation(productId) {
        document.getElementById('productId').value = productId; // Jika ada hidden input
        new bootstrap.Modal(document.getElementById('negotiationModal')).show();
    }

    function confirmDelete(productId) {
        if (confirm('Yakin ingin menghapus produk ini?')) {
            window.location.href = `/market/${productId}/delete`; // Asumsi route
        }
    }
</script>

<style>
    .product-detail-card {
        background: linear-gradient(135deg, #4CAF50, #81C784);
        backdrop-filter: blur(10px);
        border: 1px solid #FF9800;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        color: #fff;
        padding: 2rem;
    }
    
    .product-detail-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #FF9800, #4CAF50);
    }
    
    .product-detail-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }
    
    .title-box {
        background: linear-gradient(135deg, #FF9800, #FFB74D);
        border: 1px solid #2E7D32;
        border-radius: 16px;
        padding: 16px 24px;
        text-align: center;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        display: inline-block;
        width: auto;
        margin: 0 auto;
    }
    
    .title-box:hover {
        transform: translateY(-2px) scale(1.01);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }
    
    .image-section {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
    }
    
    .product-detail-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 12px;
    }
    
    .product-placeholder-large {
        width: 100%;
        height: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: rgba(255, 255, 255, 0.6);
        border: 2px dashed rgba(255, 255, 255, 0.3);
    }
    
    .info-section {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        height: 100%;
    }
    
    .info-grid {
        display: grid;
        gap: 1rem;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.05);
        padding: 0.75rem;
        border-radius: 8px;
        border-left: 3px solid #FF9800;
    }
    
    .info-item.full-width {
        flex-direction: column;
        align-items: flex-start;
        border-left-color: #4CAF50;
    }
    
    .info-item strong {
        min-width: 120px;
        font-size: 0.95rem;
    }
    
    .info-item span, .info-item p {
        font-size: 0.95rem;
        flex: 1;
    }
    
    .buy-section {
        background: rgba(255, 255, 255, 0.1);
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
    }
    
    .form-input-custom {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 8px;
        color: #fff;
        padding: 0.75rem;
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
    
    .total-preview {
        text-align: right;
        font-size: 1.1rem;
    }
    
    .btn-buy-direct, .btn-negotiate {
        padding: 12px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        border: none;
        font-size: 1rem;
    }
    
    .btn-buy-direct {
        background: linear-gradient(135deg, #4CAF50, #81C784);
        color: #fff;
    }
    
    .btn-buy-direct:hover {
        background: linear-gradient(135deg, #45a049, #66bb6a);
        transform: translateY(-2px);
    }
    
    .btn-negotiate {
        background: linear-gradient(135deg, #17a2b8, #20c997);
        color: #fff;
    }
    
    .btn-negotiate:hover {
        background: linear-gradient(135deg, #138496, #1ea085);
        transform: translateY(-2px);
    }
    
    .btn-back {
        display: inline-block;
        padding: 12px 24px;
        background: linear-gradient(135deg, #FF9800, #FFB74D);
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-back:hover {
        background: linear-gradient(135deg, #F57C00, #FF8F00);
        transform: translateY(-2px);
        color: #fff;
    }
    
    .rating-section .stars i {
        font-size: 1rem;
        margin