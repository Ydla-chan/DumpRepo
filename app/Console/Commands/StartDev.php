<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class StartDev extends Command
{
    protected $signature = 'start';
    protected $description = 'Menjalankan Laravel server + Vite (npm run dev) secara bersamaan';

    protected $laravelProcess;
    protected $viteProcess;

    public function handle()
    {
        $this->info('🚀 Menjalankan Laravel server & Vite (npm run dev)...');

        // Jalankan Laravel server
        $this->laravelProcess = new Process(['php', 'artisan', 'serve']);
        $this->laravelProcess->setTty(Process::isTtySupported());
        $this->laravelProcess->start();

        // Jalankan npm run dev
        $this->viteProcess = new Process(['npm', 'run', 'dev']);
        $this->viteProcess->setTty(Process::isTtySupported());
        $this->viteProcess->start();

        // Loop untuk baca output secara realtime
        while ($this->laravelProcess->isRunning() || $this->viteProcess->isRunning()) {
            $this->readProcessOutput($this->laravelProcess, 'Laravel');
            $this->readProcessOutput($this->viteProcess, 'Vite');
            usleep(100000); // kurangi beban CPU
        }

        $this->info("✅ Semua proses selesai!");
    }

    protected function readProcessOutput(Process $process, string $prefix)
    {
        if ($process->isRunning()) {
            $output = $process->getIncrementalOutput();
            $errorOutput = $process->getIncrementalErrorOutput();

            if ($output) {
                $this->output->write("<info>[{$prefix}]</info> {$output}");
            }

            if ($errorOutput) {
                $this->output->write("<error>[{$prefix}]</error> {$errorOutput}");
            }
        }
    }
}
