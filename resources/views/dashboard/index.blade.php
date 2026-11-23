<x-layout title="Dashboard">

  <div class="row">
    <div class="col-md-4">
      <div class="small-box text-bg-primary">
        <div class="inner">
          <h3>150</h3>
          <p>Pesanan Baru</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="small-box text-bg-success">
        <div class="inner">
          <h3>53</h3>
          <p>Pengguna Aktif</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="small-box text-bg-warning">
        <div class="inner">
          <h3>44</h3>
          <p>Produk Habis</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Penjualan Bulanan</h3>
      </div>
      <div class="card-body">
        <canvas id="chart-penjualan" height="80"></canvas>
      </div>
    </div>
  </div>
</div>
<div class="d-flex gap-2 my-3">
  @can('kelola user')
    <a href="{{ route('pengguna.index') }}" class="btn btn-warning">Kelola User</a>
  @endcan

  @can('lihat laporan')
    <a href="{{ route('laporan') }}" class="btn btn-info">Laporan</a>
  @endcan
</div>
@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"></script>
  <script>
    new Chart(document.querySelector('#chart-penjualan'), {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
        datasets: [{
          label: 'Penjualan',
          data: [65, 59, 80, 81, 56, 90],
          borderColor: '#0d6efd',
          backgroundColor: 'rgba(13, 110, 253, 0.15)',
          fill: true,
          tension: 0.3
        }]
      }
    });
  </script>
@endpush
</x-layout>