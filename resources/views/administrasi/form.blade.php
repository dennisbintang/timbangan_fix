@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <h1 class="card-header text-center">LEMBAR KERJA PENGUJIAN DAN KALIBRASI TIMBANGAN BAYI MEKANIK/DIGITAL</h1>

        <div class="card-body">
            <form action="{{ isset($administrasi) ? route('administrasi.update', $administrasi) : route('administrasi.store') }}" method="POST">
                @csrf
                @if(isset($administrasi))
                    @method('PUT')
                @endif

                <!-- Form untuk administrasi -->
                <div class="form-row">
                    @foreach (['no_order', 'nama_alat', 'merek', 'model_type'] as $field)
                    <div class="form-group col-md-6">
                        <label for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $administrasi->$field ?? '') }}" required>
                    </div>
                    @endforeach
                </div>

                <div class="form-row">
                    @foreach (['no_seri', 'resolusi', 'rentang_ukur', 'nama_instansi'] as $field)
                    <div class="form-group col-md-6">
                        <label for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $administrasi->$field ?? '') }}" required>
                    </div>
                    @endforeach
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="ruang_kalibrasi">Ruang Kalibrasi</label>
                        <input type="text" class="form-control" id="ruang_kalibrasi" name="ruang_kalibrasi" value="{{ old('ruang_kalibrasi', $administrasi->ruang_kalibrasi ?? '') }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="tanggal_kalibrasi">Tanggal Kalibrasi</label>
                        <input type="date" class="form-control" id="tanggal_kalibrasi" name="tanggal_kalibrasi" value="{{ old('tanggal_kalibrasi', $administrasi->tanggal_kalibrasi ?? '') }}" required>
                    </div>
                </div>
                <hr/>
                <h5 class="mb-4 text-center">DAFTAR ALAT YANG DIGUNAKAN</h5>

                <div class="form-group">
                    <div id="daftar-alat-container">
                        @if(isset($administrasi->daftarAlat) && $administrasi->daftarAlat->count() > 0)
                            @foreach($administrasi->daftarAlat as $index => $alat)
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="daftar_alat[{{ $index }}][nama_alat]" value="{{ old('daftar_alat.'.$index.'.nama_alat', $alat->nama_alat) }}" placeholder="Nama Alat" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="daftar_alat[{{ $index }}][merek_alat]" value="{{ old('daftar_alat.'.$index.'.merek_alat', $alat->merek_alat) }}" placeholder="Merek Alat" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="daftar_alat[{{ $index }}][tipe_model]" value="{{ old('daftar_alat.'.$index.'.tipe_model', $alat->tipe_model) }}" placeholder="Tipe Model" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="daftar_alat[{{ $index }}][no_seri]" value="{{ old('daftar_alat.'.$index.'.no_seri', $alat->no_seri) }}" placeholder="No Seri" required>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="daftar_alat[0][nama_alat]" placeholder="Nama Alat" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="daftar_alat[0][merek_alat]" placeholder="Merek Alat" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="daftar_alat[0][tipe_model]" placeholder="Tipe Model" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="daftar_alat[0][no_seri]" placeholder="No Seri" required>
                            </div>
                        </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-daftar-alat">Tambah Alat</button>
                </div>

                <hr/>
                <h5 class="mb-4 text-center">PENGUKURAN KONDISI LINGKUNGAN</h5>
                <div class="form-group">
                    <div id="pengukur-kondisi-container">
                        @if(isset($administrasi) && $administrasi->pengukurKondisi->count() > 0)
                            @foreach($administrasi->pengukurKondisi as $index => $kondisi)
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="pengukur_kondisi[{{ $index }}][kondisi_ruang]" value="{{ old('pengukur_kondisi.'.$index.'.kondisi_ruang', $kondisi->kondisi_ruang) }}" placeholder="Kondisi Ruang" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" step="0.01" class="form-control" name="pengukur_kondisi[{{ $index }}][awal]" value="{{ old('pengukur_kondisi.'.$index.'.awal', $kondisi->awal) }}" placeholder="Awal" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" step="0.01" class="form-control" name="pengukur_kondisi[{{ $index }}][akhir]" value="{{ old('pengukur_kondisi.'.$index.'.akhir', $kondisi->akhir) }}" placeholder="Akhir" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="pengukur_kondisi[{{ $index }}][toleransi]" value="{{ old('pengukur_kondisi.'.$index.'.toleransi', $kondisi->toleransi) }}" placeholder="Toleransi" required>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="pengukur_kondisi[0][kondisi_ruang]" placeholder="Kondisi Ruang" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" step="0.01" class="form-control" name="pengukur_kondisi[0][awal]" placeholder="Awal" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" step="0.01" class="form-control" name="pengukur_kondisi[0][akhir]" placeholder="Akhir" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="pengukur_kondisi[0][toleransi]" placeholder="Toleransi" required>
                            </div>
                        </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-pengukur-kondisi">Tambah Pengukur Kondisi</button>
                </div>

                <hr/>
                <h5 class="mb-4 text-center">PEMERIKSAAN FISIK DAN FUNGSI ALAT</h5>
                 <div class="form-group">
                    <div id="pemeriksaan-fungsi-alat-container">
                        @if(isset($administrasi) && $administrasi->pemeriksaanFungsiAlat->count() > 0)
                            @foreach($administrasi->pemeriksaanFungsiAlat as $index => $pemeriksaan)
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="pemeriksaan_fungsi_alat[{{ $index }}][bagian_alat]" value="{{ old('pemeriksaan_fungsi_alat.'.$index.'.bagian_alat', $pemeriksaan->bagian_alat) }}" placeholder="Bagian Alat" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="pemeriksaan_fungsi_alat[{{ $index }}][fisik]" value="{{ old('pemeriksaan_fungsi_alat.'.$index.'.fisik', $pemeriksaan->fisik) }}" placeholder="Fisik" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="pemeriksaan_fungsi_alat[{{ $index }}][fungsi]" value="{{ old('pemeriksaan_fungsi_alat.'.$index.'.fungsi', $pemeriksaan->fungsi) }}" placeholder="Fungsi" required>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="pemeriksaan_fungsi_alat[0][bagian_alat]" placeholder="Bagian Alat" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="pemeriksaan_fungsi_alat[0][fisik]" placeholder="Fisik" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="pemeriksaan_fungsi_alat[0][fungsi]" placeholder="Fungsi" required>
                            </div>
                        </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-pemeriksaan-fungsi-alat">Tambah Pemeriksaan Fungsi Alat</button>
                </div>

                <hr/>
                <h5 class="mb-4 text-center">Kemampuan Baca Kembali (Repeatibility of Reading)</h5>
                <table id="kemampuan-table">
                    <thead>
                        <tr>
                            <th colspan=2>Kapasitas Mendekati Nol</th>
                            <th colspan=2>Kapasitas Setengah</th>
                            <th colspan=2>Kapasitas Penuh</th>
                            <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($administrasi) && $administrasi->kemampuanBacaKembali->count() > 0)
                        @foreach ($administrasi->kemampuanBacaKembali as $index => $kemampuan)
                            <tr>
                                <td><input placeholder="Nol (zi)" type="text" class="form-control" name="kemampuan_baca_kembali[{{ $index + 1 }}][KMN_nol]" value="{{ $kemampuan->KMN_nol }}" required></td>
                                <td><input placeholder="Pembacaan (mi)" type="text" class="form-control" name="kemampuan_baca_kembali[{{ $index + 1 }}][KMN_pembaca]" value="{{ $kemampuan->KMN_pembaca }}" required></td>
                                <td><input placeholder="Nol (zi)" type="text" class="form-control" name="kemampuan_baca_kembali[{{ $index + 1 }}][KS_nol]" value="{{ $kemampuan->KS_nol }}" required></td>
                                <td><input placeholder="Pembacaan (mi)" type="text" class="form-control" name="kemampuan_baca_kembali[{{ $index + 1 }}][KS_pembaca]" value="{{ $kemampuan->KS_pembaca }}" required></td>
                                <td><input placeholder="Nol (zi)" type="text" class="form-control" name="kemampuan_baca_kembali[{{ $index + 1 }}][KP_nol]" value="{{ $kemampuan->KP_nol }}" required></td>
                                <td><input placeholder="Pembacaan (mi)" type="text" class="form-control" name="kemampuan_baca_kembali[{{ $index + 1 }}][KP_pembaca]" value="{{ $kemampuan->KP_pembaca }}" required></td>
                                <!-- <td><button type="button" class="remove-row" onclick="removeRow(this)">Hapus</button></td> -->
                            </tr>
                        @endforeach
                    @else
                    <tr>
                                <td><input placeholder="Nol (zi)" type="text" class="form-control" name="kemampuan_baca_kembali[0][KMN_nol]" required></td>
                                <td><input placeholder="Pembacaan (mi)" type="text" class="form-control" name="kemampuan_baca_kembali[0][KMN_pembaca]" required></td>
                                <td><input placeholder="Nol (zi)" type="text" class="form-control" name="kemampuan_baca_kembali[0][KS_nol]" required></td>
                                <td><input placeholder="Pembacaan (mi)" type="text" class="form-control" name="kemampuan_baca_kembali[0][KS_pembaca]"  required></td>
                                <td><input placeholder="Nol (zi)" type="text" class="form-control" name="kemampuan_baca_kembali[0][KP_nol]"  required></td>
                                <td><input placeholder="Pembacaan (mi)" type="text" class="form-control" name="kemampuan_baca_kembali[0][KP_pembaca]" required></td>
                                <!-- <td><button type="button" class="remove-row" onclick="removeRow(this)">Hapus</button></td> -->
                            </tr>
                    @endif
                    </tbody>
                </table><br/>
                <button type="button" class="btn btn-secondary" onclick="addRow()">Tambah Kemampuan</button>
                
                <hr/>
                <h5 class="mb-4 text-center">Penyimpangan dari Nilai nominal</h5>
                
                    <div class="form-group">
                        <div id="penyimpangan-nilai-nominals-container">
                            @if(isset($administrasi) && $administrasi->penyimpanganNilaiNominals->count() > 0)
                                @foreach($administrasi->penyimpanganNilaiNominals as $index => $penyimpangan)
                                <div class="row mb-2">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="penyimpangan_nilai_nominals[{{ $index }}][nominal_mass]" value="{{ old('penyimpangan_nilai_nominals.'.$index.'.nominal_mass', $penyimpangan->nominal_mass) }}" placeholder="Nominal Mass" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="penyimpangan_nilai_nominals[{{ $index }}][z1]" value="{{ old('penyimpangan_nilai_nominals.'.$index.'.z1', $penyimpangan->z1) }}" placeholder="Z1" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="penyimpangan_nilai_nominals[{{ $index }}][m1]" value="{{ old('penyimpangan_nilai_nominals.'.$index.'.m1', $penyimpangan->m1) }}" placeholder="M1" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="penyimpangan_nilai_nominals[{{ $index }}][m1_]" value="{{ old('penyimpangan_nilai_nominals.'.$index.'.m1_', $penyimpangan->m1_) }}" placeholder="M1_" required>
                                    </div>
                                </div>
                                @endforeach
                            @else
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="penyimpangan_nilai_nominals[0][nominal_mass]" placeholder="Nominal Mass" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="penyimpangan_nilai_nominals[0][z1]" placeholder="Z1" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="penyimpangan_nilai_nominals[0][m1]" placeholder="M1" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="penyimpangan_nilai_nominals[0][m1_]" placeholder="M1_" required>
                                </div>
                            </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-secondary" id="add-penyimpangan-nilai-nominals">Tambah Penyimpangan Nilai Nominal</button>
                    </div>
                <hr/>
                <h5 class="mb-4 text-center">Pengaruh Pembebanan di Tengah</h5>
            <div class="form-group">
            <div id="pengaruh-pembebanan-tengah-container">
                @if(isset($administrasi) && $administrasi->pengaruhPembebananTengahs->count() > 0)
                    @foreach($administrasi->pengaruhPembebananTengahs as $index => $pengaruh)
                    <div class="row mb-2">
                        <input type="hidden" name="pengaruh_pembebanan_tengahs[{{ $index }}][id]" value="{{ $pengaruh->id }}">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="pengaruh_pembebanan_tengahs[{{ $index }}][posisi]" value="{{ old('pengaruh_pembebanan_tengahs.'.$index.'.posisi', $pengaruh->posisi) }}" placeholder="Posisi" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="pengaruh_pembebanan_tengahs[{{ $index }}][pembacaan]" value="{{ old('pengaruh_pembebanan_tengahs.'.$index.'.pembacaan', $pengaruh->pembacaan) }}" placeholder="Pembacaan" required>
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="row mb-2">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="pengaruh_pembebanan_tengahs[0][posisi]" placeholder="Posisi" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="pengaruh_pembebanan_tengahs[0][pembacaan]" placeholder="Pembacaan" required>
                    </div>
                </div>
                @endif
            </div>
            <button type="button" class="btn btn-secondary" id="add-pengaruh-pembebanan-tengah">Tambah Pengaruh Pembebanan Tengah</button>
        </div>
        <hr/>
                    <button type="submit" class="btn btn-success">{{ isset($administrasi) ? 'Update' : 'Simpan' }}</button>
        </form>
        </div>
    </div>
