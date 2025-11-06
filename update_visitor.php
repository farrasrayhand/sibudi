<?php
require __DIR__ . '/auth.php';
require __DIR__ . '/../config.php';

$id = (int)($_POST['id'] ?? 0);
$csrf = $_POST['csrf'] ?? '';
if (!hash_equals($_SESSION['csrf_admin'] ?? '', $csrf)) {
  header('Location: dashboard.php?error=CSRF tidak valid'); exit;
}

$nik = trim($_POST['nik'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$asal = trim($_POST['asal_instansi'] ?? '');
$kep = trim($_POST['keperluan'] ?? '');
$ber = trim($_POST['bertemu'] ?? '');

if ($id <= 0 || $nik === '' || $asal === '' || $kep === '' || $ber === '') {
  header('Location: dashboard.php?error=Data tidak lengkap'); exit;
}

if (!preg_match('/^\d{8,16}$/', $nik)) {
  header('Location: dashboard.php?error=NIK tidak valid'); exit;
}

$stmt = $pdo->prepare("UPDATE visitors SET nik=?, no_hp=?, asal_instansi=?, keperluan=?, bertemu=? WHERE id=?");
$stmt->execute([$nik, $no_hp, $asal, $kep, $ber, $id]);

header('Location: dashboard.php?success=updated');
