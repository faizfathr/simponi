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

class DashboardController extends Controller
{
    public $event;
    public $prosess, $sampel;
    public $fileImport;
    public $idPage = null;
    public function index()
    {
        $data = StrukturTabelMonitoring::join('kegiatan_survei', function (JoinClause $join) {
            $join->on('struktur_tabel_monitoring.id', '=', 'kegiatan_survei.id');
        })->get();

        // $data = Kecamatan::first()->toKelurahan()->get();
        return view('dashboard', [
            'struk' => $data,
            'idPage' => $this->idPage,
        ]);
    }

    public function pageDetail($id)
    {
        $idPage = $id;
        return view('dashboard', [
            'idPage' => $id
        ]);
    }

    public function data(Request $request)
    {
        $survei = $request->survei;
        $kegiatan = KegiatanSurvei::where('kegiatan', $survei)->first();
        $realisasi = MonitoringKegiatan::where([
            ['id_tabel', '=', $kegiatan->id],
            ['tahun', '=', 2025],
        ])->selectRaw('waktu, COUNT(*) as realisasi')
            ->groupBy('waktu')
            ->orderBy('waktu')
            ->get()
            ->pluck('realisasi', 'waktu');

        $target = ListKegiatan::where([
            ['id_kegiatan', '=', $kegiatan->id],
            ['tahun', '=', 2025],
        ])->select('waktu', 'target')
            ->orderBy('waktu')
            ->get()
            ->pluck('target', 'waktu');

        return response()->json([
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'series' => [
                [
                    'name' => 'Target',
                    'data' => collect(range(1, 12))->map(fn($bulan) => $target[$bulan] ?? 0),
                ],
                [
                    'name' => 'Realisasi',
                    'data' => collect(range(1, 12))->map(fn($bulan) => $realisasi[$bulan] ?? 0),
                ]
            ]
        ]);
    }

    public function dataInPersentase(Request $request)
    {
        $survei = $request->survei;
        $tahun = $request->tahun;

        $specifySurvei = KegiatanSurvei::where('kegiatan', $survei)
            ->first();
        $monitoring = MonitoringKegiatan::where([
            ['id_tabel', '=', $specifySurvei->id],
            ['tahun', '=', $tahun],
            ['status', '=', 2]
        ])->selectRaw('status, count(*) as realisasi')
            ->groupBy('status')
            ->get()
            ->pluck('realisasi');
        
        $listKegiatan = ListKegiatan::where([
            ['id_kegiatan', '=', $specifySurvei->id],
            ['tahun', '=', $tahun]
        ])->first();
        return response()->json([
            'persentase' => $listKegiatan->target === 0 ? 0 : number_format($monitoring[0]/$listKegiatan->target*100, 2)
        ]);
    }

    public function downloadTabel($idTabel)
    {
        $template = StrukturTabelMonitoring::where('id', $idTabel)->first();
        if (!$template) {
            return response()->json(['error' => 'Template tidak ditemukan'], 404);
        }

        // Gabungkan data menjadi satu baris array
        $rowData = [];
        
        $arrProses = explode(';', $template->proses);
        $arrSampel = explode(';', $template->ket_sampel);
        array_push($rowData, $template->no);
        $rowData = [...$rowData, ...$arrSampel];
        array_push($rowData, $template->jadwal);
        $rowData = [...$rowData, ...$arrProses];
        array_push($rowData, $template->status, $template->pcl, $template->pml);
        
        
        $arrHeadSampel = ['Sampel'];
        $arrHeadProses = ['Proses'];
        $counter = collect($arrSampel)->count()-1; 
        while($counter > 0) {
            array_push($arrHeadSampel, '');
            $counter--;
        }
        $counter = collect($arrProses)->count()-1; 
        while($counter > 0) {
            array_push($arrHeadProses, '');
            $counter--;
        }
        $header = ['No', ...$arrHeadSampel, 'Jadwal', ...$arrHeadProses, 'Status', 'PCL', 'PML'];

        // Buat file CSV di memori
        $handle = fopen('php://temp', 'r+');

        // Tulis header ke dalam CSV
        fputcsv($handle, $header);

        // Tulis data ke dalam CSV
        fputcsv($handle, $rowData);

        // Pindahkan pointer file kembali ke awal
        rewind($handle);

        return response()->stream(function () use ($handle) {
            fpassthru($handle);
        }, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=template.csv",
            'Cache-Control' => 'no-store, no-cache'
        ]);
    }
}
