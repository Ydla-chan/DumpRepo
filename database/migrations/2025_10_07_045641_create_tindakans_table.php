<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();

            // keputusan_id → decision_id (relasi ke decisions)
            $table->foreignId('decision_id')
                  ->constrained('decisions')
                  ->onDelete('cascade');

            // pic_id → assigned_user_id
            $table->foreignId('assigned_user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // deskripsi → description
            $table->text('description')->nullable();

            $table->date('deadline')->nullable();

            $table->enum('status', ['pending', 'in_progress', 'done'])
                  ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('actions');
    }
};
