@php
    $logo1_path = public_path('uploads/ksp.png');
    $logo1_type = pathinfo($logo1_path, PATHINFO_EXTENSION);
    $logo1_data = file_get_contents($logo1_path);
    $logo1_base64 = 'data:image/' . $logo1_type . ';base64,' . base64_encode($logo1_data);

    $logo2_path = public_path('uploads/postra.png');
    $logo2_type = pathinfo($logo2_path, PATHINFO_EXTENSION);
    $logo2_data = file_get_contents($logo2_path);
    $logo2_base64 = 'data:image/' . $logo2_type . ';base64,' . base64_encode($logo2_data);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pinjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 5px;
            box-sizing: border-box;
            font-size: 10px;
        }
        .container {
            width: 794px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 5px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }
        .header img {
            max-height: 35px;
        }
        .header .kop-surat {
            text-align: center;
            flex-grow: 1;
        }
        .header .kop-surat h4 {
            margin: 0;
            font-size: 12px;
        }
        .header .kop-surat p {
            margin: 0;
            font-size: 8px;
        }
        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            background-color: #f0f0f0;
            padding: 5px;
        }
        .section-title {
            font-weight: bold;
            margin-top: 8px;
            margin-bottom: 3px;
            border-bottom: 1px solid #eee;
            padding-bottom: 2px;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        table td {
            padding: 2px 0;
            vertical-align: top;
            font-size: 10px;
        }
        table td:first-child {
            width: 180px;
        }
        .right-align {
            text-align: right;
        }
        .footer {
            margin-top: 10px;
            text-align: right;
            font-size: 8px;
        }
        .signatures {
            display: flex;
            justify-content: space-around; /* Menggunakan space-around untuk distribusi yang lebih merata */
            align-items: flex-end; /* Menjaga semua elemen di bagian bawah (sejajar) */
            margin-top: 15px;
            text-align: center;
        }
        .signature-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Tambahkan padding-bottom untuk menaikkan teks sedikit agar sejajar dengan signature-box */
            padding-bottom: 0;
        }
        .signature-name {
            margin-top: 3px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding-bottom: 1px;
            margin-bottom: 0;
            font-size: 8px;
            line-height: 1.2; /* Menyesuaikan line-height agar tidak terlalu renggang */
        }
        @page {
            size: A4 landscape;
            margin: 3mm;
        }
        td.logo-column {
            width: 150px; /* atau sesuaikan */
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td class="logo-column" style="width: 20%; vertical-align: middle;">
                        <img src="{{ $logo1_base64 }}" alt="Logo 1" style="height: 70px; width: auto;">
                    </td>
                    <td style="width: 60%; text-align: center; vertical-align: middle;">
                        <h4 style="margin: 0; font-size: 12px;">KOPERASI SIMPAN PINJAM HIDUP BERSAMA MANDIRI</h4>
                        <p style="margin: 0; font-size: 8px;">Jin Paseh No. 223. Kel Tuguraja Kec Cihideung Kota Tasikmalaya (08112114016)</p>
                    </td>
                    <td class="logo-column" style="width: 20%; text-align: right; vertical-align: middle;">
                        <img src="{{ $logo2_base64 }}" alt="Logo 2" style="height: 70px; width: auto;">
                    </td>
                </tr>
            </table>

        </div>

        <div class="title">KWITANSI PINJAMAN ANGGOTA LAMA</div>

        <table>
            <tr>
                <td colspan="2" class="section-title">DATA CALON ANGGOTA</td>
                <td></td>
                <td colspan="2" class="section-title">PETUGAS</td>
            </tr>
            <tr>
                <td>NAMA</td>
                <td>: {{ $nama_nasabah }}</td>
                <td></td>
                <td>{{ $petugas_name }}</td>
                <td></td>
            </tr>
            <tr>
                <td>TGL LAHIR</td>
                <td>: {{ $tgl_lahir }}</td>
                <td></td>
                <td colspan="2" class="section-title">TANGGAL REALISASI</td>
            </tr>
            <tr>
                <td>USIA</td>
                <td>: {{ $usia }} TAHUN</td>
                <td></td>
                <td>{{ $tanggal_realisasi }}</td>
                <td></td>
            </tr>
            <tr>
                <td>AGUNAN</td>
                <td>: SK DI KOP POSTRA</td>
                <td></td>
                <td colspan="2" class="section-title">RINCIAN CICILAN</td>
            </tr>
            <tr>
                <td>NO PENSIUN</td>
                <td>: {{ $no_pensiun }}</td>
                <td></td>
                <td>ANGSURAN</td>
                <td>: {{ $angsuran }}</td>
            </tr>
            <tr>
                <td>JENIS PENSIUN</td>
                <td>: {{ $jenis_pensiun }}</td>
                <td></td>
                <td>SISA GAJI</td>
                <td>: {{ $sisa_gaji }}</td>
            </tr>
            <tr>
                <td>GAJI AWAL SEBELUM POT HBM</td>
                <td>: {{ $gaji_awal_sebelum_pot_hbm }}</td>
                <td></td>
                <td>TANGGAL LUNAS</td>
                <td>: {{ $tanggal_lunas }}</td>
            </tr>
            <tr>
                <td>ALAMAT</td>
                <td>: {{ $alamat }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>NO. HP</td>
                <td>: {{ $no_hp }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="2" class="section-title">RINCIAN PINJAMAN</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>PLAFOND</td>
                <td>: {{ $plafond }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>TENOR</td>
                <td>: {{ $tenor }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>PROVISI</td>
                <td>: {{ $provisi_biaya }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>SIMPANAN POKOKK</td>
                <td>: {{ $simpanan_pokok }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>DPU/ASURANSI</td>
                <td>: {{ $dpu_asuransi }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>JASA PELAYANAN</td>
                <td>: {{ $jasa_pelayanan }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>BUKU ANGGOTA</td>
                <td>: {{ $buku_anggota }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>MATERAI</td>
                <td>: {{ $materai_biaya }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>SISA HUTANG</td>
                <td>: {{ $sisa_hutang }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>PENERIMAAN BERSIH</td>
                <td style="background-color: #ffe0b2;">: {{ $penerimaan_bersih }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
             <tr>
                <td>PENGAMBILAN TABUNGAN LAMA</td>
                <td>: {{ $pengambilan_tabungan_lama }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>PENERIMAAN BERSIH + TAB</td>
                <td style="background-color: #ffe0b2;">: {{ $penerimaan_bersih_tab }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>


        <br>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 40%; text-align: center;">
                </td>
                <td style="width: 20%; text-align: center;" > </td>
                <td style="width: 40%; text-align: center;">
                    Ciamis, {{ $current_date }}
                </td>
            <tr>
                <td style="width: 40%; text-align: center; vertical-align: bottom; padding-bottom: 50px;">
                ANGGOTA<br><br><br><br>
                <span>{{ $nasabah_name }} / {{ $nik_nasabah_kwitansi }}</span>
                </td>
                <td style="width: 20%; text-align: center; vertical-align: bottom; padding-bottom: 50px;" > </td>
                <td style="width: 40%; text-align: center; vertical-align: bottom; padding-bottom: 50px;">
                PETUGAS<br><br><br><br>
                <span>{{ $petugas_name }}</span>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
