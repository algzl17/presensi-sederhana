<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    protected $table = 'presensi';

    protected $fillable = [
        'tanggal',
        'id_karyawan',
        'masuk',
        'pulang',
    ];
}
