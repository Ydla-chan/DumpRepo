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
        Schema::create('rapats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pembuat_id')->constrained('users')->onDelete('cascade');

    $table->string('judul');
    $table->string('agenda');
    $table->date('tanggal');
    $table->time('jam');
    $table->json('undangan')->nullable();
    $table->enum('tipe_lokasi', ['online', 'offline']);
    $table->string('link')->nullable();
    $table->string('ruangan')->nullable();
    $table->timestamps();

        });

    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapats');
    }
};
