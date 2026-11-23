<x-layout title="Starter">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Title</h3>
    </div>
    <div class="card-body">
      <div class="card-body">
  <table class="table table-striped">
    <thead>
      <tr><th>No</th><th>Nama</th><th>Email</th><th>Keterangan</th></tr>
    </thead>
    <tbody>
      <tr><td>1</td><td>Budi</td><td>budi@example.com</td><td>Hadir</td></tr>
      <tr><td>2</td><td>Sari</td><td>sari@example.com</td><td>Tidak Hadir</td></tr>
    </tbody>
  </table>
</div>
    </div>
    <div class="card-footer">
      <div class="card-footer">
  <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
</div>
    </div>
  </div>
</x-layout>