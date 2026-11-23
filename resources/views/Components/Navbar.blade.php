<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">

    {{-- Kiri: tombol hamburger --}}
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i> 
        </a>
      </li>
    </ul>

    {{-- Kanan: menu profil --}}
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img src="{{ asset('assets/img/user2-160x160.jpg') }}"
               class="user-image rounded-circle shadow"
               alt="{{ auth()->user()->name }}">
          <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
        </a>

        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <li class="user-header text-bg-primary">
            <img src="{{ asset('assets/img/user2-160x160.jpg') }}"
                 class="rounded-circle shadow"
                 alt="{{ auth()->user()->name }}">
            <p>
              {{ auth()->user()->name }}
              <small>{{ auth()->user()->email }}</small>
            </p>
          </li>

          <li class="user-footer">
            <a href="#" class="btn btn-outline-secondary">Profil</a>

            <form action="{{ route('logout') }}" method="POST" class="d-inline float-end">
              @csrf
              <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
              </button>
            </form>
          </li>
        </ul>
      </li>
    </ul>

  </div>
</nav>