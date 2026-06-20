<h2 class="h4 fw-bold mb-4"><i class="bi bi-bar-chart-line me-2"></i>Site Reports</h2>

<!-- Summary Stat Cards -->
<div class="row g-4 mb-5">
  <div class="col-md-3"><div class="admin-stat-card"><div class="admin-stat-icon text-primary"><i class="bi bi-car-front-fill"></i></div><div class="admin-stat-num"><?= number_format($statsData['total_vehicles']) ?></div><div class="admin-stat-label">Total Vehicles</div></div></div>
  <div class="col-md-3"><div class="admin-stat-card"><div class="admin-stat-icon text-info"><i class="bi bi-tools"></i></div><div class="admin-stat-num"><?= number_format($statsData['total_parts']) ?></div><div class="admin-stat-label">Total Parts</div></div></div>
  <div class="col-md-3"><div class="admin-stat-card"><div class="admin-stat-icon text-success"><i class="bi bi-wrench-adjustable"></i></div><div class="admin-stat-num"><?= number_format($statsData['total_providers']) ?></div><div class="admin-stat-label">Service Providers</div></div></div>
  <div class="col-md-3"><div class="admin-stat-card"><div class="admin-stat-icon text-warning"><i class="bi bi-people-fill"></i></div><div class="admin-stat-num"><?= number_format($statsData['total_users']) ?></div><div class="admin-stat-label">Registered Users</div></div></div>
</div>

<div class="row g-4 mb-5">
  <!-- Listings Trend Chart -->
  <div class="col-lg-8">
    <div class="dash-card">
      <h5 class="dash-card-title"><i class="bi bi-graph-up me-2"></i>New Listings — Last 30 Days</h5>
      <canvas id="trendChart" height="120"></canvas>
    </div>
  </div>
  <!-- Status Breakdown -->
  <div class="col-lg-4">
    <div class="dash-card">
      <h5 class="dash-card-title"><i class="bi bi-pie-chart me-2"></i>Approval Status</h5>
      <canvas id="statusChart" height="200"></canvas>
    </div>
  </div>
</div>

<!-- Listings by District -->
<div class="dash-card">
  <h5 class="dash-card-title"><i class="bi bi-geo-alt me-2"></i>Listings by District</h5>
  <div class="table-responsive">
    <table class="table table-sm align-middle mb-0">
      <thead class="table-light"><tr><th>District</th><th>Vehicles</th><th>Parts</th><th>Total</th></tr></thead>
      <tbody>
        <?php foreach ($byDistrict as $row): ?>
          <tr>
            <td><?= e($row['district']) ?></td>
            <td><?= number_format($row['vehicle_count']) ?></td>
            <td><?= number_format($row['part_count']) ?></td>
            <td class="fw-semibold"><?= number_format($row['vehicle_count']+$row['part_count']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
const trendLabels = <?= json_encode(array_column($trend, 'day')) ?>;
const trendVehicles = <?= json_encode(array_column($trend, 'vehicles')) ?>;
const trendParts = <?= json_encode(array_column($trend, 'parts')) ?>;

new Chart(document.getElementById('trendChart'), {
  type: 'line',
  data: {
    labels: trendLabels,
    datasets: [
      { label: 'Vehicles', data: trendVehicles, borderColor: '#2563eb', backgroundColor: 'rgba(37,99,235,0.08)', tension: 0.4, fill: true },
      { label: 'Parts',    data: trendParts,    borderColor: '#0891b2', backgroundColor: 'rgba(8,145,178,0.08)',  tension: 0.4, fill: true },
    ]
  },
  options: { responsive: true, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true } } }
});

new Chart(document.getElementById('statusChart'), {
  type: 'doughnut',
  data: {
    labels: ['Approved', 'Pending', 'Rejected'],
    datasets: [{ data: [<?= $statsData['approved_vehicles'] ?>, <?= $statsData['pending_vehicles'] ?>, <?= $statsData['rejected_vehicles'] ?>], backgroundColor: ['#16a34a','#f59e0b','#dc2626'] }]
  },
  options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
</script>
