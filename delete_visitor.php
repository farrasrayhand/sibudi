<?php
require __DIR__ . '/auth.php';
require __DIR__ . '/../config.php';

$id = (int)($_POST['id'] ?? 0);
$csrf = $_POST['csrf'] ?? '';
if (!hash_equals($_SESSION['csrf_admin'] ?? '', $csrf)) {
  header('Location: dashboard.php?error=CSRF tidak valid'); exit;
}
if ($id <= 0) {
  header('Location: dashboard.php?error=ID tidak valid'); exit;
}

// Optional: remove photo file from disk
$st = $pdo->prepare("SELECT photo_path FROM visitors WHERE id=?");
$st->execute([$id]);
$old = $st->fetch();
if ($old && !empty($old['photo_path'])) {
  $f = realpath(__DIR__ . '/../' . $old['photo_path']);
  if ($f && str_starts_with($f, realpath(__DIR__ . '/..'))) {
    @unlink($f);
  }
}
// Delete DB row
$stmt = $pdo->prepare("DELETE FROM visitors WHERE id=?");
$stmt->execute([$id]);

header('Location: dashboard.php?success=deleted');
