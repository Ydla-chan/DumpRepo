<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backlogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rapat_id')->nullable();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['draft','published','archived'])->default('draft');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backlogs');
    }
};
