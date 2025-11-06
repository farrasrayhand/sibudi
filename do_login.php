<?php
session_start();
require __DIR__ . '/../config.php';

$user = trim($_POST['username'] ?? '');
$pass = $_POST['password'] ?? '';

if ($user === '' || $pass === '') {
  header('Location: login.php?error=Isi username dan password'); exit;
}

$stmt = $pdo->prepare('SELECT id, password_hash FROM admin_users WHERE username = ? LIMIT 1');
$stmt->execute([$user]);
$row = $stmt->fetch();

if (!$row || !password_verify($pass, $row['password_hash'])) {
  header('Location: login.php?error=Username atau password salah'); exit;
}

$_SESSION['admin_id'] = (int)$row['id'];
$_SESSION['admin_name'] = $user;

header('Location: dashboard.php');
