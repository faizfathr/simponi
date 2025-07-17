<?php

namespace App\Livewire\WhatsappReminder;

use App\Models\KontakWa;
use App\Models\ReminderHistory;
use App\Services\FonteService;
use Carbon\Carbon;
use Livewire\Component;

class Reminder extends Component
{
    public string $no_tujuan = '', $pesan, $pesanNotif = 'selamat', $statusNotif = 'berhasil';
    public bool $openForm = false, $showNotif = false;
    public $info;
    public $scheduled_at;

    public function mount()
    {
        $fonnte = new FonteService;
        $this->info = $fonnte->getInfo();
    }

    public function render()
    {
        $daftarKontak = KontakWa::all();
        $history = ReminderHistory::get();
        return view('livewire.whatsapp-reminder.reminder', compact('history', 'daftarKontak'));
    }

    public function insertHistory()
    {
        $this->validate(
            [
                'no_tujuan' => 'required|min:11',
                'pesan' => 'required|min:5',
                'scheduled_at' => 'required|date|after:now'
            ],
            [
                'no_tujuan.required' => 'Nomor tujuan harus diisi',
                'no_tujuan.min' => 'Nomor tujuan minimal 11 digit',
                'pesan.required' => 'Pesan harus diisi',
                'pesana.min' => 'Pesan minimal 5 kata',
                'scheduled_at.required' => 'Tanggal reminder harus diisi',
                'scheduled_at.date' => 'Isian harus berupa tanggal yang valid',
                'scheduled_at.after' => 'Tanggal reminder harus lebih dari waktu sekarang',
            ]
        );
        ReminderHistory::insert([
            'pesan' => $this->pesan,
            'no_tujuan' => $this->no_tujuan,
            'scheduled_at' => $this->scheduled_at,
            'created_at' => Carbon::now(),
            'updated_at' => carbon::now(),
        ]);

        // $fonte = new FonteService;
        // $this->scheduled_at = Carbon::parse($this->scheduled_at, 'Asia/Jakarta')
        //     ->setTimezone('UTC')
        //     ->timestamp;
        // $fonte->sendMessage($this->no_tujuan, $this->pesan, (string) $this->scheduled_at);
        $this->openForm = FALSE;
        $this->showNotif = TRUE;
        $this->pesanNotif = "Reminder berhasil dibuat!";
        $this->statusNotif = "Berhasil";
    }
}
