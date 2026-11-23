<x-layout title="Role">
<body class="container py-4">   

  @if (session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger mt-3">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Ringkasan: siapa saja yang ada di database, per role --}}
  <div class="row g-3 mt-1">
    @foreach ($roles as $r)
      <div class="col-6 col-md-3">
        <div class="card text-center">
          <div class="card-body py-3">
            <div class="fs-3 fw-bold">{{ $r->users_count }}</div>
            <div class="text-muted">{{ $r->name }}</div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
    + Tambah User
  </button>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Telepon</th>
          <th>Jenis Kelamin</th>
          <th>Status</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone ?? '-' }}</td>
            <td>{{ $user->gender ? ucfirst($user->gender) : '-' }}</td>
            <td>{{ $user->status }}</td>
            <td>
              @forelse ($user->roles as $r)
                <span class="badge bg-primary">{{ $r->name }}</span>
              @empty
                <span class="badge bg-secondary">belum ada</span>
              @endforelse
            </td>
            <td class="d-flex gap-2">
              @if (auth()->id() != $user->getKey())
                <button type="button"
                        class="btn btn-sm btn-warning btn-edit-role"
                        data-bs-toggle="modal"
                        data-bs-target="#roleModal"
                        data-action="{{ route('role.update', $user) }}"
                        data-name="{{ $user->name }}"
                        data-email="{{ $user->email }}"
                        data-role="{{ $user->roles->first()?->name }}">
                  Ubah email/role
                </button>

                <form method="POST" action="{{ route('role.destroy', $user) }}"
                      onsubmit="return confirm('Hapus user ini?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
              @else
                <span class="text-muted">(akun kamu)</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{ $users->links() }}

  {{-- Modal tambah user --}}
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="{{ route('role.store') }}" class="modal-content">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title">Tambah User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="addName" class="form-label">Nama</label>
            <input type="text" name="name" id="addName" class="form-control" value="{{ old('name') }}" required>
          </div>
          <div class="mb-3">
            <label for="addEmail" class="form-label">Email</label>
            <input type="email" name="email" id="addEmail" class="form-control" value="{{ old('email') }}" required>
          </div>
          <div class="mb-3">
            <label for="addPhone" class="form-label">Nomor Telepon</label>
            <input type="text" name="phone" id="addPhone" class="form-control" value="{{ old('phone') }}">
          </div>
          <div class="mb-3">
            <label for="addGender" class="form-label">Jenis Kelamin</label>
            <select name="gender" id="addGender" class="form-select">
              <option value="">-</option>
              <option value="laki-laki" @selected(old('gender') === 'laki-laki')>Laki-laki</option>
              <option value="perempuan" @selected(old('gender') === 'perempuan')>Perempuan</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="addPassword" class="form-label">Password</label>
            <input type="password" name="password" id="addPassword" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="addPasswordConfirm" class="form-label">Ulangi Password</label>
            <input type="password" name="password_confirmation" id="addPasswordConfirm" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="addRole" class="form-label">Role</label>
            <select name="role" id="addRole" class="form-select" required>
              @foreach ($roles as $r)
                <option value="{{ $r->name }}" @selected(old('role') === $r->name)>{{ $r->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal ubah email & role --}}
  <div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" id="roleForm" class="modal-content">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title">Ubah: <span id="roleUserName"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="roleEmail" class="form-label">Email</label>
            <input type="email" name="email" id="roleEmail" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="roleSelect" class="form-label">Role</label>
            <select name="role" id="roleSelect" class="form-select" required>
              @foreach ($roles as $r)
                <option value="{{ $r->name }}">{{ $r->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.querySelectorAll('.btn-edit-role').forEach(function (btn) {
      btn.addEventListener('click', function () {
        document.getElementById('roleForm').action = btn.dataset.action;
        document.getElementById('roleUserName').textContent = btn.dataset.name;
        document.getElementById('roleEmail').value = btn.dataset.email;
        if (btn.dataset.role) {
          document.getElementById('roleSelect').value = btn.dataset.role;
        }
      });
    });
  </script>
</body>
</x-layout>