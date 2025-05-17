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
{{-- <div style="text-align: left; padding: 10px;">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
        Tambah Pinjaman
    </button>
</div> --}}

{{-- <div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Pinjaman</h3>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>NAMA PETUGAS</th>
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
                        <td>{{ $item->createdby ?? '-' }}</td>
                        <td>{{ $item->nama ?? '-' }}</td>
                        <td>{{ $item->ktp ?? '-' }}</td>
                        <td>{{ $item->kota ?? '-' }}</td>
                        <td>{{ $item->kecamatan ?? '-' }}</td>
                        <td>{{ $item->no_pensiun ?? '-' }}</td>
                        <td>
                            {{ $item->nominal_pinjaman ? 'Rp ' . number_format($item->nominal_pinjaman, 0, ',', '.') : '-' }}
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
                        <td>
                            <button class="btn btn-sm btn-primary">Edit</button>
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div> --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Pinjaman</h3>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
                Tambah Pinjaman
            </button>
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
                        <td>
                            <button class="btn btn-sm btn-primary generate-single-kwitansi" data-kode-pinjaman="{{ $item->kode_pinjaman }}">Kwitansi</button>
                            <button class="btn btn-sm btn-info">Edit</button>
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </td>
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



@endsection
