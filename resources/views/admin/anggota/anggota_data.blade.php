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
    <h3 class="card-title">Data Pengguna</h3>
  </div>
  <div class="card-body">
        <div class="mb-3">
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add">
                Tambah Anggota
            </button> -->
            
            <div id="customAddBtnWrapper" style="display: none;">
            <button class="btn btn-primary" id="btnTambah" data-toggle="modal" data-target="#modal-add">Tambah</button>
            </div>
        </div>
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Alamat</th>
          {{-- <th>Foto</th> --}}
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($anggota as $index => $a)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $a->nama }}</td>
          <td>{{ $a->email ?? '-' }}</td>
          <td>{{ $a->alamat ?? '-' }}</td>
          {{-- <td>
            @if($a->foto)
              @foreach (explode(',', $a->foto) as $img)
                <img src="{{ asset('storage/foto_anggota/' . trim($img)) }}" alt="Foto" class="img-fluid rounded mb-1" style="width: 50px; height: 50px;">
              @endforeach
            @else
              <span class="text-muted">Tidak ada</span>
            @endif
          </td> --}}
          <td>
            <a href="#" class="btn btn-sm btn-warning btn-edit" data-id="{{ $a->no_anggota }}"><i class="fas fa-edit"></i></a>|
            <a href="{{ route('anggota-delete.delete', $a->no_anggota) }}"
                    class="btn btn-sm btn-danger"
                    onclick="return confirm('Are you sure you want to delete this user?')">
                        <i class="fas fa-trash"></i>
                  </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="modal-add">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Anggota</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom 1 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>NIP</label>
                                <input name="nip" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>KTP</label>
                                <input name="ktp" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" class="form-control" type="email" />
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input name="nama" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input name="tgl_lahir" class="form-control" type="date" />
                            </div>
                            <div class="form-group">
                                <label>No HP</label>
                                <input name="no_hp" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Tanggal Aktivasi</label>
                                <input name="tgl_aktivasi" class="form-control" type="date" />
                            </div>
                            <div class="form-group">
                                <label>Gaji</label>
                                <input name="gaji" class="form-control" />
                            </div>
                        </div>

                        <!-- Kolom 2 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal Keluar</label>
                                <input name="tgl_keluar" class="form-control" type="date" />
                            </div>
                            <div class="form-group">
                                <label>Simpanan Wajib</label>
                                <input name="simpanan_wajib" class="form-control" type="number" step="0.01" />
                            </div>
                            <div class="form-group">
                                <label>Provinsi</label>
                                <select id="provinsi_agt" class="form-control"></select>
                                <input type="hidden" name="provinsi" id="nama-provinsi_agt" />
                            </div>
                            <div class="form-group">
                                <label>Kota</label>
                                <select id="kota_agt" class="form-control"></select>
                                <input type="hidden" name="kota_alamat" id="nama-kota_agt" />
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <select id="kecamatan_agt" class="form-control"></select>
                                <input type="hidden" name="kecamatan" id="nama-kecamatan_agt" />
                            </div>
                            <div class="form-group">
                                <label>Kelurahan</label>
                                <select id="kelurahan_agt" class="form-control"></select>
                                <input type="hidden" name="kelurahan" id="nama-kelurahan_agt" />
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input name="alamat" class="form-control" />
                            </div>
                        </div>

                        <!-- Kolom 3 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>No Rekening</label>
                                <input name="rekening" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Foto (maksimal 1MB per gambar)</label>
                                <input name="foto[]" class="form-control" type="file" multiple accept="image/*" id="fotoFiles" />
                                <small id="fileError" class="text-danger" style="display: none;">Ukuran file terlalu besar. Maksimal 1MB per gambar.</small>
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <input name="type" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <input name="status" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Nomor Pensiun</label>
                                <input name="no_pensiun" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Jenis Pensiun</label>
                                <input name="jenis_pensiun" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Simpanan Pokok</label>
                                <input name="jenis_pensiun" class="form-control" />
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

