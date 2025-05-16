<?php

namespace App\Http\Controllers;

use App\Models\ListKegiatan;
use App\Models\MonitoringKegiatan;
use Illuminate\Http\Request;

class DataRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dataKsa($id)
    {
        $realisasi = MonitoringKegiatan::where([
            ['id_tabel', '=', $id],
            ['tahun', '=', 2025],
        ])->selectRaw('id_tabel, tahun, waktu, Count(*) as Realisasi')
            ->groupBy('tahun', 'tahun')
            ->get();
        $target = ListKegiatan::where([
            ['id_kegiatan', '=',$id],
            ['tahun', '=',2025],
        ])->groupBy('waktu')
            ->orderBy('waktu')
            ->get();
        return response()->json([
            'realisasi' => $realisasi->Realisasi,
            'target' => $target->target,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
