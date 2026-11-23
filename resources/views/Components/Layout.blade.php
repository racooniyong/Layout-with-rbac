@props(['title' => 'Dashboard'])

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title }}</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">
  <div class="app-wrapper">

    <x-navbar />
    <x-sidebar />

    <main class="app-main">
      <div class="app-content-header">
        <div class="container-fluid">
          <h3 class="mb-0">{{ $title }}</h3>
          <div class="d-flex justify-content-between align-items-center">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Fixed Header</li>
                  </ol>
                </nav>
              </div>
        </div>
      </div>
      <div class="app-content">
        <div class="container-fluid">
          @auth
        @if (auth()->user()->status === 'inactive')
          <div class="alert alert-warning mb-0 rounded-0 text-center">
            <i class="bi bi-exclamation-triangle-fill"></i>
            Akun kamu sedang <strong>inactive</strong>. Hubungi admin jika ini keliru.
          </div>
          @endif
        @endauth
        {{ $slot }}
        </div>
      </div>
    </main>

    <x-footer />

  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>
@stack('scripts')
</body>
</html>