<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="/" class="brand-link">
      <span class="brand-text fw-light">MyAbsensi</span>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" role="menu">
        <li class="nav-item">
          <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/pengguna" class="nav-link {{ request()->is('pengguna*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-people"></i>
            <p>Pengguna</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/role" class="nav-link {{ request()->is('role*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-person-badge"></i>
            <p>Role</p>
          </a>
        <li class="nav-item">
          <a href="/produk" class="nav-link">
            <i class="nav-icon bi bi-box-seam"></i>
            <p>Produk</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/starter" class="nav-link">
            <i class="nav-icon bi bi-file-earmark"></i>
              <p>Starter Page</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>