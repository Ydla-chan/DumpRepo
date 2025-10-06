<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_lokasi_to_rapats_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rapats', function (Blueprint $table) {
            // Tambahkan baris ini. 'tipe_lokasi' adalah kolom sebelum 'lokasi' di query Anda,
            // jadi menempatkannya setelah itu akan membuat struktur lebih rapi.
            $table->string('lokasi')->after('tipe_lokasi')->nullable(); 
        });
    }

    public function down(): void
    {
        Schema::table('rapats', function (Blueprint $table) {
            $table->dropColumn('lokasi');
        });
    }
};