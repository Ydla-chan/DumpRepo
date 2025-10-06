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
        Schema::table('rapats', function (Blueprint $table) {
            // Tambahkan kolom datetime untuk menyimpan tanggal dan jam mulai
            $table->dateTime('waktu_mulai')->nullable()->after('jam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rapats', function (Blueprint $table) {
            // Logika untuk menghapus kolom jika migration di-rollback
            $table->dropColumn('waktu_mulai');
        });
    }
};