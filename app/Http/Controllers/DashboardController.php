<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Mitra;
use App\Models\ListKegiatan;
use Illuminate\Http\Request;
use App\Models\KegiatanSurvei;
use App\Models\MonitoringKegiatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\StrukturTabelMonitoring;
use Illuminate\Database\Query\JoinClause;

class DashboardController extends Controller
{
    public $event;
    public $prosess, $sampel;
    public $fileImport;
    public $idPage = null;

    public function data(Request $request)
    {
        $subsektor = $request->subsektor;

        // 1. Data target per kegiatan dan waktu
        $target = ListKegiatan::join('kegiatan_survei', function ($join) use ($subsektor) {
            $join->on('id_kegiatan', '=', 'kegiatan_survei.id')
                ->where([
                    ['kegiatan_survei.periode', '<>', 4],
                    ['subsektor', '=', $subsektor],
                ]);
        })
            ->select('id_kegiatan', 'kegiatan_survei.periode', 'waktu', 'target')
            ->get();

        // 2. Data realisasi per kegiatan dan waktu
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

        // 4. Gabungan berdasarkan id_kegiatan
        $indexedRealisasi = $realisasi->keyBy(fn($item) => $item->id_tabel . '-' . $item->waktu);

        foreach ($target as $t) {
            $key = $t->id_kegiatan . '-' . $t->waktu;
            $t->realisasi = $indexedRealisasi[$key]->realisasi ?? 0;
        }

        $hasil = $target->groupBy('id_kegiatan')->map(function ($items, $id_kegiatan) {
            $periode = intVal($items->first()['periode']);

            // menentukan kategori dan range waktu sesuai periode masing-masing kegiatan
            [$categories, $range] = match ($periode) {
                1 => [['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'], range(1, 12)],
                2 => [['Triwulan I', 'Triwulan II', 'Triwulan III', 'Triwulan IV'], range(1, 4)],
                3 => [['Subround 1', 'Subround 2', 'Subround 3'], range(1, 3)],
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

    public function aggregatProgres()
    {
        $tahun = request()->input('tahun', 2025);
        $outputKegiatan = MonitoringKegiatan::selectRaw("
            DATE_FORMAT(updated_at, '%m') as bulan,
            COUNT(CASE WHEN status = 2 THEN 1 END) as progres,
            tahun
        ")
            ->where('tahun', $tahun)
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%m'), tahun"))
            ->orderBy('bulan')
            ->get();

        $dataPerBulan = $outputKegiatan->pluck('progres', 'bulan');

        $outputKegiatanArr = [];

        foreach (range(1, 12) as $bulan) {
            $bulanStr = str_pad($bulan, 2, '0', STR_PAD_LEFT); 
            $outputKegiatanArr[] = (int) ($dataPerBulan[$bulanStr] ?? 0);
        }
        return response()->json($outputKegiatanArr);
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

        $arrProses = explode(',', $template->proses);
        $arrSampel = explode(',', $template->ket_sampel);
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
            "Content-Disposition" => "attachment; filename=" . $fileName . ".csv",
            'Cache-Control' => 'no-store, no-cache'
        ]);
    }

    public function downloadDirektori()
    {
        $data = Mitra::get();
        $fileName = 'direktori_mitra.csv';
        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, ['id', 'Nama', 'No Rekening', 'Status'], ";");

        foreach ($data as $mitra) {
            fputcsv($handle, [$mitra->id, $mitra->nama, $mitra->no_rek, $mitra->status], ";");
        }
        // Pindahkan pointer file kembali ke awal
        rewind($handle);
        return response()->stream(function () use ($handle) {
            fpassthru($handle);
        }, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $fileName,
            'Cache-Control' => 'no-store, no-cache'
        ]);
    }

    public function listJadwal()
    {
        $listEventKegiatan = ListKegiatan::join('kegiatan_survei', 'id_kegiatan', 'kegiatan_survei.id')
            ->select('list_kegiatan.id', 'kegiatan_survei.alias', 'kegiatan_survei.subSektor', 'tanggal_mulai', 'tanggal_selesai')
            ->get();
        return response()->json($listEventKegiatan);
    }

    public function getDataResume()
    {
        $query = explode(",",request()->input('query'));
        $data = MonitoringKegiatan::join('list_kegiatan', function ($join) {
            $join->on('monitoring_kegiatan.id_tabel', '=', 'list_kegiatan.id_kegiatan')
                ->on('monitoring_kegiatan.waktu', '=', 'list_kegiatan.waktu')
                ->on('monitoring_kegiatan.tahun', '=', 'list_kegiatan.tahun');
        })->join('kegiatan_survei', function ($join) {
            $join->on('monitoring_kegiatan.id_tabel', '=', 'kegiatan_survei.id');
        })->join('struktur_tabel_monitoring', function ($join) {
            $join->on('monitoring_kegiatan.id_tabel', '=', 'struktur_tabel_monitoring.id');
        })
            ->where('kegiatan_survei.kegiatan', 'like', '%' . $query[0] . '%')
            ->where('list_kegiatan.waktu', trim($query[1]))
            ->where('list_kegiatan.tahun', trim($query[2]))
            ->selectRaw('
                kegiatan_survei.kegiatan,
                list_kegiatan.target,
                struktur_tabel_monitoring.proses,
                SUM(CASE WHEN monitoring_kegiatan.status = 2 THEN 1 ELSE 0 END) as realisasi,
                SUM(CASE WHEN monitoring_kegiatan.status = 0 THEN 1 ELSE 0 END) as belumSelesai,
                SUM(CASE WHEN monitoring_kegiatan.status = 1 THEN 1 ELSE 0 END) as onProgres
            ')
            ->groupBy('kegiatan_survei.kegiatan', 'list_kegiatan.target', 'proses')
            ->get();
        return response()->json($data);
    }

    public function getDataByStatus(Request $request)
    {
        $tahun = $request->tahun;
        $waktu = $request->waktu;
        $id = $request->id;

        $dataByStatus = MonitoringKegiatan::where('id_tabel', $id)
            ->where('tahun', $tahun)
            ->where('waktu', $waktu)
            ->selectRaw('
                SUM(CASE WHEN monitoring_kegiatan.status = 0 THEN 1 ELSE 0 END) as belum_mulai,
                SUM(CASE WHEN monitoring_kegiatan.status = 1 THEN 1 ELSE 0 END) as on_progres,
                SUM(CASE WHEN monitoring_kegiatan.status = 2 THEN 1 ELSE 0 END) as selesai
            ')
            ->get();
        return response()->json($dataByStatus);
    }

    public function getListMonitoringById(Request $request)
    {
        $id = $request->id;
        $data = ListKegiatan::join('kegiatan_survei', 'list_kegiatan.id_kegiatan', 'kegiatan_survei.id')
            ->where('id_kegiatan', $id)
            ->get();
        return response()->json($data);
    }
}
