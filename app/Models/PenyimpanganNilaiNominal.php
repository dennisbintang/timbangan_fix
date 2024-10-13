<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyimpanganNilaiNominal extends Model
{
    use HasFactory;

    protected $fillable = [
        'administrasi_id',
        'nominal_mass',
        'z1',
        'm1',
        'm1_',
    ];

    /**
     * Relasi dengan Administrasi
     */
    public function administrasi()
    {
        return $this->belongsTo(Administrasi::class);
    }
}
