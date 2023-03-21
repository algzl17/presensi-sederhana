<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'mst_karyawan';
    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'nama',
        'telp',
        'nik',
        'id_jabatan'
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}
