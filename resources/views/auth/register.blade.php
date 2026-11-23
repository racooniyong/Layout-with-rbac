<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">
  <div class="container py-5" style="max-width: 460px;">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h1 class="text-center h4 mb-3">Buat Akun</h1>

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('register.proses') }}">
          @csrf

          <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
          </div>

          <div class="mb-3">
            <label for="phone" class="form-label">Nomor Telepon</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
          </div>

          <div class="mb-3">
            <label for="gender" class="form-label">Jenis Kelamin</label>
            <select name="gender" id="gender" class="form-select">
              <option value="">Pilih Jenis Kelamin</option>
              <option value="laki-laki" @selected(old('gender') === 'laki-laki')>Laki-laki</option>
              <option value="perempuan" @selected(old('gender') === 'perempuan')>Perempuan</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <input type="password" name="password" id="password" class="form-control" required>
              <span class="input-group-text show-password" style="cursor:pointer;">
                <i class="bi bi-lock-fill"></i>
              </span>
            </div>
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Ulangi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>

        <p class="text-center mt-3 mb-0">
          Sudah punya akun? <a href="{{ route('login') }}">Login</a>
        </p>
      </div>
    </div>
  </div>

  <script>
    document.querySelector('.show-password').addEventListener('click', function () {
      const input = document.getElementById('password');
      const icon = this.querySelector('i');
      const show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      icon.className = show ? 'bi bi-unlock-fill' : 'bi bi-lock-fill';
    });
  </script>
</body>
</html>