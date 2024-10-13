<?php
namespace App\Http\Controllers;

use App\Models\Administrasi;
use App\Models\DaftarAlat;
use App\Models\PemeriksaanFungsiAlat;
use App\Models\PengukurKondisi;
use App\Models\PenyimpanganNilaiNominal;
use App\Models\PengaruhPembebananTengah;
use App\Models\KemampuanBacaKembali;
use Illuminate\Http\Request;

class AdministrasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Administrasi::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('no_order', 'LIKE', "%{$search}%")
                  ->orWhere('nama_instansi', 'LIKE', "%{$search}%");
        }
    
        // Gunakan paginate dan atur jumlah item per halaman
        $administrasis = $query->paginate(20); 
        return view('administrasi.index', compact('administrasis'));
    }

    public function create()
    {
        return view('administrasi.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'no_order' => 'required|string',
            'nama_alat' => 'required|string',
            'merek' => 'required|string',
            'model_type' => 'required|string',
            'no_seri' => 'required|string',
            'resolusi' => 'required|string',
            'rentang_ukur' => 'required|string',
            'nama_instansi' => 'required|string',
            'ruang_kalibrasi' => 'required|string',
            'tanggal_kalibrasi' => 'required|date',
        ]);

        // Simpan data administrasi
        $administrasi = Administrasi::create($validatedData);

        // Simpan daftar alat
        if ($request->has('daftar_alat')) {
            foreach ($request->daftar_alat as $alat) {
                $alat['administrasi_id'] = $administrasi->id;
                DaftarAlat::create($alat);
            }
        }

        // Simpan pengukur kondisi
        if ($request->has('pengukur_kondisi')) {
            foreach ($request->pengukur_kondisi as $kondisi) {
                $kondisi['administrasi_id'] = $administrasi->id;
                PengukurKondisi::create($kondisi);
            }
        }

           // Simpan pemeriksaan fungsi alat
        if ($request->has('pemeriksaan_fungsi_alat')) {
            foreach ($request->pemeriksaan_fungsi_alat as $fungsi) {
                $fungsi['administrasi_id'] = $administrasi->id;
                PemeriksaanFungsiAlat::create($fungsi);
            }
        }

            // Simpan pemeriksaan fungsi alat
        if ($request->has('penyimpangan_nilai_nominals')) {
            foreach ($request->penyimpangan_nilai_nominals as $nominal) {
                $nominal['administrasi_id'] = $administrasi->id;
                PenyimpanganNilaiNominal::create($nominal);
            }
        }

            // Simpan pemeriksaan fungsi alat
        if ($request->has('pengaruh_pembebanan_tengahs')) {
            foreach ($request->pengaruh_pembebanan_tengahs as $tengah) {
                $tengah['administrasi_id'] = $administrasi->id;
                pengaruhPembebananTengah::create($tengah);
            }
        }

        return redirect()->route('administrasi.index')->with('success', 'Data berhasil disimpan!');

    }

    public function show(Administrasi $administrasi)
    {
        return view('administrasi.show', compact('administrasi'));
    }

    public function edit($id)
    {
        // Mengambil data administrasi berdasarkan ID
        $administrasi = Administrasi::with(['daftarAlat', 'pengukurKondisi', 'pemeriksaanFungsiAlat', 'penyimpanganNilaiNominals'])->findOrFail($id);
        return view('administrasi.edit', compact('administrasi'));
    }

    public function update(Request $request, Administrasi $administrasi)
    {
        // echo "<pre>";
        // print_r($request);
        // echo "</pre>";
        // die();
           // Validasi input
        $validatedData = $request->validate([
            'no_order' => 'required|string',
            'nama_alat' => 'required|string',
            'merek' => 'required|string',
            'model_type' => 'required|string',
            'no_seri' => 'required|string',
            'resolusi' => 'required|string',
            'rentang_ukur' => 'required|string',
            'nama_instansi' => 'required|string',
            'ruang_kalibrasi' => 'required|string',
            'tanggal_kalibrasi' => 'required|date',
        ]);

        // Update data administrasi
        $administrasi->update($validatedData);
        //echo $administrasi;

        // Update daftar alat
        if ($request->has('daftar_alat')) {
            // Hapus data lama
            $administrasi->daftarAlat()->delete();
            
            // Tambahkan yang baru
            foreach ($request->daftar_alat as $alat) {
                $alat['administrasi_id'] = $administrasi->id;
                DaftarAlat::create($alat);
            }
        }

        // Update pengukur kondisi
        if ($request->has('pengukur_kondisi')) {
            // Hapus data lama
            $administrasi->pengukurKondisi()->delete();
            
            // Tambahkan yang baru
            foreach ($request->pengukur_kondisi as $kondisi) {
                $kondisi['administrasi_id'] = $administrasi->id;
                PengukurKondisi::create($kondisi);
            }
        }

        if ($request->has('pemeriksaan_fungsi_alat')) {
            // Hapus data lama
            $administrasi->pemeriksaanFungsiAlat()->delete();
            
            // Tambahkan yang baru
            foreach ($request->pemeriksaan_fungsi_alat as $fungsi) {
                $fungsi['administrasi_id'] = $administrasi->id;
                PemeriksaanFungsiAlat::create($fungsi);
            }
        }

        foreach ($request->kemampuan_baca_kembali as $key => $data) {
            
            $administrasi->kemampuanBacaKembali()->delete();
            foreach ($request->kemampuan_baca_kembali as $kembali) {
                $kembali['administrasi_id'] = $administrasi->id;
                KemampuanBacaKembali::create($kembali);
            }
            
        }

        foreach ($request->penyimpangan_nilai_nominals as $key => $data) {
            
            $administrasi->PenyimpanganNilaiNominals()->delete();
            foreach ($request->penyimpangan_nilai_nominals as $nominal) {
                $nominal['administrasi_id'] = $administrasi->id;
                PenyimpanganNilaiNominal::create($nominal);
            }
            
        }

        foreach ($request->pengaruh_pembebanan_tengahs as $key => $data) {
            
            $administrasi->pengaruhPembebananTengahs()->delete();
            foreach ($request->pengaruh_pembebanan_tengahs as $tengah) {
                $tengah['administrasi_id'] = $administrasi->id;
                pengaruhPembebananTengah::create($tengah);
            }
            
        }

        return redirect()->route('administrasi.index')->with('success', 'Data berhasil diupdate!');

    }

    public function destroy(Administrasi $administrasi)
    {
        $administrasi->delete();
        return redirect()->route('administrasi.index')->with('success', 'Data berhasil dihapus.');
    }
}
