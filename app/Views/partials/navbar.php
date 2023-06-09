<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="<?= getenv('app.baseURL') ?>"><img src="<?= getenv('app.baseURL') ?>assets/images/icon.jpg" alt="logo" style="max-width: fit-content;" /></a>
    <a class="navbar-brand brand-logo-mini" href="<?= getenv('app.baseURL') ?>"><img src="<?= getenv('app.baseURL') ?>assets/images/icon.jpg" alt="logo" style="max-width: fit-content;" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>

    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-img">
            <img src="<?= getenv('app.baseURL') ?>assets/images/faces/face1.jpg" alt="image">
            <span class="availability-status online"></span>
          </div>
          <div class="nav-profile-text">
            <p class="mb-1 text-black"><?= ucwords(session('userName')) ?></p>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/logout">
            <i class="mdi mdi-logout me-2 text-primary"></i> Logout </a>
        </div>
      </li>

    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>