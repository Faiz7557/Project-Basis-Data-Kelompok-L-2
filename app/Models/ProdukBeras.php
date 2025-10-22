<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukBeras extends Model {
    use HasFactory;
    
    protected $table = 'produk_beras';
    protected $primaryKey = 'id_produk';

    public function getRouteKeyName()
    {
        return 'id_produk';
    }
    
    protected $fillable = [
        'nama_produk',
        'jenis_beras',
        'harga',
        'nama_petani',
        'lokasi_gudang',
        'stok',
        'deskripsi',
        'foto',
        'id_user'
    ];
    
    // Relasi dengan user (pemilik produk)
    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    
    // Relasi dengan transaksi
    public function transaksi() {
        return $this->hasMany(Transaksi::class, 'id_produk', 'id_produk');
    }
    
    // Relasi dengan negosiasi
    public function negosiasi() {
        return $this->hasMany(Negosiasi::class, 'id_produk', 'id_produk');
    }
}
