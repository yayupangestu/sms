<nav class="main-header navbar navbar-expand navbar-white navbar-light border-0">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link" style="color: #333; margin-right: -20px">
        <b></b>Selamat datang, {{ auth()->user()->name }} |
      </a>
    </li>

    <!-- Comment Notification Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link position-relative" data-toggle="dropdown" href="#" title="Komentar / Feedback">
        <i style="font-size: 25px; color:rgb(0, 0, 0)" class="far fa-comments"></i>
        <span class="badge badge-info navbar-badge" style="position: absolute; top: -5px; right: -5px; font-size: 14px; padding: 4px 6px;">3</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">3 Notifikasi Baru</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item d-flex align-items-center">
          <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar" width="25" height="25" class="rounded-circle mr-2">
          <div>
            B3.1 Tidak bisa scan IN
            <div class="text-muted text-sm">2 menit lalu</div>
          </div>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item d-flex align-items-center">
          <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar" width="25" height="25" class="rounded-circle mr-2">
          <div>
            B3.1 Tidak bisa scan IN
            <div class="text-muted text-sm">2 menit lalu</div>
          </div>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item d-flex align-items-center">
          <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar" width="25" height="25" class="rounded-circle mr-2">
          <div>
            B3.1 Tidak bisa scan IN
            <div class="text-muted text-sm">2 menit lalu</div>
          </div>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
      </div>
    </li>
    <!-- User Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar" width="30">
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="#" onclick="Logout();" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
        </a>
      </div>
    </li>
  </ul>
</nav>
