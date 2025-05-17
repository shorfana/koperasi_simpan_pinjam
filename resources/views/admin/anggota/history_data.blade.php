@extends('admin_template')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data History</h3>
  </div>
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Alamat</th>
          <th>Foto</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Rizky Maulana</td>
          <td>rizky@mail.com</td>
          <td>Jl. Merdeka No. 1</td>
          <td><img src="https://via.placeholder.com/50" alt="Foto" class="img-fluid rounded" style="width: 50px; height: 50px;"></td>
          <td>
            <button class="btn btn-sm btn-primary">Edit</button>
            <button class="btn btn-sm btn-danger">Hapus</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>Siti Aminah</td>
          <td>siti@mail.com</td>
          <td>Jl. Melati No. 5</td>
          <td><img src="https://via.placeholder.com/50" alt="Foto" class="img-fluid rounded" style="width: 50px; height: 50px;"></td>
          <td>
            <button class="btn btn-sm btn-primary">Edit</button>
            <button class="btn btn-sm btn-danger">Hapus</button>
          </td>
        </tr>
        <tr>
          <td>3</td>
          <td>Andi Saputra</td>
          <td>andi@mail.com</td>
          <td>Jl. Kenanga No. 8</td>
          <td><img src="https://via.placeholder.com/50" alt="Foto" class="img-fluid rounded" style="width: 50px; height: 50px;"></td>
          <td>
            <button class="btn btn-sm btn-primary">Edit</button>
            <button class="btn btn-sm btn-danger">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection