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
        <h3 class="card-title">Data Bank Persen</h3>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add">
                Tambah Bank Persen
            </button>
        </div>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Persentase DPU</th>
                    <th>Usia Masuk</th>
                    <th>Angsuran/Bulan</th>
                    <th>Penerimaan Bersih</th>
                    <th>DPU Asuransi</th>
                    <th>Jasa Pelayanan</th>
                    <th>Buku Anggota</th>
                    <th>Materai</th>
                    <th>Persen Provinsi</th>
                    <th>Provinsi</th>
                    <th>Tanggal Lunas</th>
                    <th>Tabungan Bersih</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bank_persens as $index => $item)
                    <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->persentase_dpu }}</td>
                    <td>{{ $item->usia_masuk }}</td>
                    <td>{{ $item->angsuran_per_bulan }}</td>
                    <td>{{ $item->penerimaan_bersih }}</td>
                    <td>{{ $item->dpu_asuransi }}</td>
                    <td>{{ $item->jasa_pelayanan }}</td>
                    <td>{{ $item->buku_anggota }}</td>
                    <td>{{ $item->materai }}</td>
                    <td>{{ $item->persentase_provinsi }}</td>
                    <td>{{ $item->provinsi }}</td>
                    <td>{{ $item->tanggal_lunas }}</td>
                    <td>{{ $item->penerimaan_bersih_tabungan }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit"
                        data-id="{{ $item->id }}"
                        data-persentase_dpu="{{ $item->persentase_dpu }}"
                        data-usia_masuk="{{ $item->usia_masuk }}"
                        data-angsuran_per_bulan="{{ $item->angsuran_per_bulan }}"
                        data-penerimaan_bersih="{{ $item->penerimaan_bersih }}"
                        data-dpu_asuransi="{{ $item->dpu_asuransi }}"
                        data-jasa_pelayanan="{{ $item->jasa_pelayanan }}"
                        data-buku_anggota="{{ $item->buku_anggota }}"
                        data-materai="{{ $item->materai }}"
                        data-persentase_provinsi="{{ $item->persentase_provinsi }}"
                        data-provinsi="{{ $item->provinsi }}"
                        data-tanggal_lunas="{{ $item->tanggal_lunas }}"
                        data-penerimaan_bersih_tabungan="{{ $item->penerimaan_bersih_tabungan }}"
                        >Edit</button>
                        <a href="{{ route('bank-persen.destroy', $item->id) }}" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modal-add">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('bank-persen.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">Edit Data User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Persentase DPU</label>
                        <input type="number" name="persentase_dpu" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Usia Masuk</label>
                        <input type="number" name="usia_masuk" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Angsuran per Bulan</label>
                        <input type="number" name="angsuran_per_bulan" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Penerimaan Bersih</label>
                        <input type="number" name="penerimaan_bersih" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>DPU Asuransi</label>
                        <input type="number" name="dpu_asuransi" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Jasa Pelayanan</label>
                        <input type="number" name="jasa_pelayanan" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Buku Anggota</label>
                        <input type="number" name="buku_anggota" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Materai</label>
                        <input type="number" name="materai" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Persentase Provinsi</label>
                        <input type="number" name="persentase_provinsi" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Provinsi</label>
                        <input type="number" name="provinsi" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Tanggal Lunas</label>
                        <input type="date" name="tanggal_lunas" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Penerimaan Bersih Tabungan</label>
                        <input type="number" name="penerimaan_bersih_tabungan" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>


{{-- Modal Edit --}}
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <form action="{{ route('bank-persen.update') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">Edit Data User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit-id">
                <div class="form-group">
                <label>Persentase DPU</label>
                <input type="number" name="persentase_dpu" id="edit-persentase_dpu" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Usia Masuk</label>
                <input type="number" name="usia_masuk" id="edit-usia_masuk" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Angsuran per Bulan</label>
                <input type="number" name="angsuran_per_bulan" id="edit-angsuran_per_bulan" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Penerimaan Bersih</label>
                <input type="number" name="penerimaan_bersih" id="edit-penerimaan_bersih" class="form-control" required>
                </div>
                <div class="form-group">
                <label>DPU Asuransi</label>
                <input type="number" name="dpu_asuransi" id="edit-dpu_asuransi" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Jasa Pelayanan</label>
                <input type="number" name="jasa_pelayanan" id="edit-jasa_pelayanan" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Buku Anggota</label>
                <input type="number" name="buku_anggota" id="edit-buku_anggota" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Materai</label>
                <input type="number" name="materai" id="edit-materai" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Persentase Provinsi</label>
                <input type="number" name="persentase_provinsi" id="edit-persentase_provinsi" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Provinsi</label>
                <input type="number" name="provinsi" id="edit-provinsi" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Tanggal Lunas</label>
                <input type="date" name="tanggal_lunas" id="edit-tanggal_lunas" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Penerimaan Bersih Tabungan</label>
                <input type="number" name="penerimaan_bersih_tabungan" id="edit-penerimaan_bersih_tabungan" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Delete --}}
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('bank-persen.destroy') }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" id="delete-id">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Hapus Data</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus bank <strong id="delete-nama-bank" class="text-danger"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $('.edit').on('click', function () {
        $('#edit-id').val($(this).data('id'));
        $('#edit-persentase_dpu').val($(this).data('persentase_dpu'));
        $('#edit-usia_masuk').val($(this).data('usia_masuk'));
        $('#edit-angsuran_per_bulan').val($(this).data('angsuran_per_bulan'));
        $('#edit-penerimaan_bersih').val($(this).data('penerimaan_bersih'));
        $('#edit-dpu_asuransi').val($(this).data('dpu_asuransi'));
        $('#edit-jasa_pelayanan').val($(this).data('jasa_pelayanan'));
        $('#edit-buku_anggota').val($(this).data('buku_anggota'));
        $('#edit-materai').val($(this).data('materai'));
        $('#edit-persentase_provinsi').val($(this).data('persentase_provinsi'));
        $('#edit-provinsi').val($(this).data('provinsi'));
        $('#edit-tanggal_lunas').val($(this).data('tanggal_lunas'));
        $('#edit-penerimaan_bersih_tabungan').val($(this).data('penerimaan_bersih_tabungan'));
        $('#modal-edit').modal('show');
    });

    $('.btn-delete').on('click', function () {
        $('#delete-id').val($(this).data('id'));
        $('#delete-nama-bank').text($(this).data('nama_bank'));
    });
</script>
@endpush
