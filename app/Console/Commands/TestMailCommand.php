<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends Command
{
    protected $signature = 'mail:test {email}';
    protected $description = 'Test kirim email menggunakan konfigurasi SMTP dari .env';

    public function handle()
    {
        $to = $this->argument('email');

        try {
            Mail::raw('Ini email tes dari Laravel menggunakan konfigurasi SMTP.', function ($message) use ($to) {
                $message->to($to)
                        ->subject('Tes SMTP dari Laravel');
            });

            $this->info("✅ Email tes berhasil dikirim ke: $to");
        } catch (\Exception $e) {
            $this->error("❌ Gagal mengirim email: " . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
