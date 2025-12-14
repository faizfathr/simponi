<?php

namespace App\Livewire\WhatsappReminder;

use App\Models\KontakWa;
use App\Models\ReminderHistory;
use App\Services\FonteService;
use Carbon\Carbon;
use Livewire\Component;

class Reminder extends Component
{
    public string $no_tujuan = '', $pesan = "Pesan \n📅 Tanggal:  ", $pesanNotif = 'selamat', $statusNotif = 'berhasil', $headerPesan = '🔔 Hai aku SIMPONI BPS Kota Singkawang, sistem reminder andalanmu!, Jangan lupa kamu punya agenda sebagai berikut.', $footerPesan = "Tetap semangat dan terus berkolaborasi 😊, Terimakasih.\n-Tim Statistik Produksi.";
    public bool $openForm = false, $showNotif = false;
    public $info;
    public $scheduled_at;

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
                'headerPesan' => 'required|string|min:5',
                'pesan' => 'required|min:5',
                'scheduled_at' => 'required|date|after:now'
            ],
            [
                'no_tujuan.required' => 'Nomor tujuan harus diisi',
                'no_tujuan.min' => 'Nomor tujuan minimal 11 digit',
                'pesan.required' => 'Pesan harus diisi',
                'pesan.min' => 'Pesan minimal 5 kata',
                'headerPesan.required' => 'Header pesan harus diisi',
                'headerPesan.min' => 'Header pesan minimal 5 kata',
                'scheduled_at.required' => 'Tanggal reminder harus diisi',
                'scheduled_at.date' => 'Isian harus berupa tanggal yang valid',
                'scheduled_at.after' => 'Tanggal reminder harus lebih dari waktu sekarang',
            ]
        );
        $mergedPesan = $this->headerPesan . "\n" . "\n" . $this->pesan . "\n" . "\n" . $this->footerPesan;

        $fonte = new FonteService;
        $this->scheduled_at = Carbon::parse($this->scheduled_at, 'Asia/Jakarta')
            ->setTimezone('UTC')
            ->timestamp;
        $responses = $fonte->sendMessage($this->no_tujuan, $mergedPesan, (string) $this->scheduled_at);
        if ($responses['status']) {
            ReminderHistory::insert([
                'pesan' => (string) $mergedPesan,
                'no_tujuan' => $this->no_tujuan,
                'scheduled_at' => (string) $this->scheduled_at,
                'id_messages' => implode(',', $responses['id']),
                'created_at' => Carbon::now(),
                'updated_at' => carbon::now(),
            ]);
            $this->openForm = FALSE;
            $this->showNotif = TRUE;
            $this->pesanNotif = "Reminder berhasil dibuat!";
            $this->statusNotif = "Berhasil";
        } else {
            $this->openForm = FALSE;
            $this->showNotif = TRUE;
            $this->pesanNotif = "Reminder gagal dibuat! Silahkan coba lagi.";
            $this->statusNotif = "Gagal";
            
        }
    }
}
