<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KemampuanBacaKembali extends Model
{
    use HasFactory;

    protected $fillable = [
        'administrasi_id',
        'KMN_nol',
        'KMN_pembaca',
        'KS_nol',
        'KS_pembaca',
        'KP_nol',
        'KP_pembaca'
    ];

    public function administrasi()
    {
        return $this->belongsTo(Administrasi::class);
    }
}
