<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pokok_bahasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notulen_id')->constrained('notulens')->onDelete('cascade');
            $table->string('judul');
            $table->text('')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pokok_bahasans');
    }
};
