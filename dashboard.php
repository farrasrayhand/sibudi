
<?php require __DIR__ . '/auth.php'; require __DIR__ . '/../config.php'; ?>
<?php if (empty($_SESSION['csrf_admin'])) { $_SESSION['csrf_admin'] = bin2hex(random_bytes(32)); } ?>

<?php
// --- Filters ---
$nik = trim($_GET['nik'] ?? '');
$instansi = trim($_GET['instansi'] ?? '');
$dfrom = trim($_GET['date_from'] ?? '');
$dto = trim($_GET['date_to'] ?? '');
$per_page = max(5, min(100, (int)($_GET['per_page'] ?? 10)));
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $per_page;

// Build WHERE clause
$conds = [];
$params = [];

if ($nik !== '') { $conds[] = "nik LIKE ?"; $params[] = "%" . $nik . "%"; }
if ($instansi !== '') { $conds[] = "asal_instansi LIKE ?"; $params[] = "%" . $instansi . "%"; }
if ($dfrom !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dfrom)) { $conds[] = "DATE(created_at) >= ?"; $params[] = $dfrom; }
if ($dto !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dto)) { $conds[] = "DATE(created_at) <= ?"; $params[] = $dto; }

$where = $conds ? ("WHERE " . implode(" AND ", $conds)) : "";

// Count total
$count_sql = "SELECT COUNT(*) AS c FROM visitors {$where}";
$stc = $pdo->prepare($count_sql);
$stc->execute($params);
$total = (int)($stc->fetch()['c'] ?? 0);
$pages = max(1, (int)ceil($total / $per_page));

// Fetch page
// $list_sql = "SELECT * FROM visitors {$where} ORDER BY id DESC LIMIT ? OFFSET ?";
// $st = $pdo->prepare($list_sql);
// // bind params + limit + offset
// $bindParams = $params;
// $bindParams[] = $per_page;
// $bindParams[] = $offset;
// $st->execute($bindParams);
// $rows = $st->fetchAll();

// Fetch page
$list_sql = "SELECT * FROM visitors {$where} ORDER BY id DESC LIMIT $per_page OFFSET $offset";
$st = $pdo->prepare($list_sql);
$st->execute($params);
$rows = $st->fetchAll();

