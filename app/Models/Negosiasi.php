<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Negosiasi extends Model
{
    use HasFactory;

    protected $table = 'negosiasis'; // atau 'negosiasi' kalau nama tabel tunggal
}