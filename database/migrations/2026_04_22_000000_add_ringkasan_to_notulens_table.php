<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('notulens', function (Blueprint $table) {
            $table->longText('ringkasan')->nullable()->after('tanggal');
            $table->timestamp('ringkasan_generated_at')->nullable()->after('ringkasan');
        });
    }

    public function down(): void {
        Schema::table('notulens', function (Blueprint $table) {
            $table->dropColumn(['ringkasan', 'ringkasan_generated_at']);
        });
    }
};
