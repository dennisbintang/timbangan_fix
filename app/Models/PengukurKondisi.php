<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengukurKondisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'administrasi_id',
        'kondisi_ruang',
        'awal',
        'akhir',
        'toleransi',
    ];

    public function administrasi()
    {
        return $this->belongsTo(Administrasi::class);
    }
}
