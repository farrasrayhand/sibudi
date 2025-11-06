<?php
session_start();
if (!empty($_SESSION['admin_id'])) { header('Location: dashboard.php'); exit; }
$err = $_GET['error'] ?? '';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Admin — SiBUDI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container" style="max-width:420px;">
    <div class="card shadow-sm mt-5">
      <div class="card-header bg-white"><h5 class="mb-0">Login Admin</h5></div>
      <div class="card-body">
        <?php if ($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
        <form action="do_login.php" method="post" class="vstack gap-3">
          <div>
            <label class="form-label">Username</label>
            <input name="username" class="form-control" required>
          </div>
          <div>
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control" required>
          </div>
          <button class="btn btn-primary w-100">Masuk</button>
        </form>
      </div>
      <div class="card-footer small text-muted bg-white">© <?= date('Y') ?> SiBUDI</div>
    </div>
  </div>
</body>
</html>
