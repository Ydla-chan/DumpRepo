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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');                      // judul
            $table->string('agenda');                     // agenda
            $table->date('date');                         // tanggal
            $table->time('time');                         // jam
            $table->json('invitation')->nullable();    // undangan
            $table->enum('location_type', ['online', 'offline']); // tipe lokasi
            $table->string('meeting_link')->nullable();   // link
            $table->string('room_name')->nullable();      // ruangan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
