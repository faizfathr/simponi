<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\KegiatanSurvei;
use App\Models\Kelurahan;
use App\Models\ListKegiatan;
use Illuminate\Http\Request;
use App\Models\MonitoringKegiatan;
use App\Models\StrukturTabelMonitoring;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use stdClass;

class DashboardController extends Controller
{
    public $event;
    public $prosess, $sampel;
    public $fileImport;
    public $idPage = null;
    public function index()
    {
        return view('layouts.dashboard-layout');
    }

    public function pageDetail($id)
    {
        $idPage = $id;
        return view('home', [
            'idPage' => $id
        ]);
    }

    public function data(Request $request)
    {
        $subsektor = $request->subsektor;

        // 1. Ambil data target per kegiatan dan waktu
        $target = ListKegiatan::join('kegiatan_survei', function ($join) use ($subsektor) {
            $join->on('id_kegiatan', '=', 'kegiatan_survei.id')
                ->where([
                    ['kegiatan_survei.periode', '<>', 4],
                    ['subsektor', '=', $subsektor],
                ]);
        })
            ->select('id_kegiatan', 'kegiatan_survei.periode', 'waktu', 'target')
            ->get();

        // 2. Ambil data realisasi per kegiatan dan waktu
        $realisasi = MonitoringKegiatan::join('kegiatan_survei', function ($join) use ($subsektor) {
            $join->on('id_tabel', '=', 'kegiatan_survei.id')
                ->where([
                    ['kegiatan_survei.periode', '<>', 4],
                    ['subsektor', '=', $subsektor],
                ]);
        })
            ->where('status', 2)
            ->selectRaw('id_tabel, waktu, COUNT(*) as realisasi')
            ->groupBy('id_tabel', 'waktu')
            ->orderBy('id_tabel')
            ->get();

        // 4. Gabungkan berdasarkan id_kegiatan
        foreach ($target as $key => $t) {
            $t->realisasi = (isset($realisasi[$key]) && $t->id_kegiatan === $realisasi[$key]->id_tabel) ? $realisasi[0]->realisasi : 0;
        }

        $hasil = $target->groupBy('id_kegiatan')->map(function ($items, $id_kegiatan) {
            $periode = $items->first()['periode'];

            // Tentukan kategori dan range waktu sesuai periode masing-masing kegiatan
            [$categories, $range] = match ($periode) {
                1 => [['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'], range(1, 12)],
                2 => [['Subround 1', 'Subround 2', 'Subround 3'], range(1, 3)],
                3 => [['Triwulan I', 'Triwulan II', 'Triwulan III', 'Triwulan IV'], range(1, 4)],
                default => [[], []],
            };

            $byWaktu = $items->keyBy('waktu');

            return [
                'id_kegiatan' => $id_kegiatan,
                'periode' => $periode,
                'categories' => $categories,
                'target' => collect($range)->map(fn($w) => $byWaktu[$w]['target'] ?? 0)->toArray(),
                'realisasi' => collect($range)->map(fn($w) => $byWaktu[$w]['realisasi'] ?? 0)->toArray(),
            ];
        })->values();


        return response()->json($hasil);
    }

    public function dataInPersentase(Request $request)
    {
        $tahun = $request->tahun;
        $subsektor = $request->subsektor;

        // Ambil target berdasarkan kegiatan
        $surveiByTarget = KegiatanSurvei::where([
            ['subsektor', '=', $subsektor],
            ['periode', '=', 4],
        ])
            ->join('list_kegiatan', function ($join) {
                $join->on('kegiatan_survei.id', '=', 'id_kegiatan')
                    ->where('tahun', 2025);
            })
            ->select('id_kegiatan', 'target')
            ->get()
            ->keyBy('id_kegiatan'); // buat associative array berdasarkan ID

        // Ambil realisasi berdasarkan kegiatan
        $surveiByRealisasi = MonitoringKegiatan::join('kegiatan_survei', function ($join) use ($subsektor) {
            $join->on('monitoring_kegiatan.id_tabel', '=', 'kegiatan_survei.id')
                ->where([
                    ['kegiatan_survei.subsektor', '=', $subsektor],
                    ['kegiatan_survei.periode', '=', 4],
                ]);
        })
            ->where('monitoring_kegiatan.status', 2)
            ->selectRaw('monitoring_kegiatan.id_tabel as id_kegiatan, count(*) as realisasi')
            ->groupBy('monitoring_kegiatan.id_tabel')
            ->get()
            ->keyBy('id_kegiatan');

        // Gabungkan hasil berdasarkan ID
        $results = [];

        $ids = $surveiByTarget->keys()->merge($surveiByRealisasi->keys())->unique();

        foreach ($ids as $id) {
            $results[] = [
                'id' => $id,
                'target' => $surveiByTarget[$id]->target ?? 0,
                'realisasi' => $surveiByRealisasi[$id]->realisasi ?? 0,
            ];
        }

        return response()->json($results);
    }

    public function downloadTabel($idTabel)
    {
        $template = StrukturTabelMonitoring::where('id', $idTabel)->first();
        if (!$template) {
            return response()->json(['error' => 'Template tidak ditemukan'], 404);
        }

        // Gabungkan data menjadi satu baris array
        $survei = KegiatanSurvei::where('id', $idTabel)->first();
        $rowData = [];

        $arrProses = explode(';', $template->proses);
        $arrSampel = explode(';', $template->ket_sampel);
        $rowData = [...$rowData, ...$arrSampel];
        $rowData = [...$rowData, ...$arrProses];
        array_push($rowData, $template->status, $template->pcl, $template->pml);


        $arrHeadSampel = ['Sampel'];
        $arrHeadProses = ['Proses'];
        $counter = collect($arrSampel)->count() - 1;
        while ($counter > 0) {
            array_push($arrHeadSampel, '');
            $counter--;
        }
        $counter = collect($arrProses)->count() - 1;
        while ($counter > 0) {
            array_push($arrHeadProses, '');
            $counter--;
        }
        $header = [...$arrHeadSampel, ...$arrHeadProses, 'Status', 'PCL', 'PML'];

        // Buat file CSV di memori
        $handle = fopen('php://temp', 'r+');

        // Tulis header ke dalam CSV
        fputcsv($handle, $header, ";");

        // Tulis data ke dalam CSV
        fputcsv($handle, $rowData, ";");

        // Pindahkan pointer file kembali ke awal
        rewind($handle);

        $fileName = 'template_' . $survei->alias;
        return response()->stream(function () use ($handle) {
            fpassthru($handle);
        }, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $fileName .".csv",
            'Cache-Control' => 'no-store, no-cache'
        ]);
    }

    public function listJadwal()
    {
        $listEventKegiatan = ListKegiatan::join('kegiatan_survei', 'id_kegiatan', 'kegiatan_survei.id')
            ->select('list_kegiatan.id','kegiatan_survei.alias', 'tanggal_mulai', 'tanggal_selesai')
            ->get();
        return response()->json($listEventKegiatan);
    }
}