// Helper to keep query string
function qs($overrides = []) {
  $q = array_merge($_GET, $overrides);
  return '?' . http_build_query($q);
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin — SiBUDI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">SiBUDI Admin</a>
    <div class="text-white">Halo, <?= htmlspecialchars($_SESSION['admin_name']) ?> | <a class="text-white" href="logout.php">Logout</a></div>
  </div>
</nav>

<div class="container my-4">
  <!-- Filters -->
  <div class="card mb-3">
    <div class="card-body">
      <form class="row g-2 align-items-end" method="get" action="dashboard.php">
        <div class="col-md-2">
          <label class="form-label">NIK</label>
          <input type="text" name="nik" value="<?= htmlspecialchars($nik) ?>" class="form-control" placeholder="Cari NIK">
        </div>
        <div class="col-md-3">
          <label class="form-label">Instansi</label>
          <input type="text" name="instansi" value="<?= htmlspecialchars($instansi) ?>" class="form-control" placeholder="Cari instansi">
        </div>
        <div class="col-md-2">
          <label class="form-label">Dari Tanggal</label>
          <input type="date" name="date_from" value="<?= htmlspecialchars($dfrom) ?>" class="form-control">
        </div>
        <div class="col-md-2">
          <label class="form-label">Sampai</label>
          <input type="date" name="date_to" value="<?= htmlspecialchars($dto) ?>" class="form-control">
        </div>
        <div class="col-md-2">
          <label class="form-label">Per Halaman</label>
          <select name="per_page" class="form-select">
            <?php foreach ([10,20,50,100] as $opt): ?>
              <option value="<?= $opt ?>" <?= $per_page==$opt?'selected':'' ?>><?= $opt ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-1 d-grid">
          <button class="btn btn-primary">Cari</button>
        </div>
        <div class="col-md-12">
          <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Export cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Laporan Harian</h6>
          <form class="row g-2" method="get" action="export_daily.php" target="_blank">
            <div class="col-7">
              <input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="col-3">
              <select class="form-select" name="format">
                <option value="xlsx" selected>.xlsx</option>
                <option value="csv">.csv</option>
              </select>
            </div>
            <div class="col-2 d-grid">
              <button class="btn btn-success">Unduh</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Laporan Bulanan</h6>
          <form class="row g-2" method="get" action="export_monthly.php" target="_blank">
            <div class="col-5">
              <input type="number" class="form-control" name="ym" placeholder="YYYY-MM" value="<?php echo date('Y-m'); ?>">
            </div>
            <div class="col-5">
              <select class="form-select" name="format">
                <option value="xlsx" selected>.xlsx</option>
                <option value="csv">.csv</option>
              </select>
            </div>
            <div class="col-2 d-grid">
              <button class="btn btn-success">Unduh</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <h5 class="mb-3">Data Kunjungan</h5>
  <div class="text-muted mb-2">Total: <?= $total ?> data. Halaman <?= $page ?> dari <?= $pages ?>.</div>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead><tr>
        <th>#</th><th>Waktu</th><th>NIK</th><th>No HP</th><th>Asal</th><th>Keperluan</th><th>Bertemu</th><th>Foto</th><th>Aksi</th>
      </tr></thead>
      <tbody>
        <?php foreach ($rows as $i => $r): ?>
        <tr>
          <td><?= $offset + $i + 1 ?></td>
          <td><?= htmlspecialchars($r['created_at']) ?></td>
          <td><?= htmlspecialchars($r['nik']) ?></td>
          <td><?= htmlspecialchars($r['no_hp'] ?? '') ?></td>
          <td><?= htmlspecialchars($r['asal_instansi']) ?></td>
          <td><?= nl2br(htmlspecialchars($r['keperluan'])) ?></td>
          <td><?= htmlspecialchars($r['bertemu']) ?></td>
          <td><?php if ($r['photo_path']): ?>
            <a href="../<?= htmlspecialchars($r['photo_path']) ?>" target="_blank">
              <img src="../<?= htmlspecialchars($r['photo_path']) ?>" alt="foto" style="height:48px">
            </a>
          <?php else: ?>—<?php endif; ?></td>
          <td>
            <a class="btn btn-sm btn-outline-primary" href="edit_visitor.php?id=<?= (int)$r['id'] ?>">Edit</a>
            <form action="delete_visitor.php" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
              <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
              <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf_admin']) ?>">
              <button class="btn btn-sm btn-outline-danger">Hapus</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <nav aria-label="Page nav">
    <ul class="pagination">
      <li class="page-item <?= $page<=1?'disabled':'' ?>">
        <a class="page-link" href="<?= $page<=1?'#':qs(['page'=>1]) ?>">« Awal</a>
      </li>
      <li class="page-item <?= $page<=1?'disabled':'' ?>">
        <a class="page-link" href="<?= $page<=1?'#':qs(['page'=>$page-1]) ?>">‹ Prev</a>
      </li>
      <li class="page-item disabled">
        <span class="page-link">Hal <?= $page ?>/<?= $pages ?></span>
      </li>
      <li class="page-item <?= $page>=$pages?'disabled':'' ?>">
        <a class="page-link" href="<?= $page>=$pages?'#':qs(['page'=>$page+1]) ?>">Next ›</a>
      </li>
      <li class="page-item <?= $page>=$pages?'disabled':'' ?>">
        <a class="page-link" href="<?= $page>=$pages?'#':qs(['page'=>$pages]) ?>">Akhir »</a>
      </li>
    </ul>
  </nav>
</div>
</body>
</html>
