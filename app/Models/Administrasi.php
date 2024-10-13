<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_order',
        'nama_alat',
        'merek',
        'model_type',
        'no_seri',
        'resolusi',
        'rentang_ukur',
        'nama_instansi',
        'ruang_kalibrasi',
        'tanggal_kalibrasi',
    ];

    public function daftarAlat()
    {
        return $this->hasMany(DaftarAlat::class);
    }

    public function pengukurKondisi()
    {
        return $this->hasMany(PengukurKondisi::class);
    }

    public function pemeriksaanFungsiAlat()
    {
        return $this->hasMany(PemeriksaanFungsiAlat::class);
    }

    public function kemampuanBacaKembali()
    {
        return $this->hasMany(KemampuanBacaKembali::class);
    }  
    
    /**
    * Relasi dengan PenyimpanganNilaiNominal
    */
   public function penyimpanganNilaiNominals()
   {
       return $this->hasMany(PenyimpanganNilaiNominal::class);
   }

    /**
     * Relasi dengan PengaruhPembebananTengah
     */
    public function pengaruhPembebananTengahs()
    {
        return $this->hasMany(PengaruhPembebananTengah::class);
    }

}
