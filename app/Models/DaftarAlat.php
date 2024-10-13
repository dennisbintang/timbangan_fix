<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarAlat extends Model
{
    use HasFactory;

    protected $fillable = [
        'administrasi_id',
        'nama_alat',
        'merek_alat',
        'tipe_model',
        'no_seri',
    ];

    public function administrasi()
    {
        return $this->belongsTo(Administrasi::class);
    }
}
