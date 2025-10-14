<?php

namespace App\Console\Commands;
use Symfony\Component\Process\Process;
use Illuminate\Console\Command;

class TestingDev extends Command
{
    // Nama command
    protected $signature = 'dev';

    // Deskripsi command
    protected $description = 'Build frontend Vue dan jalankan Laravel server';

    public function handle()
    {
        $this->info('🚀 Build frontend Vue...');
        // Jalankan npm run build
        passthru('npm run build');

        $this->info('✅ Build selesai!');
        $this->info('🌐 Menjalankan Laravel server di http://127.0.0.1:8000 ...');

        // Jalankan Laravel server
        passthru('php artisan serve --port=8000');
    }
}
