<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    protected $table = 'surat_tugas';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $fillable = [
        'nomor_surat',
        'nomor_surat_rujukan',
        'perihal',
        'kepala_surat_rujukan',
        'subtim',
        'tanggal_penandatanganan',
        'id_petugas',
        'tujuan_tugas',
        'tempat',
        'waktu_pelaksanaan',
        'penandatangan',
        'kegiatan',
        'pembebanan'
    ];
}
