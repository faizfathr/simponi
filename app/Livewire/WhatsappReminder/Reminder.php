<?php

namespace App\Livewire\WhatsappReminder;

use App\Models\ReminderHistory;
use App\Services\FonteService;
use Carbon\Carbon;
use Livewire\Component;

class Reminder extends Component
{
    public string $no_tujuan = '', $pesan;
    public bool $openForm = false;
    public $scheduled_at;

    public function render()
    {
        $history = ReminderHistory::get();
        return view('livewire.whatsapp-reminder.reminder', compact('history'));
    }

    public function insertHistory()
    {
        ReminderHistory::insert([
            'pesan' => $this->pesan,
            'no_tujuan' => $this->no_tujuan,
            'scheduled_at' => $this->scheduled_at,
            'created_at' => Carbon::now(),
            'updated_at' => carbon::now(),
        ]);

        $fonte = new FonteService;
        $this->scheduled_at = Carbon::parse($this->scheduled_at, 'Asia/Jakarta')
            ->setTimezone('UTC')
            ->timestamp;
        $fonte->sendMessage($this->no_tujuan, $this->pesan, (string) $this->scheduled_at);

    }

}
