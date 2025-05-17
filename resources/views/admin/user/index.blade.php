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

<div style="text-align: left; padding: 10px;">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add">
        Tambah Users
    </button>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Users</h3>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-edit-user"
                                data-toggle="modal"
                                data-target="#modal-edit"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ $user->role }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        |
                        <button class="btn btn-sm btn-danger btn-delete-user"
                                data-toggle="modal"
                                data-target="#modal-delete"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah User --}}
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <form action="{{ route('users.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input name="email" class="form-control" type="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input name="password" class="form-control" type="password" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" name="role" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit User --}}
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <form action="{{ route('users.update') }}" method="POST" class="modal-content">
            @csrf
            {{-- Hidden input untuk user id --}}
            <input type="hidden" name="id" id="edit-id" value="">

            <div class="modal-header">
                <h4 class="modal-title">Edit Data User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input id="edit-name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input id="edit-email" name="email" type="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password (kosongkan jika tidak ingin diubah)</label>
                    <input name="password" type="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select id="edit-role" class="form-control" name="role" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Hapus User --}}
{{-- <div class="modal fade" id="modal-delete">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('users.destroy') }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus User</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="delete-id">
                <p>
                    Apakah Anda yakin ingin menghapus user <strong id="delete-name" class="text-danger"></strong>?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div> --}}
@endsection

@push('scripts')
<script>
    // Populate edit modal
    $('.btn-edit-user').on('click', function () {
        $('#edit-id').val($(this).data('id'));
        $('#edit-name').val($(this).data('name'));
        $('#edit-email').val($(this).data('email'));
        $('#edit-role').val($(this).data('role'));
    });

    // Populate delete modal
    $('.btn-delete-user').on('click', function () {
        $('#delete-id').val($(this).data('id'));
        $('#delete-name').text($(this).data('name'));
    });
</script>
@endpush
