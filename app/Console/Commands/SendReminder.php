<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\ListKegiatan;
use Illuminate\Console\Command;

class SendReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simponi:send-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending reminder via WhatsApp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->startOfDay();
        $messages = ListKegiatan::whereDate('tanggal_mulai', $tomorrow)
            ->get();
        $this->info('Menemukan ' . $messages->count() . ' kegiatan untuk dikirim.');
        foreach ($messages as $message) {
            $this->line("- " . $message->nama_kegiatan . ' (' . $message->tanggal_mulai . ')');
        }
        return 0;
    }
}