</div>

<script>
    let alatIndex = {{ isset($daftarAlats) ? $daftarAlats->count() : 1 }};
    document.getElementById('add-daftar-alat').addEventListener('click', function() {
        const container = document.getElementById('daftar-alat-container');
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-2');
        newRow.innerHTML = `
            <div class="col-md-3">
                <input type="text" class="form-control" name="daftar_alat[${alatIndex}][nama_alat]" placeholder="Nama Alat" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="daftar_alat[${alatIndex}][merek_alat]" placeholder="Merek Alat" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="daftar_alat[${alatIndex}][tipe_model]" placeholder="Tipe Model" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="daftar_alat[${alatIndex}][no_seri]" placeholder="No Seri" required>
            </div>
        `;
        container.appendChild(newRow);
        alatIndex++;
    });

    let kondisiIndex = {{ isset($administrasi) ? $administrasi->pengukurKondisi->count() : 1 }};
    document.getElementById('add-pengukur-kondisi').addEventListener('click', function() {
        const container = document.getElementById('pengukur-kondisi-container');
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-2');
        newRow.innerHTML = `
            <div class="col-md-3">
                <input type="text" class="form-control" name="pengukur_kondisi[${kondisiIndex}][kondisi_ruang]" placeholder="Kondisi Ruang" required>
            </div>
            <div class="col-md-3">
                <input type="number" step="0.01" class="form-control" name="pengukur_kondisi[${kondisiIndex}][awal]" placeholder="Awal" required>
            </div>
            <div class="col-md-3">
                <input type="number" step="0.01" class="form-control" name="pengukur_kondisi[${kondisiIndex}][akhir]" placeholder="Akhir" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="pengukur_kondisi[${kondisiIndex}][toleransi]" placeholder="Toleransi" required>
            </div>
        `;
        container.appendChild(newRow);
        kondisiIndex++;
    });

    let fungsiIndex = {{ isset($administrasi) ? $administrasi->pemeriksaanFungsiAlat->count() : 1 }};
    document.getElementById('add-pemeriksaan-fungsi-alat').addEventListener('click', function() {
        const container = document.getElementById('pemeriksaan-fungsi-alat-container');
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-2');
        newRow.innerHTML = `
            <div class="col-md-4">
                <input type="text" class="form-control" name="pemeriksaan_fungsi_alat[${fungsiIndex}][bagian_alat]" placeholder="Bagian Alat" required>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="pemeriksaan_fungsi_alat[${fungsiIndex}][fisik]" placeholder="Fisik" required>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="pemeriksaan_fungsi_alat[${fungsiIndex}][fungsi]" placeholder="Fungsi" required>
            </div>
        `;
        container.appendChild(newRow);
        fungsiIndex++;
    });

    let index = {{ isset($administrasi) ? count($administrasi->kemampuanBacaKembali) + 1 : 1 }};

        function addRow() {
            const tableBody = document.querySelector('#kemampuan-table tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input placeholder="Nol (zi)" type="text" class="form-control" name="kemampuan_baca_kembali[${index}][KMN_nol]" required></td>
                <td><input placeholder="Pembacaan (mi)" type="text" class="form-control" name="kemampuan_baca_kembali[${index}][KMN_pembaca]" required></td>
                <td><input placeholder="Nol (zi)" type="text" class="form-control" name="kemampuan_baca_kembali[${index}][KS_nol]" required></td>
                <td><input placeholder="Pembacaan (mi)" type="text" class="form-control" name="kemampuan_baca_kembali[${index}][KS_pembaca]" required></td>
                <td><input placeholder="Nol (zi)" type="text" class="form-control" name="kemampuan_baca_kembali[${index}][KP_nol]" required></td>
                <td><input placeholder="Pembacaan (mi)" type="text" class="form-control" name="kemampuan_baca_kembali[${index}][KP_pembaca]" required></td>
            `;
            tableBody.appendChild(newRow);
            index++;
        }

        // <td><button type="button" class="remove-row" onclick="removeRow(this)">Hapus</button></td>
        function removeRow(button) {
            const row = button.closest('tr');
            row.remove();
        }

        document.getElementById('add-penyimpangan-nilai-nominals').addEventListener('click', function() {
            const container = document.getElementById('penyimpangan-nilai-nominals-container');
            const index = container.children.length; // Mengetahui indeks untuk input baru

            const newRow = `
                <div class="row mb-2">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="penyimpangan_nilai_nominals[${index}][nominal_mass]" placeholder="Nominal Mass" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="penyimpangan_nilai_nominals[${index}][z1]" placeholder="Z1" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="penyimpangan_nilai_nominals[${index}][m1]" placeholder="M1" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="penyimpangan_nilai_nominals[${index}][m1_]" placeholder="M1_" required>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', newRow);
        });

        document.getElementById('add-pengaruh-pembebanan-tengah').addEventListener('click', function() {
            const container = document.getElementById('pengaruh-pembebanan-tengah-container');
            const index = container.children.length; // Mengetahui indeks untuk input baru

            const newRow = `
                <div class="row mb-2">
                    <input type="hidden" name="pengaruh_pembebanan_tengahs[${index}][id]" value="">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="pengaruh_pembebanan_tengahs[${index}][posisi]" placeholder="Posisi" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="pengaruh_pembebanan_tengahs[${index}][pembacaan]" placeholder="Pembacaan" required>
                    </div>
                </div>
            `;
            
        container.insertAdjacentHTML('beforeend', newRow);
        });
</script>
@endsection
