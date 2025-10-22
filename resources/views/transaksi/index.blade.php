@extends('layouts.main')

@section('content')

    <!-- Card Utama Aktivitas -->
    <div class="activity-card animate-fade-in">
        <div class="card-header-custom d-flex align-items-center justify-content-between mb-4">
            <h3 class="text-white mb-0 font-weight-bold">
                <i class="fas fa-list-ul me-2"></i>Daftar Aktivitas Transaksi
            </h2>
            <div class="stats-summary d-flex gap-3">
                <span class="badge bg-light text-dark px-3 py-2">
                    <i class="fas fa-chart-bar me-1"></i>Total: {{ $activities->count() }}
                </span>
            </div>
        </div>

        <div class="card-body">
            @if ($activities->isEmpty())
                <div class="empty-state text-center py-8">
                    <i class="fas fa-clock fs-1 text-light mb-4"></i>
                    <h4 class="text-light mb-2">Belum ada aktivitas transaksi yang tercatat</h4>
                    <p class="text-muted">Aktivitas akan muncul setelah Anda melakukan transaksi atau top-up.</p>
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-light mt-3">Kembali ke Dashboard</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0">
                        <thead>
                            <tr>
                                <th class="text-white">Jenis Aktivitas</th>
                                <th class="text-white">Deskripsi</th>
                                <th class="text-white">Jumlah</th>
                                <th class="text-white">Tanggal</th>
                                <th class="text-white">Status</th>
                                <th class="text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $index => $activity)
                                <tr class="animate-slide-in" style="animation-delay: {{ $index * 0.1 }}s;">
                                    <td class="text-light">
                                        <span class="type-badge
                                            @if($activity->type == 'purchase') badge-danger
                                            @elseif($activity->type == 'sale') badge-success
                                            @elseif($activity->type == 'topup') badge-info
                                            @elseif($activity->type == 'expenditure') badge-warning
                                            @else badge-secondary @endif">
                                            <i class="fas 
                                                @if($activity->type == 'purchase') fa-shopping-cart
                                                @elseif($activity->type == 'sale') fa-dollar-sign
                                                @elseif($activity->type == 'topup') fa-plus-circle
                                                @elseif($activity->type == 'expenditure') fa-minus-circle
                                                @else fa-question-circle @endif me-1"></i>
                                            {{ $activity->type_label }}
                                        </span>
                                    </td>
                                    <td class="text-success font-medium">{{ $activity->description }}</td>
                                    <td class="text-light font-weight-bold">
                                        @if($activity->type == 'purchase' || $activity->type == 'expenditure')
                                            <i class="fas fa-minus text-danger me-1"></i>
                                            <span class="text-danger">-Rp {{ number_format($activity->amount, 0, ',', '.') }}</span>
                                        @else
                                            <i class="fas fa-plus text-success me-1"></i>
                                            <span class="text-success">+Rp {{ number_format($activity->amount, 0, ',', '.') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-success">
                                        <i class="fas fa-calendar-alt me-1 text-info"></i>
                                        {{ \Carbon\Carbon::parse($activity->date)->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        <span class="status-badge
                                            @if($activity->status == 'confirmed' || $activity->status == 'completed') badge-success
                                            @elseif($activity->status == 'pending') badge-warning
                                            @elseif($activity->status == 'cancelled' || $activity->status == 'failed') badge-danger
                                            @else badge-secondary @endif">
                                            <i class="fas 
                                                @if($activity->status == 'confirmed' || $activity->status == 'completed') fa-check-circle
                                                @elseif($activity->status == 'pending') fa-clock
                                                @elseif($activity->status == 'cancelled' || $activity->status == 'failed') fa-times-circle
                                                @else fa-question-circle @endif me-1"></i>
                                            {{ ucfirst($activity->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('transaksi.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aktivitas transaksi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination jika diperlukan (asumsi dari Laravel) -->
                @if(method_exists($activities, 'links'))
                    <div class="pagination-wrapper mt-4">
                        {{ $activities->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

<style>
    .activity-card {
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
    
    .activity-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #FF9800, #4CAF50);
    }
    
    .activity-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }
    
    .title-box {
        background: linear-gradient(135deg, #FF9800, #FFB74D);
        border: 1px solid #2E7D32;
        border-radius: 16px;
        padding: 12px 24px;
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
    
    .card-header-custom {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        border-radius: 12px;
        padding: 20px;
        backdrop-filter: blur(5px);
        margin-bottom: 0;
    }
    
    .stats-summary .badge {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    
    .stats-summary .badge:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }
    
    .table-custom {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        overflow: hidden;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .table-custom thead th {
        background: linear-gradient(135deg, rgba(255, 152, 0, 0.3), rgba(255, 183, 77, 0.3));
        border: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        padding: 16px 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
    }
    
    .table-custom tbody td {
        padding: 16px 12px;
        border: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        vertical-align: middle;
        transition: all 0.3s ease;
    }
    
    .table-custom tbody tr {
        background: rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }
    
    .table-custom tbody tr:nth-child(even) {
        background: rgba(255, 255, 255, 0.08);
    }
    
    .table-custom tbody tr:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: scale(1.01);
    }
    
    .type-badge, .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        border: 1px solid;
    }
    
    .badge-success {
        background: rgba(40, 167, 69, 0.3);
        color: #fff;
        border-color: #28a745;
    }
    
    .badge-danger {
        background: rgba(220, 53, 69, 0.3);
        color: #fff;
        border-color: #dc3545;
    }
    
    .badge-warning {
        background: rgba(255, 193, 7, 0.3);
        color: #fff;
        border-color: #ffc107;
    }
    
    .badge-info {
        background: rgba(23, 162, 184, 0.3);
        color: #fff;
        border-color: #17a2b8;
    }
    
    .badge-secondary {
        background: rgba(108, 117, 125, 0.3);
        color: #fff;
        border-color: #6c757d;
    }
    
    .type-badge:hover, .status-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
    
    .empty-state {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 40px 20px;
        backdrop-filter: blur(5px);
        border: 1px dashed rgba(255, 255, 255, 0.3);
    }
    
    .empty-state i {
        opacity: 0.5;
        color: rgba(255, 255, 255, 0.5);
    }
    
    .pagination-wrapper {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 15px;
        backdrop-filter: blur(5px);
        text-align: center;
    }
    
    .pagination-wrapper .pagination .page-link {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #fff;
        margin: 0 2px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .pagination-wrapper .pagination .page-link:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-1px);
    }
    
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #FF9800, #FFB74D);
        border-color: #FF9800;
    }
    
    /* Animasi */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    .animate-fade-in { animation: fadeInUp 0.6s ease-out forwards; }
    .animate-slide-in { animation: slideIn 0.4s ease-out forwards; }
    
    /* Responsiveness */
    @media (max-width: 768px) {
        .title-box {
            padding: 10px 20px;
            width: 100%;
            display: block;
        }
        
        .text-3xl { font-size: 1.75rem !important; }
        
        .card-header-custom {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
        
        .stats-summary {
            justify-content: center;
        }
        
        .table-custom thead th,
        .table-custom tbody td {
            padding: 12px 8px;
            font-size: 0.875rem;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
    }
</style>