<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\ListKegiatan;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\WithoutUrlPagination;

class ProgresPertanian extends Component
{
    use WithPagination, WithoutUrlPagination;
    public bool $openForm = FALSE;

    public string $qSearch = '';

    public int $tahun = 2025, $perPage = 10;

    public array $listBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    public array $ketPeriode = ['Bulan', 'Triwulan', 'Subround', 'Tahun'];

    public array $romawiFont = ["I", "II", "III", "IV"];

    public function render()
    {
        $subqueryRealisasi = DB::table('monitoring_kegiatan')
            ->select('id_tabel', 'waktu', 'tahun', DB::raw('COUNT(*) as realisasi'))
            ->where('status', 2)
            ->groupBy('id_tabel', 'waktu', 'tahun');

        if ($this->qSearch) {
            $progresPertanian = ListKegiatan::join('kegiatan_survei', 'list_kegiatan.id_kegiatan', '=', 'kegiatan_survei.id')
                ->leftJoinSub($subqueryRealisasi, 'monitoring_realisasi', function ($join) {
                    $join->on('list_kegiatan.id_kegiatan', '=', 'monitoring_realisasi.id_tabel')
                        ->whereColumn('list_kegiatan.waktu', '=', 'monitoring_realisasi.waktu')
                        ->whereColumn('list_kegiatan.tahun', '=', 'monitoring_realisasi.tahun');
                })
                ->select(
                    'list_kegiatan.*',
                    'kegiatan_survei.kegiatan',
                    'kegiatan_survei.periode',
                    DB::raw('COALESCE(monitoring_realisasi.realisasi, 0) as realisasi')
                )
                ->where('sektor', 1)
                ->whereLike('kegiatan', '%' . $this->qSearch . '%')
                ->orderBy('waktu', 'ASC')
                ->get();
        } else {
            $progresPertanian = ListKegiatan::join('kegiatan_survei', 'list_kegiatan.id_kegiatan', '=', 'kegiatan_survei.id')
                ->leftJoinSub($subqueryRealisasi, 'monitoring_realisasi', function ($join) {
                    $join->on('list_kegiatan.id_kegiatan', '=', 'monitoring_realisasi.id_tabel')
                        ->whereColumn('list_kegiatan.waktu', '=', 'monitoring_realisasi.waktu')
                        ->whereColumn('list_kegiatan.tahun', '=', 'monitoring_realisasi.tahun');
                })
                ->select(
                    'list_kegiatan.*',
                    'kegiatan_survei.kegiatan',
                    'kegiatan_survei.periode',
                    DB::raw('COALESCE(monitoring_realisasi.realisasi, 0) as realisasi')
                )
                ->where('sektor', 1)
                ->where('list_kegiatan.tahun', $this->tahun)
                ->orderBy('waktu', 'ASC')
                ->paginate($this->perPage);
        }
        return view('livewire.dashboard.progres-pertanian', [
            'data' => $progresPertanian,
        ]);
    }
}