<!-- Modal Edit -->
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-edit" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- karena update -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Anggota</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-id" />

          <div class="row">
            <!-- Kolom 1 -->
            <div class="col-md-4">
              <div class="form-group">
                <label>NIP</label>
                <input name="nip" id="edit-nip" class="form-control" />
              </div>
              <div class="form-group">
                <label>KTP</label>
                <input name="ktp" id="edit-ktp" class="form-control" />
              </div>
              <div class="form-group">
                <label>Email</label>
                <input name="email" id="edit-email" class="form-control" type="email" />
              </div>
              <div class="form-group">
                <label>Nama</label>
                <input name="nama" id="edit-nama" class="form-control" required />
              </div>
              <div class="form-group">
                <label>Tanggal Lahir</label>
                <input name="tgl_lahir" id="edit-tgl_lahir" class="form-control" type="date" />
              </div>
              <div class="form-group">
                <label>No HP</label>
                <input name="nohp" id="edit-no_hp" class="form-control" />
              </div>
              <div class="form-group">
                <label>Tanggal Aktivasi</label>
                <input name="tgl_aktivasi" id="edit-tgl_aktivasi" class="form-control" type="date" />
              </div>
            </div>

            <!-- Kolom 2 -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Tanggal Keluar</label>
                <input name="tgl_keluar" id="edit-tgl_keluar" class="form-control" type="date" />
              </div>
              <div class="form-group">
                <label>Simpanan Wajib</label>
                <input name="simpanan_wajib" id="edit-simpanan_wajib" class="form-control" type="number" step="0.01" />
              </div>
              <div class="form-group">
                <label>Provinsi</label>
                <select id="edit-provinsi_agt" class="form-control"></select>
                <input type="hidden" name="provinsi" id="edit-nama-provinsi_agt" />
              </div>
              <div class="form-group">
                <label>Kota</label>
                <select id="edit-kota_agt" class="form-control"></select>
                <input type="hidden" name="kota" id="edit-nama-kota_agt" />
              </div>
              <div class="form-group">
                <label>Kecamatan</label>
                <select id="edit-kecamatan_agt" class="form-control"></select>
                <input type="hidden" name="kecamatan" id="edit-nama-kecamatan_agt" />
              </div>
              <div class="form-group">
                <label>Kelurahan</label>
                <select id="edit-kelurahan_agt" class="form-control"></select>
                <input type="hidden" name="kelurahan" id="edit-nama-kelurahan_agt" />
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <input name="alamat" id="edit-alamat" class="form-control" />
              </div>
            </div>

            <!-- Kolom 3 -->
            <div class="col-md-4">
              <div class="form-group">
                <label>No Rekening</label>
                <input name="rekening" id="edit-rekening" class="form-control" />
              </div>
              <div class="form-group">
                <label>Foto (maksimal 1MB per gambar)</label>
                <input name="foto[]" id="edit-foto" class="form-control" type="file" multiple accept="image/*" />
                <small id="fileErrorEdit" class="text-danger" style="display: none;">Ukuran file terlalu besar. Maksimal 1MB per gambar.</small>
              </div>
              <div class="form-group">
                <label>Type</label>
                <input name="type" id="edit-type" class="form-control" />
              </div>
              <div class="form-group">
                <label>Status</label>
                <input name="status" id="edit-status" class="form-control" />
              </div>
              <div class="form-group">
                <label>Nomor Pensiun</label>
                <input name="no_pensiun" id="edit-no_pensiun" class="form-control" />
              </div>
              <div class="form-group">
                <label>Jenis Pensiun</label>
                <input name="jenis_pensiun" id="edit-jenis_pensiun" class="form-control" />
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
    document.getElementById('fotoFiles').addEventListener('change', function () {
        const files = this.files;
        let errorShown = false;
        for (let i = 0; i < files.length; i++) {
            if (files[i].size > 1048576) {
                document.getElementById('fileError').style.display = 'block';
                this.value = '';
                errorShown = true;
                break;
            }
        }
        if (!errorShown) {
            document.getElementById('fileError').style.display = 'none';
        }
    });

    function formatDateToInput(dateStr) {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    if (isNaN(date)) return '';
    return date.toISOString().split('T')[0]; // Format: yyyy-mm-dd
    }
</script>
<script>
  // Fungsi bantu cari ID dari nama wilayah dalam data list
function cariIdDariNama(data, nama) {
  if (!nama) return null;
  const lowerNama = nama.toLowerCase();
  const item = data.find(d => d.name.toLowerCase() === lowerNama);
  return item ? item.id : null;
}

