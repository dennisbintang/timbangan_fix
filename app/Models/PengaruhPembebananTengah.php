<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaruhPembebananTengah extends Model
{
    use HasFactory;

    protected $fillable = [
        'administrasi_id',
        'posisi',
        'pembacaan',
    ];

    /**
     * Relasi dengan Administrasi
     */
    public function administrasi()
    {
        return $this->belongsTo(Administrasi::class);
    }
}
