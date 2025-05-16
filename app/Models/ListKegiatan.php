<?php

namespace App\Models;

use Google\Service\CloudRun\KeyToPath;
use Illuminate\Database\Eloquent\Model;

class ListKegiatan extends Model
{
    protected $table = 'list_kegiatan';

    protected $fillable = [
        'id_kegiatan',
        'tahun',
        'periode',
        'waktu',
        'target',
        'tanggal_mulai', 
        'tanggal_selesai',
    ];

    protected $primaryKey = 'id';

    public function joinKegiatan()
    {
        return $this->belongsTo(KegiatanSurvei::class, 'id_kegiatan','id');
    }
}
