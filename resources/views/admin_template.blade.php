
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KOPERASI HANDAL </title>
  <link rel="icon" type="image/png" href="https://pasla.jambiprov.go.id/wp-content/uploads/2023/02/lambang-koperasi.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <!-- <link rel="stylesheet" href="{{asset('admin_assets/plugins/fontawesome-free/css/all.min.css')}}"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin_assets/dist/css/adminlte.min.css')}}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Halo {{ session('user')->name }}</span>
            <div class="dropdown-divider"></div>
            <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer">Logout</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <!-- <img src="{{asset('admin_assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light">KOPERASI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('admin_assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> -->

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="https://adminlte.io/docs/3.1/" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>DASHBOARD</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('users.index') }}"
            class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                <i class="nav-icon fa fa-user"></i>
                <p>MASTER USER</p>
            </a>
          </li>

          <li class="nav-item {{ request()->is('anggota-data') || request()->is('history-data') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('anggota-data') || request()->is('history-data') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                ANGGOTA
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/anggota-data" class="nav-link {{ request()->is('anggota-data') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/history-data" class="nav-link {{ request()->is('history-data') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>History</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-database"></i>
              <p>
                SIMPANAN
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/informasi-simpanan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Informasi Simpanan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/jenis-simpanan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Simpanan</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="/permohonan-penarikan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permohonan Penarikan</p>
                </a>
              </li> -->
            </ul>
          </li>
          <li class="nav-item {{ request()->is('pinjaman') || request()->is('jenis-pinjaman') || request()->is('pembayaran') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('pinjaman') || request()->is('jenis-pinjaman') || request()->is('pembayaran') ? 'active' : '' }}">
                <i class="nav-icon fas fa-credit-card"></i>
                <p>
                PINJAMAN
                <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="/pinjaman" class="nav-link {{ request()->is('pinjaman') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Informasi Pinjaman</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="/jenis-pinjaman" class="nav-link {{ request()->is('jenis-pinjaman') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Jenis Pinjaman</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="/pembayaran" class="nav-link {{ request()->is('pembayaran') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pembayaran</p>
                </a>
                </li>
            </ul>
            </li>

          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                PEMBELIAN
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Informasi Pembelian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Pembelian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembayaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Limit Pembelian</p>
                </a>
              </li>
            </ul>
          </li> -->
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-bill-wave"></i>
              <p>
                INVESTASI
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Informasi Investasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembayaran Investasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penarikan Investasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Investasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Limit Investasi</p>
                </a>
              </li>
            </ul>
          </li> -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-university"></i>
              <p>
                TABUNGAN ANGGOTA
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tabungan</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permohonan Penarikan</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kredit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembayaran Kredit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Rekening </p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Nasabah</p>
                </a>
              </li> -->
              <!-- <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Pinjaman </p>
                </a>
              </li> -->
            </ul>
          </li>
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-arrow-down"></i>
              <p>
                PEMASUKAN
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Informasi Pemasukan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori Pemasukan</p>
                </a>
              </li>
            </ul>
          </li> -->
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-wallet"></i>
              <p>
                KAS KECIL
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kas Kecil</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Saldo Kas Kecil</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Realisasi Kas Kecil</p>
                </a>
              </li>
            </ul>
          </li> -->
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-exclamation-triangle"></i>
              <p>
                JATUH TEMPO
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nasabah</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Anggota</p>
                </a>
              </li>
            </ul>
          </li> -->
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                PEMBUKUAN
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tabungan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kode Akun</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jurnal Transaksi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laba Rugi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Neraca Saldo </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SHU</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Referensi Akun </p>
                </a>
              </li>
            </ul>
          </li> -->

          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                SALDO KOPERASI
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Informasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Riwayat Pemasukan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Riwayat Pengeluaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transfer</p>
                </a>
              </li>
            </ul>
          </li> -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-import"></i>
              <p>
                IMPORT
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>BackUp Data</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                LAPORAN
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tagihan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Anggota</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Simpanan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pinjaman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembelian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemasukan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengeluaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permohonan Penarikan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembayaran Pinjaman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembayaran Pemberian</p>
                </a>
              </li>
            </ul>
          </li> -->
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                UTILITIES
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kas Bank</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori SHU</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SHU</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Periode</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Log Aplikasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengguna</p>
                </a>
              </li>
            </ul>
          </li> -->

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
          @yield('content')
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2017 - 2025 <a href="https://kostlab.id" target="blank">KostLab.id</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('admin_assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{asset('admin_assets/dist/js/adminlte.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('admin_assets/plugins/chart.js/Chart.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{asset('admin_assets/dist/js/demo.js')}}"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('admin_assets/dist/js/pages/dashboard3.js')}}"></script>

<!-- DataTables  & Plugins -->
<script src="{{asset('admin_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      "buttons": ["pdf","colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
{{-- Script untuk isi form edit --}}
<script>
    $(document).ready(function() {
        $('.btn-edit-user').on('click', function() {
            // Ambil data dari tombol edit yang di klik
            let id = $(this).data('id');
            let name = $(this).data('name');
            let email = $(this).data('email');
            let role = $(this).data('role');

            // Isi ke form modal edit
            $('#edit-id').val(id);
            $('#edit-name').val(name);
            $('#edit-email').val(email);
            $('#edit-role').val(role);

            // Password kosongkan (karena user bisa update tanpa ganti password)
            $('input[name="password"]').val('');
            $('input[name="password_confirmation"]').val('');
        });
    });
</script>
<script>
        $(document).ready(function () {
            // Auto Suggest Nasabah
            $('#nama-nasabah').on('keyup', function () {
                const keyword = $(this).val();

                if (keyword.length >= 3) {
                    $.ajax({
                        url: '/pinjaman/searchNasabah',
                        method: 'GET',
                        data: { keyword: keyword },
                        success: function (res) {
                            let html = '';
                            if (res.length > 0) {
                                res.forEach(function (item) {
                                    html += `<a href="#" class="list-group-item list-group-item-action nasabah-item"
                                                data-ktp="${item.ktp}" data-nama="${item.nama}">
                                                ${item.nama} - ${item.ktp}
                                            </a>`;
                                });
                                $('#suggestions').html(html).show();
                            } else {
                                $('#suggestions').hide();
                                resetForm();
                            }
                        }
                    });
                } else {
                    $('#suggestions').hide();
                    resetForm();
                }
            });

            // Klik salah satu item suggestion
            $(document).on('click', '.nasabah-item', function (e) {
                e.preventDefault();

                const nama = $(this).data('nama');
                const ktp = $(this).data('ktp');

                $('#nama-nasabah').val(nama);
                $('#suggestions').hide();

                // Ambil data lengkap nasabah
                $.ajax({
                    url: '/pinjaman/GetAnggotaByKtp',
                    method: 'GET',
                    data: { ktp: ktp },
                    success: function (detail) {
                        $('input[name="nik"]').val(detail.ktp).prop('readonly', true);
                        $('input[name="tgl_lahir"]').val(detail.tgl_lahir?.split('T')[0]).prop('readonly', true);
                        $('input[name="nohp"]').val(detail.nohp).prop('readonly', true);
                        $('input[name="alamat"]').val(detail.alamat).prop('readonly', true);
                        $('input[name="no_pensiun"]').val(detail.no_pensiun).prop('readonly', true);
                        $('input[name="jenis_pensiun"]').val(detail.jenis_pensiun).prop('readonly', true);

                        $('#provinsi').html(`<option value="${detail.provinsi}" selected>${detail.provinsi}</option>`);
                        $('#nama-provinsi').val(detail.provinsi);

                        // Kota
                        $('#kota').html(`<option value="${detail.kota}" selected>${detail.kota}</option>`);
                        $('#nama-kota').val(detail.kota);

                        // Kecamatan
                        $('#kecamatan').html(`<option value="${detail.kecamatan}" selected>${detail.kecamatan}</option>`);
                        $('#nama-kecamatan').val(detail.kecamatan);

                        // Kelurahan
                        $('#kelurahan').html(`<option value="${detail.kelurahan}" selected>${detail.kelurahan}</option>`);
                        $('#nama-kelurahan').val(detail.kelurahan);

                        $('#nama-provinsi').val(detail.provinsi);
                        $('#nama-kota_alamat').val(detail.kota_alamat);
                        $('#nama-kecamatan').val(detail.kecamatan);
                        $('#nama-kelurahan').val(detail.kelurahan);
                    }
                });
            });

            // Jika tidak pilih dari hasil search, form reset dan provinsi bisa diubah
            function resetForm() {
                $('input[name="nik"]').val('').prop('readonly', false);
                $('input[name="tgl_lahir"]').val('').prop('readonly', false);
                $('input[name="nohp"]').val('').prop('readonly', false);
                $('input[name="alamat"]').val('').prop('readonly', false);
                $('input[name="no_pensiun"]').val('').prop('readonly', false);
                $('input[name="jenis_pensiun"]').val('').prop('readonly', false);

                $('#provinsi').prop('disabled', false).empty().append('<option value="">-- Pilih Provinsi --</option>');
                $('#kota').prop('disabled', false).empty().append('<option value="">-- Pilih Kota --</option>');
                $('#kecamatan').prop('disabled', false).empty().append('<option value="">-- Pilih Kecamatan --</option>');
                $('#kelurahan').prop('disabled', false).empty().append('<option value="">-- Pilih Kelurahan --</option>');

                // Load provinsi ulang
                $.getJSON('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', function (data) {
                    data.forEach(prov => {
                        $('#provinsi').append(`<option value="${prov.id}">${prov.name}</option>`);
                    });
                });
            }

            // Dropdown chaining dengan .off().on() agar gak double event
                    // Saat user pilih provinsi
        $('#provinsi').off().on('change', function () {
            const provId = $(this).val();
            const provName = $(this).find('option:selected').text();
            $('#nama-provinsi').val(provName); // Ubah di sini

            $('#kota').empty().append('<option value="">-- Pilih Kota --</option>');
            $('#kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
            $('#kelurahan').empty().append('<option value="">-- Pilih Kelurahan --</option>');

            $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`, function (data) {
                data.forEach(kota => {
                    $('#kota').append(`<option value="${kota.id}">${kota.name}</option>`);
                });
            });
        });

        $('#kota').off().on('change', function () {
            const kotaId = $(this).val();
            const kotaName = $(this).find('option:selected').text();
            $('#nama-kota').val(kotaName); // Ubah di sini

            $('#kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
            $('#kelurahan').empty().append('<option value="">-- Pilih Kelurahan --</option>');

            $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kotaId}.json`, function (data) {
                data.forEach(kec => {
                    $('#kecamatan').append(`<option value="${kec.id}">${kec.name}</option>`);
                });
            });
        });

        $('#kecamatan').off().on('change', function () {
            const kecId = $(this).val();
            const kecName = $(this).find('option:selected').text();
            $('#nama-kecamatan').val(kecName); // Ubah di sini

            $('#kelurahan').empty().append('<option value="">-- Pilih Kelurahan --</option>');

            $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`, function (data) {
                data.forEach(kel => {
                    $('#kelurahan').append(`<option value="${kel.name}">${kel.name}</option>`);
                });
            });
        });

        $('#kelurahan').off().on('change', function () {
            const kelName = $(this).find('option:selected').text();
            $('#nama-kelurahan').val(kelName); // Ubah di sini
        });

            // Load provinsi pertama kali
            resetForm();
        });
    </script>
       <script>
    // Event listener untuk checkbox "Pilih Semua"
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Event listener untuk tombol Download Kwitansi (per baris)
    document.querySelectorAll('.generate-single-kwitansi').forEach(button => {
        button.addEventListener('click', function() {
            const kodePinjaman = this.dataset.kodePinjaman;
            window.location.href = `/pinjaman/kwitansi/${kodePinjaman}/pdf`; // Langsung arahkan browser ke URL download
        });
    });

    // Event listener untuk tombol Generate Kwitansi Terpilih
    document.getElementById('generateSelectedKwitansi').addEventListener('click', function() {
        const selectedKodePinjaman = [];
        document.querySelectorAll('.row-checkbox:checked').forEach(checkbox => {
            selectedKodePinjaman.push(checkbox.value);
        });

        if (selectedKodePinjaman.length === 0) {
            alert('Pilih setidaknya satu pinjaman untuk generate kwitansi.');
            return;
        }

        if (selectedKodePinjaman.length === 1) {
            // Jika hanya satu yang dipilih, panggil fungsi single generate (redirect)
            window.location.href = `/pinjaman/kwitansi/${selectedKodePinjaman[0]}/pdf`;
        } else {
            // Jika lebih dari satu, kirim kode_pinjaman ke backend untuk di-zip
            // Ini akan mengunduh file ZIP dari backend
            fetch('/pinjaman/kwitansi/multiple/pdf', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ kode_pinjaman: selectedKodePinjaman })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.message || 'Server error'); });
                }
                return response.blob(); // Menerima blob (binary data)
            })
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = `kwitansi_pinjaman_selected_${new Date().toISOString().slice(0,10)}.zip`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                alert('File zip kwitansi sedang diunduh.');
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                alert('Gagal menggenerate dan men-zip kwitansi. Silakan coba lagi. Error: ' + error.message);
            });
        }
    });

    // Event listener untuk tombol Generate Semua Kwitansi
    document.getElementById('generateAllKwitansi').addEventListener('click', function() {
        const allKodePinjaman = [];
        document.querySelectorAll('.row-checkbox').forEach(checkbox => {
            allKodePinjaman.push(checkbox.value);
        });

        if (allKodePinjaman.length === 0) {
            alert('Tidak ada pinjaman untuk generate kwitansi.');
            return;
        }

        // Kirim semua ID ke backend untuk di-zip
        fetch('/pinjaman/kwitansi/multiple/pdf', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ kode_pinjaman: allKodePinjaman })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw new Error(err.message || 'Server error'); });
            }
            return response.blob(); // Menerima blob (binary data)
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = `kwitansi_pinjaman_all_${new Date().toISOString().slice(0,10)}.zip`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            alert('File zip semua kwitansi sedang diunduh.');
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Gagal menggenerate dan men-zip semua kwitansi. Silakan coba lagi. Error: ' + error.message);
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
