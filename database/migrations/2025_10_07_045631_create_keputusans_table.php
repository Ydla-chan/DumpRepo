<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('keputusans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pokok_bahasan_id')->constrained('pokok_bahasans')->onDelete('cascade');
            $table->text('isi_keputusan');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('keputusans');
    }
};
