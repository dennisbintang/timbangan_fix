<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanFungsiAlat extends Model
{
    use HasFactory;

    protected $fillable = [
        'administrasi_id',
        'bagian_alat',
        'fisik',
        'fungsi',
    ];

    public function administrasi()
    {
        return $this->belongsTo(Administrasi::class);
    }
}
