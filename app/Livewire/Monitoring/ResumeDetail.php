<?php

namespace App\Livewire\Monitoring;

use App\Models\KegiatanSurvei;
use App\Models\MonitoringKegiatan;
use Livewire\Component;

class ResumeDetail extends Component
{
    public string $id = '';
    public int $tahun, $waktu;

    public function mount($id, $year, $waktu)
    {
        $this->id = $id;
        $this->tahun = $year;
        $this->waktu = $waktu;
    }
    public function render()
    {
        $survei = KegiatanSurvei::join('list_kegiatan', 'kegiatan_survei.id', '=', 'list_kegiatan.id_kegiatan')
            ->where('kegiatan_survei.id', $this->id)
            ->where('list_kegiatan.tahun', $this->tahun)
            ->where('list_kegiatan.waktu', $this->waktu)
            ->select('kegiatan_survei.*', 'list_kegiatan.*')
            ->first();
        $resumePetugas = MonitoringKegiatan::selectRaw('
            pcl,
            COUNT(*) as total_target,
            SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as belum_mulai,
            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as on_progres,
            SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as selesai
        ')
            ->where('id_tabel', $this->id)
            ->where('tahun', $this->tahun)
            ->where('waktu', $this->waktu)
            ->groupBy('pcl')
            ->get();
        $rekapPetugas = MonitoringKegiatan::selectRaw('
            COUNT(DISTINCT pcl) as pcl,
            COUNT(DISTINCT pml) as pml
            
        ')
            ->where('id_tabel', $this->id)
            ->where('tahun', $this->tahun)
            ->where('waktu', $this->waktu)
            ->first();
        $listSampel = MonitoringKegiatan::where('id_tabel', $this->id)
            ->where('tahun', $this->tahun)
            ->where('waktu', $this->waktu)
            ->select('ket_sampel', 'status')
            ->get()
            ->groupBy('status')
            ->map(function ($items) {
                return $items->pluck('ket_sampel');
            });
        return view('livewire.monitoring.resume-detail', compact('survei', 'resumePetugas', 'rekapPetugas', 'listSampel'));
    }
}
