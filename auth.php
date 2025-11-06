<?php
session_start();
if (empty($_SESSION['admin_id'])) {
  header('Location: login.php?error=Silakan login terlebih dahulu'); exit;
}
