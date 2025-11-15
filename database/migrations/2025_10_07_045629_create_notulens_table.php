<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('minutes', function (Blueprint $table) {
            $table->id();

            // rapat_id → meeting_id
            $table->foreignId('meeting_id')
                  ->constrained('meetings')
                  ->onDelete('cascade');

            // judul → title
            $table->string('title');

            // tanggal → date
            $table->date('date');

            // pembuat_id → creator_id
            $table->foreignId('creator_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('minutes');
    }
};
