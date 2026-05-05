<?php

namespace App\Services;

use App\Models\Notulen;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotulenSummaryService
{
    private $aiProvider; // 'openai' atau 'ollama'
    private $ollamaEndpoint = 'http://localhost:11434/api/generate';
    private $ollamaModel = 'kimi'; // atau model lain yang tersedia di Ollama
    private $openaiApiKey;
    private $openaiModel = 'gpt-3.5-turbo';
    private $openaiEndpoint = 'https://api.openai.com/v1/chat/completions';

    public function __construct()
    {
        // Tentukan provider yang digunakan
        $this->aiProvider = config('services.ai_provider', 'ollama'); // default menggunakan Ollama
        $this->openaiApiKey = config('services.openai.api_key');
    }

    /**
     * Generate ringkasan lengkap dari notulen menggunakan AI
     */
    public function generateSummary(Notulen $notulen): string
    {
        $pokokBahasans = $notulen->pokokBahasans()->with('keputusans.tindakans.pic')->get();
        
        if ($pokokBahasans->isEmpty()) {
            return "Tidak ada data pokok bahasan untuk diringkas.";
        }

        // Coba gunakan AI sesuai provider, jika gagal fallback ke metode manual
        $aiSummary = null;
        
        if ($this->aiProvider === 'ollama') {
            $aiSummary = $this->generateOllamaSummary($notulen, $pokokBahasans);
        } else if ($this->aiProvider === 'openai') {
            $aiSummary = $this->generateAISummary($notulen, $pokokBahasans);
        }

        if ($aiSummary !== null) {
            return $aiSummary;
        }

        // Fallback ke ringkasan manual
        Log::warning('AI Summary gagal, menggunakan ringkasan manual untuk notulen: ' . $notulen->id);
        $ringkasan = $this->buildHeader($notulen);
        $ringkasan .= $this->buildContent($pokokBahasans);

        return $ringkasan;
    }

    /**
     * Generate ringkasan menggunakan Ollama (Local AI)
     */
    private function generateOllamaSummary(Notulen $notulen, $pokokBahasans): ?string
    {
        try {
            // Format data untuk AI
            $notulenText = $this->formatNotulenForAI($notulen, $pokokBahasans);

            $prompt = "Buatkan ringkasan notulen yang ringkas, terstruktur, dan mudah dipahami dalam bahasa Indonesia dengan format yang rapi dan menggunakan emoji saat sesuai:\n\n" . $notulenText;

            // Kirim ke Ollama
            $response = Http::timeout(60)->post($this->ollamaEndpoint, [
                'model' => $this->ollamaModel,
                'prompt' => $prompt,
                'stream' => false,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $aiText = $response->json('response');
                Log::info('Ollama Summary berhasil dibuat untuk notulen: ' . $notulen->id);
                
                return $this->buildHeader($notulen) . "\n" . $aiText;
            }

            Log::error('Ollama API error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Exception saat generate Ollama summary: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate ringkasan menggunakan OpenAI API
     */
    private function generateAISummary(Notulen $notulen, $pokokBahasans): ?string
    {
        try {
            if (!$this->openaiApiKey) {
                Log::warning('OpenAI API key tidak ditemukan');
                return null;
            }

            // Format data untuk AI
            $notulenText = $this->formatNotulenForAI($notulen, $pokokBahasans);

            // Kirim ke OpenAI
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openaiApiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->openaiEndpoint, [
                'model' => $this->openaiModel,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Anda adalah penganalisis notulen profesional. Buat ringkasan notulen yang ringkas, terstruktur, dan mudah dipahami dalam bahasa Indonesia. Format dengan emoji dan struktur yang jelas.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Buatkan ringkasan notulen berikut dengan format yang rapi:\n\n" . $notulenText,
                    ],
                ],
                'temperature' => 0.7,
                'max_tokens' => 2000,
            ]);

            if ($response->successful()) {
                $aiText = $response->json('choices.0.message.content');
                Log::info('AI Summary berhasil dibuat untuk notulen: ' . $notulen->id);
                
                return $this->buildHeader($notulen) . $aiText;
            }

            Log::error('OpenAI API error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Exception saat generate AI summary: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Format notulen menjadi text untuk dikirim ke AI
     */
    private function formatNotulenForAI(Notulen $notulen, $pokokBahasans): string
    {
        $text = "Judul Rapat: " . $notulen->judul . "\n";
        $text .= "Tanggal: " . Carbon::parse($notulen->tanggal)->format('d F Y') . "\n";
        $text .= "Pembuat: " . ($notulen->pembuat ? $notulen->pembuat->name : 'Tidak diketahui') . "\n\n";

        $text .= "KONTEN NOTULEN:\n";
        $text .= str_repeat("=", 50) . "\n\n";

        $no = 1;
        foreach ($pokokBahasans as $pb) {
            $text .= "{$no}. POKOK BAHASAN: " . $pb->judul . "\n";
            
            if ($pb->deskripsi) {
                $text .= "   Deskripsi: " . $pb->deskripsi . "\n";
            }

            if ($pb->keputusans->isNotEmpty()) {
                $text .= "\n   KEPUTUSAN:\n";
                foreach ($pb->keputusans as $idx => $keputusan) {
                    $text .= "   {$idx}. " . $keputusan->isi_keputusan . "\n";

                    if ($keputusan->tindakans->isNotEmpty()) {
                        $text .= "      TINDAKAN LANJUT:\n";
                        foreach ($keputusan->tindakans as $tindakan) {
                            $pic_name = $tindakan->pic ? $tindakan->pic->name : 'TBD';
                            $deadline = $tindakan->deadline ? Carbon::parse($tindakan->deadline)->format('d-m-Y') : 'TBD';
                            $status = $tindakan->status ?? 'Pending';
                            
                            $text .= "      - {$tindakan->deskripsi}\n";
                            $text .= "        (PIC: {$pic_name}, Deadline: {$deadline}, Status: {$status})\n";
                        }
                    }
                }
            }

            $text .= "\n";
            $no++;
        }

        return $text;
    }

    /**
     * Build header ringkasan
     */
    private function buildHeader(Notulen $notulen): string
    {
        $header = "📋 RINGKASAN NOTULEN\n";
        $header .= "═══════════════════════════════════════════\n\n";
        $header .= "📌 Judul: " . $notulen->judul . "\n";
        $header .= "📅 Tanggal: " . Carbon::parse($notulen->tanggal)->format('d F Y') . "\n";
        $header .= "✍️  Pembuat: " . ($notulen->pembuat ? $notulen->pembuat->name : 'Tidak diketahui') . "\n";
        $header .= "─────────────────────────────────────────────\n\n";

        return $header;
    }

    /**
     * Build konten ringkasan berdasarkan pokok bahasan (Fallback)
     */
    private function buildContent($pokokBahasans): string
    {
        $content = "";
        $no = 1;

        foreach ($pokokBahasans as $pb) {
            $content .= "🔹 POKOK BAHASAN {$no}: " . $pb->judul . "\n";
            
            if ($pb->deskripsi) {
                $deskripsi = $this->truncate($pb->deskripsi, 200);
                $content .= "   Deskripsi: " . $deskripsi . "\n";
            }

            // Keputusan
            if ($pb->keputusans->isNotEmpty()) {
                $content .= "\n   📌 KEPUTUSAN:\n";
                foreach ($pb->keputusans as $idx => $keputusan) {
                    $content .= "      {$idx}. " . $keputusan->isi_keputusan . "\n";

                    // Tindakan dari keputusan ini
                    if ($keputusan->tindakans->isNotEmpty()) {
                        $content .= "         └─ TINDAKAN LANJUT:\n";
                        foreach ($keputusan->tindakans as $tindakan) {
                            $pic_name = $tindakan->pic ? $tindakan->pic->name : 'TBD';
                            $deadline = $tindakan->deadline ? Carbon::parse($tindakan->deadline)->format('d-m-Y') : 'TBD';
                            $status = $tindakan->status ?? 'Pending';
                            
                            $content .= "            ✓ {$tindakan->deskripsi}\n";
                            $content .= "              [PIC: {$pic_name} | Deadline: {$deadline} | Status: {$status}]\n";
                        }
                    }
                }
            }

            $content .= "\n";
            $no++;
        }

        return $content;
    }

    /**
     * Potong teks dengan menjaga kata utuh
     */
    private function truncate(string $text, int $limit = 200): string
    {
        if (strlen($text) <= $limit) {
            return $text;
        }

        $truncated = substr($text, 0, $limit);
        $lastSpace = strrpos($truncated, ' ');
        
        if ($lastSpace !== false) {
            $truncated = substr($truncated, 0, $lastSpace);
        }

        return $truncated . "...";
    }

    /**
     * Simpan ringkasan ke database
     */
    public function saveSummary(Notulen $notulen): Notulen
    {
        $ringkasan = $this->generateSummary($notulen);
        
        $notulen->update([
            'ringkasan' => $ringkasan,
            'ringkasan_generated_at' => Carbon::now(),
        ]);

        return $notulen;
    }

    /**
     * Generate ringkasan dalam format JSON (untuk API)
     */
    public function generateSummaryJson(Notulen $notulen): array
    {
        $pokokBahasans = $notulen->pokokBahasans()->with('keputusans.tindakans.pic')->get();
        
        $summary = [
            'notulen_id' => $notulen->id,
            'judul' => $notulen->judul,
            'tanggal' => $notulen->tanggal,
            'pembuat' => $notulen->pembuat ? $notulen->pembuat->name : null,
            'total_pokok_bahasan' => $pokokBahasans->count(),
            'total_keputusan' => 0,
            'total_tindakan' => 0,
            'pokok_bahasans' => [],
        ];

        foreach ($pokokBahasans as $pb) {
            $pbData = [
                'id' => $pb->id,
                'judul' => $pb->judul,
                'deskripsi' => $pb->deskripsi,
                'keputusan_count' => $pb->keputusans->count(),
                'keputusans' => [],
            ];

            foreach ($pb->keputusans as $keputusan) {
                $kData = [
                    'id' => $keputusan->id,
                    'isi' => $keputusan->isi_keputusan,
                    'tindakan_count' => $keputusan->tindakans->count(),
                    'tindakans' => [],
                ];

                foreach ($keputusan->tindakans as $tindakan) {
                    $kData['tindakans'][] = [
                        'id' => $tindakan->id,
                        'deskripsi' => $tindakan->deskripsi,
                        'pic' => $tindakan->pic ? $tindakan->pic->name : null,
                        'deadline' => $tindakan->deadline,
                        'status' => $tindakan->status,
                    ];
                }

                $pbData['keputusans'][] = $kData;
                $summary['total_keputusan']++;
                $summary['total_tindakan'] += $keputusan->tindakans->count();
            }

            $summary['pokok_bahasans'][] = $pbData;
        }

        return $summary;
    }
}
