<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('negosiasis', function (Blueprint $table) {
            $table->foreignId('id_petani')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('negosiasis', function (Blueprint $table) {
            $table->dropForeign(['id_petani']);
            $table->dropColumn('id_petani');
        });
    }
};
