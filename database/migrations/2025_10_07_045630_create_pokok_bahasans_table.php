<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('discussion_points', function (Blueprint $table) {
            $table->id();

            // notulen_id → minute_id (relasi ke tabel minutes)
            $table->foreignId('minute_id')
                  ->constrained('minutes')
                  ->onDelete('cascade');

            // judul → title
            $table->string('title');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('discussion_points');
    }
};
