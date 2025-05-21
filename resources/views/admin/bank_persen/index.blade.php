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
            @if($bank_persens->isEmpty())
                <div class="mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add">
                        Tambah Bank Persen
                    </button>
                </div>
            @endif
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add">
                Tambah Bank Persen
            </button> --}}
        </div>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>DPU</th>
                    <th>Angsuran</th>
                    <th>Jasa</th>
                    <th>Provisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bank_persens as $index => $item)
                <tr>
                    <td>{{ $item->dpu }}%</td>
                    <td>{{ $item->angsuran }}%</td>
                    <td>{{ $item->jasa }}%</td>
                    <td>{{ $item->provisi }}%</td>
                    <td>
                        <button
                            class="btn btn-warning btn-sm edit-bank-persen"
                            data-id="{{ $item->id }}"
                            data-dpu="{{ $item->dpu }}"
                            data-angsuran="{{ $item->angsuran }}"
                            data-jasa="{{ $item->jasa }}"
                            data-provisi="{{ $item->provisi }}"
                            data-toggle="modal" data-target="#modal-edit-bank">
                            Edit
                        </button>
                        <form action="{{ route('bank-persen.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            {{-- <button type="submit" class="btn btn-danger btn-sm">Hapus</button> --}}
                        </form>
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
                <h4 class="modal-title">Tambah Data Bank Persen</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>DPU (%)</label>
                        <input type="number" name="dpu" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Angsuran (%)</label>
                        <input type="number" name="angsuran" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Jasa (%)</label>
                        <input type="number" name="jasa" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Provisi (%)</label>
                        <input type="number" name="provisi" class="form-control" required>
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
<div class="modal fade" id="modal-edit-bank">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('bank-persen.update') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data Bank Persen</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>DPU (%)</label>
                        <input type="number" name="dpu" id="edit-dpu" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Angsuran (%)</label>
                        <input type="number" name="angsuran" id="edit-angsuran" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Jasa (%)</label>
                        <input type="number" name="jasa" id="edit-jasa" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Provisi (%)</label>
                        <input type="number" name="provisi" id="edit-provisi" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>


@endsection