// Fungsi load Provinsi, Kota, Kecamatan, Kelurahan untuk modal edit berdasarkan NAMA wilayah
async function loadWilayahEdit(provName, kotaName, kecName, kelName) {
  const provinsi = document.getElementById('edit-provinsi_agt');
  const kota = document.getElementById('edit-kota_agt');
  const kecamatan = document.getElementById('edit-kecamatan_agt');
  const kelurahan = document.getElementById('edit-kelurahan_agt');

  const namaProvinsi = document.getElementById('edit-nama-provinsi_agt');
  const namaKota = document.getElementById('edit-nama-kota_agt');
  const namaKecamatan = document.getElementById('edit-nama-kecamatan_agt');
  const namaKelurahan = document.getElementById('edit-nama-kelurahan_agt');

  try {
    // Load semua provinsi
    const resProv = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
    const dataProv = await resProv.json();

    // Isi dropdown provinsi
    provinsi.innerHTML = `<option value="">-- Pilih Provinsi --</option>`;
    dataProv.forEach(item => {
      provinsi.innerHTML += `<option value="${item.id}">${item.name}</option>`;
    });

    // Cari ID provinsi dari nama
    const provId = cariIdDariNama(dataProv, provName);
    if (provId) {
      provinsi.value = provId;
      namaProvinsi.value = provinsi.options[provinsi.selectedIndex].text;

      // Load kota berdasarkan provId
      const resKota = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`);
      const dataKota = await resKota.json();

      kota.innerHTML = `<option value="">-- Pilih Kota/Kabupaten --</option>`;
      dataKota.forEach(item => {
        kota.innerHTML += `<option value="${item.id}">${item.name}</option>`;
      });

      // Cari ID kota dari nama
      const kotaId = cariIdDariNama(dataKota, kotaName);
      if (kotaId) {
        kota.value = kotaId;
        namaKota.value = kota.options[kota.selectedIndex].text;

        // Load kecamatan berdasarkan kotaId
        const resKec = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kotaId}.json`);
        const dataKec = await resKec.json();

        kecamatan.innerHTML = `<option value="">-- Pilih Kecamatan --</option>`;
        dataKec.forEach(item => {
          kecamatan.innerHTML += `<option value="${item.id}">${item.name}</option>`;
        });

        // Cari ID kecamatan dari nama
        const kecId = cariIdDariNama(dataKec, kecName);
        if (kecId) {
          kecamatan.value = kecId;
          namaKecamatan.value = kecamatan.options[kecamatan.selectedIndex].text;

          // Load kelurahan berdasarkan kecId
          const resKel = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`);
          const dataKel = await resKel.json();

          kelurahan.innerHTML = `<option value="">-- Pilih Kelurahan --</option>`;
          dataKel.forEach(item => {
            kelurahan.innerHTML += `<option value="${item.id}">${item.name}</option>`;
          });

          // Cari ID kelurahan dari nama
          const kelId = cariIdDariNama(dataKel, kelName);
          if (kelId) {
            kelurahan.value = kelId;
            namaKelurahan.value = kelurahan.options[kelurahan.selectedIndex].text;
          }
        }
      }
    }
  } catch (err) {
    console.error("Gagal load wilayah:", err);
  }
}



  // Event klik tombol Edit
  document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function () {
      const id = this.dataset.id;
      console.log(id);
      console.log("ini dia");

      // Panggil API untuk dapat data detail
      fetch(`/anggota/${id}/edit`) // sesuaikan route dengan backend kamu
        .then(res => res.json())
        .then(data => {
          // Isi form edit dengan data yang didapat
          document.getElementById('edit-id').value = data.no_anggota;
          document.getElementById('edit-nip').value = data.nip || '';
          document.getElementById('edit-ktp').value = data.ktp || '';
          document.getElementById('edit-email').value = data.email || '';
          document.getElementById('edit-nama').value = data.nama || '';
          document.getElementById('edit-tgl_lahir').value = formatDateToInput(data.tgl_lahir);
          document.getElementById('edit-no_hp').value = data.nohp || '';
          document.getElementById('edit-tgl_aktivasi').value = formatDateToInput(data.tgl_aktivasi);
          document.getElementById('edit-tgl_keluar').value = formatDateToInput(data.tgl_keluar);
          document.getElementById('edit-simpanan_wajib').value = data.simpanan_wajib || '';
          document.getElementById('edit-alamat').value = data.alamat || '';
          document.getElementById('edit-rekening').value = data.rekening || '';
          document.getElementById('edit-type').value = data.type || '';
          document.getElementById('edit-status').value = data.status || '';
          document.getElementById('edit-no_pensiun').value = data.no_pensiun || '';
          document.getElementById('edit-jenis_pensiun').value = data.jenis_pensiun || '';

          // Load dropdown wilayah dengan data id-nya
          loadWilayahEdit(
            data.provinsi,
            data.kota,
            data.kecamatan,
            data.kelurahan
          );

          // Tampilkan modal edit
          $('#modal-edit').modal('show');
        })
        .catch(err => {
          alert('Gagal mengambil data, coba lagi.');
          console.error(err);
        });
    });
  });

  document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function () {
      const id = this.dataset.id;
      console.log(id);
      console.log("ini dia");

      // Konfirmasi sebelum menghapus (opsional tapi sangat disarankan)
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            // Panggil API Laravel Anda
            // Perhatikan URL-nya: '/api/data/${id}'
            console.log("kehapus nih");
            fetch(`/anggota-delete/${id}`)
                .then(response => {
                    if (!response.ok) throw new Error('Gagal menghapus data.');
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                    location.reload(); // reload halaman setelah sukses
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                    alert('Gagal menghapus data.');
                });

        }
    });
  });

  // Submit form edit
  document.getElementById('form-edit').addEventListener('submit', function(e) {
    e.preventDefault();

    // Validasi ukuran file foto sebelum submit
    const files = document.getElementById('edit-foto').files;
    let valid = true;
    for(let i=0; i < files.length; i++) {
      if(files[i].size > 1024 * 1024) {
        valid = false;
        break;
      }
    }
    if(!valid) {
      document.getElementById('fileErrorEdit').style.display = 'block';
      return;
    } else {
      document.getElementById('fileErrorEdit').style.display = 'none';
    }

    const formData = new FormData(this);
    const id = document.getElementById('edit-id').value;

    fetch(`/anggota/${id}`, {
      method: 'POST', // Kalau pake PUT di server, sesuaikan
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': '{{ csrf_token() }}' // sesuaikan kalau pake Laravel
      }
    })
    .then(res => res.json())
    .then(data => {
      if(data.success) {
        // alert('Data berhasil diupdate');
        Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: data.success,
        timer: 2500,
        showConfirmButton: false
    });
        $('#modal-edit').modal('hide');
        location.reload(); // reload halaman supaya update kelihatan
      } else {
        alert('Gagal update: ' + (data.message || 'Error'));
      }
    })
    .catch(err => {
      alert('Gagal update data.');
      console.error(err);
    });
  });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const provinsi = document.getElementById('provinsi_agt');
        const kota = document.getElementById('kota_agt');
        const kecamatan = document.getElementById('kecamatan_agt');
        const kelurahan = document.getElementById('kelurahan_agt');

        const namaProvinsi = document.getElementById('nama-provinsi_agt');
        const namaKota = document.getElementById('nama-kota_agt');
        const namaKecamatan = document.getElementById('nama-kecamatan_agt');
        const namaKelurahan = document.getElementById('nama-kelurahan_agt');

         // Load Provinsi
         fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
             .then(res => res.json())
             .then(data => {
                 provinsi.innerHTML = `<option value="">-- Pilih Provinsi --</option>`;
                 data.forEach(item => {
                     provinsi.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                 });
             });

         provinsi.addEventListener('change', function () {
             const provId = this.value;
             namaProvinsi.value = this.options[this.selectedIndex].text;
             kota.innerHTML = `<option value="">-- Pilih Kota/Kabupaten --</option>`;
             kecamatan.innerHTML = `<option value="">-- Pilih Kecamatan --</option>`;
             kelurahan.innerHTML = `<option value="">-- Pilih Kelurahan --</option>`;
             namaKota.value = "";
             namaKecamatan.value = "";
             namaKelurahan.value = "";

             if (provId) {
                 fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`)
                     .then(res => res.json())
                     .then(data => {
                         data.forEach(item => {
                             kota.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                         });
                     });
             }
         });

         kota.addEventListener('change', function () {
             const kotaId = this.value;
             namaKota.value = this.options[this.selectedIndex].text;
             kecamatan.innerHTML = `<option value="">-- Pilih Kecamatan --</option>`;
             kelurahan.innerHTML = `<option value="">-- Pilih Kelurahan --</option>`;
             namaKecamatan.value = "";
             namaKelurahan.value = "";

             if (kotaId) {
                 fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kotaId}.json`)
                     .then(res => res.json())
                     .then(data => {
                         data.forEach(item => {
                             kecamatan.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                         });
                     });
             }
         });

         kecamatan.addEventListener('change', function () {
             const kecId = this.value;
             namaKecamatan.value = this.options[this.selectedIndex].text;
             kelurahan.innerHTML = `<option value="">-- Pilih Kelurahan --</option>`;
             namaKelurahan.value = "";

             if (kecId) {
                 fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`)
                     .then(res => res.json())
                     .then(data => {
                         data.forEach(item => {
                             kelurahan.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                         });
                     });
             }
         });

         kelurahan.addEventListener('change', function () {
             namaKelurahan.value = this.options[this.selectedIndex].text;
         });
     });
</script>
@endsection
