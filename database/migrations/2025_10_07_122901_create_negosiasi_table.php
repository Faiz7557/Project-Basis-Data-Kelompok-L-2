<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('negosiasi', function (Blueprint $table) {
            $table->id();
            $table->string('produk')->nullable();
            $table->string('penawar')->nullable();
            $table->decimal('harga_penawaran', 15, 2)->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('negosiasi');
    }
};