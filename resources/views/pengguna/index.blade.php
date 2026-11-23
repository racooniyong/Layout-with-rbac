<x-layout title="Pengguna">
<body class="container py-4">
  
  @if (session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
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

  <div class="table-responsive">
    <table class="table table-striped mt-3 align-middle">
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
            <td>
              <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                {{ $user->status }}
              </span>
            </td>
            <td>
              @foreach ($user->roles as $r)
                <span class="badge bg-primary">{{ $r->name }}</span>
              @endforeach
            </td>
            <td>
              @if (! $user->hasRole('super admin') || auth()->user()->hasRole('super admin'))
                <button type="button"
                        class="btn btn-sm btn-warning btn-edit"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal"
                        data-action="{{ route('users.update', $user) }}"
                        data-name="{{ $user->name }}"
                        data-status="{{ $user->status }}"
                        data-phone="{{ $user->phone }}"
                        data-gender="{{ $user->gender }}">
                  Edit
                </button>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{ $users->links() }}

  {{-- Modal edit (nama, status, telepon, jenis kelamin) --}}
  <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" id="editForm" class="modal-content">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title">Edit Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="editName" class="form-label">Nama</label>
            <input type="text" name="name" id="editName" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="editStatus" class="form-label">Status</label>
            <select name="status" id="editStatus" class="form-select" required>
              <option value="active">active</option>
              <option value="inactive">inactive</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="editPhone" class="form-label">Nomor Telepon</label>
            <input type="text" name="phone" id="editPhone" class="form-control">
          </div>

          <div class="mb-3">
            <label for="editGender" class="form-label">Jenis Kelamin</label>
            <select name="gender" id="editGender" class="form-select">
              <option value="">-</option>
              <option value="laki-laki">Laki-laki</option>
              <option value="perempuan">Perempuan</option>
            </select>
          </div>

          <p class="text-muted small mb-0">Email dan role hanya bisa diubah oleh super admin di halaman Role.</p>
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
    document.querySelectorAll('.btn-edit').forEach(function (btn) {
      btn.addEventListener('click', function () {
        document.getElementById('editForm').action = btn.dataset.action;
        document.getElementById('editName').value = btn.dataset.name;
        document.getElementById('editStatus').value = btn.dataset.status;
        document.getElementById('editPhone').value = btn.dataset.phone;
        document.getElementById('editGender').value = btn.dataset.gender;
      });
    });
  </script>
</body>
</html>
</x-layout>