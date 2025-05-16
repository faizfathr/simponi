<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';

    protected $fillable = [
        'id_kec',
        'kecamatan'
    ];

    protected $primaryKey = 'id_kec';

    public function toKelurahan()
    {
        return $this->hasMany(Kelurahan::class, 'id_kec', 'id_kec');
    }
}
