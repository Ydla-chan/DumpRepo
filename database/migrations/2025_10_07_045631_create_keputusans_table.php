<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('decisions', function (Blueprint $table) {
            $table->id();

            // pokok_bahasan_id → discussion_point_id
            $table->foreignId('discussion_point_id')
                  ->constrained('discussion_points')
                  ->onDelete('cascade');

            // isi_keputusan → decision_text
            $table->text('decision_text');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('decisions');
    }
};
