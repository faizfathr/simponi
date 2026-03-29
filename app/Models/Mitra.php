<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $table = 'mitra';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nama', 'no_rek', 'status', 'jabatan', 'golongan', 'nip'];

    public function getKegiatanPml()
    {
        return $this->hasMany(MonitoringKegiatan::class, 'pml', 'id');
    }

    public function getKegiatanPcl()
    {
        return $this->hasMany(MonitoringKegiatan::class, 'pcl', 'id');
    }

    public function getJabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan', 'id');
    }

    public function getGolongan()
    {
        return $this->belongsTo(PangkatGolongan::class, 'golongan', 'id');
    }
}
