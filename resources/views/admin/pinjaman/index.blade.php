@extends('admin_template')
@section('content')
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 2500,
        showConfirmButton: false
    });
</script>
@endif
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Pinjaman</h3>
    </div>
    <div class="card-body">
        <div class="mb-3">

            @if(session('user')->role != 'PETUGAS_BANK')
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
                Tambah Pinjaman
            </button> -->
            
            <div id="customAddBtnWrapper" style="display: none;">
            <button class="btn btn-primary" id="btnTambah" data-toggle="modal" data-target="#modal-tambah">Tambah</button>
            </div>
            @endif
            <button class="btn btn-success" id="generateSelectedKwitansi">Generate Kwitansi Terpilih</button>
            <button class="btn btn-info" id="generateAllKwitansi">Generate Semua Kwitansi</button>
        </div>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th> {{-- Checkbox untuk pilih semua --}}
                    <th>NAMA PETUGAS </th>
                    <th>NAMA NASABAH</th>
                    <th>NIK</th>
                    <th>KOTA</th>
                    <th>KECAMATAN</th>
                    <th>NO PENSIUN</th>
                    <th>PLAFOND (BESAR PINJAMAN)</th>
                    <th>TANGGAL JATUH TEMPO</th>
                    <th>TANGGAL DIBUAT</th>
                    <th>DIBUAT OLEH</th>
                    <th>TANGGAL DIUBAH</th>
                    <th>DIUBAH OLEH</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pinjaman as $item)
                    <tr>
                        <td><input type="checkbox" class="row-checkbox" value="{{ $item->kode_pinjaman }}"></td> {{-- Value dari kode_pinjaman --}}
                        <td>{{ $item->createdby ?? '-' }}</td>
                        <td>{{ $item->nama_nasabah }}</td> {{-- Menggunakan accessor --}}
                        <td>{{ $item->nik_nasabah  }}</td> {{-- Menggunakan accessor --}}
                        <td>{{ $item->kota_nasabah }}</td> {{-- Menggunakan accessor --}}
                        <td>{{ $item->kecamatan_nasabah }}</td> {{-- Menggunakan accessor --}}
                        <td>{{ $item->no_pensiun_nasabah }}</td> {{-- Menggunakan accessor --}}
                        <td>
                            {{ $item->nominal_pinjaman ? 'Rp ' . number_format($item->nominal_pinjaman, 0, ',', '.') : '-' }}{{-- Menggunakan accessor --}}
                        </td>
                        <td>
                            {{ $item->tgl_jatuh_tempo ? \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d-m-Y') : '-' }}
                        </td>
                        <td>
                            {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') : '-' }}
                        </td>
                        <td>{{ $item->createdby ?? '-' }}</td>
                        <td>
                            {{ $item->modifiedon ? \Carbon\Carbon::parse($item->modifiedon)->format('d-m-Y') : '-' }}
                        </td>
                        <td>{{ $item->modifiedby ?? '-' }}</td>
                        @if(session('user')->role != 'PETUGAS_BANK')
                        <td>
                            <button class="btn btn-sm btn-primary generate-single-kwitansi" data-kode-pinjaman="{{ $item->kode_pinjaman }}">Kwitansi</button>
                            <button class="btn btn-sm btn-info btn-edit-pinjaman" data-no-anggota="{{ $item->no_anggota }}" data-toggle="modal" data-target="#modal-edit">Edit</button>
                            <!-- <button class="btn btn-sm btn-danger delete-pinjaman" data-kode-pinjaman="{{ $item->kode_pinjaman }}">Hapus</button> -->
                             <a href="{{ route('pinjaman.delete', $item->kode_pinjaman) }}"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                             </a>
                        </td>
                        @else
                        <td>
                            <button class="btn btn-sm btn-primary generate-single-kwitansi-bank" data-kode-pinjaman="{{ $item->kode_pinjaman }}">Kwitansi</button>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah Pinjaman --}}
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('pinjaman.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Pinjaman</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        {{-- Kolom 1 --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Petugas</label>
                                <input name="nama_petugas" value="{{ session('user')->name }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama Nasabah</label>
                                <input name="nama_nasabah" id="nama-nasabah" class="form-control" autocomplete="off">
                                <div id="suggestions" class="list-group position-absolute w-100 zindex-tooltip"></div>
                            </div>
                            <div class="form-group">
                                <label>NIK</label>
                                <input name="nik" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>No Handphone</label>
                                <input name="nohp" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input name="alamat" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Simpanan Pokok</label>
                                <input name="simpanan_pokok" class="form-control">
                            </div>
                        </div>

                        {{-- Kolom 2 --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Provinsi</label>
                                <select id="provinsi" class="form-control"></select>
                                <input type="hidden" name="provinsi" id="nama-provinsi">
                            </div>
                            <div class="form-group">
                                <label>Kota</label>
                                <select id="kota" class="form-control"></select>
                                <input type="hidden" name="kota" id="nama-kota">
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <select id="kecamatan" class="form-control"></select>
                                <input type="hidden" name="kecamatan" id="nama-kecamatan">
                            </div>
                            <div class="form-group">
                                <label>Kelurahan</label>
                                <select id="kelurahan" class="form-control"></select>
                                <input type="hidden" name="kelurahan" id="nama-kelurahan">
                            </div>
                            <div class="form-group">
                                <label>Jaminan</label>
                                <input name="jaminan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>No Pensiun</label>
                                <input name="no_pensiun" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Jenis Pensiun</label>
                                <input name="jenis_pensiun" class="form-control">
                            </div>
                        </div>

                        {{-- Kolom 3 --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Gaji Awal (Sebelum Potong HBM)</label>
                                <input type="number" name="gaji_awal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Plafond (Besar Pinjaman)</label>
                                <input name="nominal_pinjaman" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Lama Pinjaman</label>
                                <input name="lama_pinjaman" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Realisasi</label>
                                <input type="date" name="tgl_realisasi" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Pengambilan Tabungan</label>
                                <input name="pengambilan_tabungan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Sisa Hutang</label>
                                <input name="sisa_hutang" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input name="keterangan" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal edit -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT') {{-- Gunakan method PUT untuk update --}}
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Pinjaman</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    {{-- Input hidden untuk menyimpan kode_pinjaman yang akan diupdate --}}
                    <input type="hidden" name="kode_pinjaman" id="edit-kode-pinjaman">
                    <div class="row">
                        {{-- Kolom 1 (Data Anggota - Readonly) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Petugas</label>
                                <input name="nama_petugas" id="edit-nama-petugas" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama Nasabah</label>
                                <input name="nama_nasabah" id="edit-nama-nasabah" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>NIK</label>
                                <input name="nik" id="edit-nik" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="text" name="tgl_lahir" id="edit-tgl-lahir" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>No Handphone</label>
                                <input name="nohp" id="edit-nohp" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input name="alamat" id="edit-alamat" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Simpanan Pokok</label>
                                <input name="simpanan_pokok" id="edit-simpanan-pokok" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>No Anggota</label>
                                <input name="no_anggota" id="edit-no-anggota" class="form-control" readonly>
                            </div>
                        </div>

                        {{-- Kolom 2 (Data Anggota - Readonly & Pinjaman - Jaminan/Pensiun) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Provinsi</label>
                                <input type="text" id="edit-provinsi-text" class="form-control" readonly>
                                <input type="hidden" name="provinsi" id="edit-nama-provinsi">
                            </div>
                            <div class="form-group">
                                <label>Kota</label>
                                <input type="text" id="edit-kota-text" class="form-control" readonly>
                                <input type="hidden" name="kota" id="edit-nama-kota">
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <input type="text" id="edit-kecamatan-text" class="form-control" readonly>
                                <input type="hidden" name="kecamatan" id="edit-nama-kecamatan">
                            </div>
                            <div class="form-group">
                                <label>Kelurahan</label>
                                <input type="text" id="edit-kelurahan-text" class="form-control" readonly>
                                <input type="hidden" name="kelurahan" id="edit-nama-kelurahan">
                            </div>
                            <div class="form-group">
                                <label>Jaminan</label>
                                <input name="jaminan" id="edit-jaminan" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>No Pensiun</label>
                                <input name="no_pensiun" id="edit-no-pensiun" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Jenis Pensiun</label>
                                <input name="jenis_pensiun" id="edit-jenis-pensiun" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>NIP Anggota</label>
                                <input name="nip_anggota" id="edit-nip-anggota" class="form-control" readonly>
                            </div>
                        </div>

                        {{-- Kolom 3 (Data Pinjaman - Editable) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Gaji Awal (Dari Anggota)</label>
                                <input type="text" id="edit-gaji-awal-anggota" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Plafond (Besar Pinjaman)</label>
                                <input name="nominal_pinjaman" id="edit-nominal-pinjaman" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Lama Pinjaman (Bulan)</label>
                                <input name="lama_pinjaman" id="edit-lama-pinjaman" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Realisasi</label>
                                <input type="date" name="tgl_realisasi" id="edit-tgl-realisasi" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Pengambilan Tabungan</label>
                                <input name="pengambilan_tabungan" id="edit-pengambilan-tabungan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Sisa Hutang</label>
                                <input name="sisa_hutang" id="edit-sisa-hutang" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input name="keterangan" id="edit-keterangan" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
