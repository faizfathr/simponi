<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';

    protected $fillable = [
        'id_kel',
        'kelurahan',
        'id_kec'
    ];

    protected $primaryKey = 'id_kel';
}
