<?php
require __DIR__ . '/auth.php';
require __DIR__ . '/../config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM visitors WHERE id=? LIMIT 1");
$stmt->execute([$id]);
$row = $stmt->fetch();
if (!$row) { http_response_code(404); echo "Data tidak ditemukan."; exit; }

if (empty($_SESSION['csrf_admin'])) { $_SESSION['csrf_admin'] = bin2hex(random_bytes(32)); }
$csrf = $_SESSION['csrf_admin'];
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Kunjungan — SiBUDI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">SiBUDI Admin</a>
    <div class="text-white">Edit Data</div>
  </div>
</nav>

<div class="container my-4" style="max-width: 840px;">
  <div class="card">
    <div class="card-header bg-white"><strong>Edit Data Kunjungan</strong></div>
    <div class="card-body">
      <form action="update_visitor.php" method="post" class="row g-3">
        <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
        <div class="col-md-6">
          <label class="form-label">NIK</label>
          <input class="form-control" name="nik" value="<?= htmlspecialchars($row['nik']) ?>" required maxlength="32">
        </div>
        <div class="col-md-6">
          <label class="form-label">No. Handphone</label>
          <input class="form-control" name="no_hp" value="<?= htmlspecialchars($row['no_hp'] ?? '') ?>" maxlength="32">
        </div>
        <div class="col-md-6">
          <label class="form-label">Asal Instansi</label>
          <input class="form-control" name="asal_instansi" value="<?= htmlspecialchars($row['asal_instansi']) ?>" required maxlength="128">
        </div>
        <div class="col-md-6">
          <label class="form-label">Ingin Bertemu</label>
          <input class="form-control" name="bertemu" value="<?= htmlspecialchars($row['bertemu']) ?>" required maxlength="128">
        </div>
        <div class="col-12">
          <label class="form-label">Keperluan</label>
          <textarea class="form-control" name="keperluan" rows="3" required><?= htmlspecialchars($row['keperluan']) ?></textarea>
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
          <a class="btn btn-secondary" href="dashboard.php">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
