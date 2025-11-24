<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('backlog_id');
            $table->unsignedBigInteger('pic_id');
            $table->text('pekerjaan');
            $table->date('deadline')->nullable();
            $table->tinyInteger('progress')->default(0); // 0–100
            $table->enum('status', ['todo','on_progress','review','done','overdue'])->default('todo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
