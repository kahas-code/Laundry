<nav class="sidebar sidebar-offcanvas" id="sidebar">

  <ul class="nav">

    <li class="nav-item">
      <a class="nav-link" href="/">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <?php if (session('userRole') == 1) { ?>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#data" aria-expanded="false" aria-controls="data">
          <span class="menu-title">Data</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-database menu-icon"></i>
        </a>
        <div class="collapse" id="data">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="<?= getenv('app.baseURL') ?>data/user">User</a></li>
            <li class="nav-item"> <a class="nav-link" href="<?= getenv('app.baseURL') ?>data/layanan">Layanan Laundry</a></li>
            <li class="nav-item"> <a class="nav-link" href="<?= getenv('app.baseURL') ?>data/akun">Akun</a></li>
            <li class="nav-item"> <a class="nav-link" href="<?= getenv('app.baseURL') ?>data/pelanggan">Pelanggan</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#transaksi" aria-expanded="false" aria-controls="transaksi">
          <span class="menu-title">Transaksi</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-credit-card-multiple menu-icon"></i>
        </a>
        <div class="collapse" id="transaksi">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="<?= getenv('app.baseURL') ?>transaksi/transaksi">Transaksi</a></li>
            <li class="nav-item"> <a class="nav-link" href="<?= getenv('app.baseURL') ?>pembayaran">Pembayaran</a></li>
            <li class="nav-item"> <a class="nav-link" href="<?= getenv('app.baseURL') ?>jurnal">Jurnal Umum</a></li>
          </ul>
        </div>
      </li>
    <?php } ?>


    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#laporan" aria-expanded="false" aria-controls="laporan">
        <span class="menu-title">Laporan</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-newspaper menu-icon"></i>
      </a>
      <div class="collapse" id="laporan">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?= getenv('app.baseURL') ?>laporan/transaksi">Transaksi</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= getenv('app.baseURL') ?>laporan/jurnalumum">Jurnal Umum</a></li>
        </ul>
      </div>
    </li>


  </ul>
</nav>