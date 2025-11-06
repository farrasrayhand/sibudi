<?php
require __DIR__ . '/export_common.php';

$date = $_GET['date'] ?? date('Y-m-d'); // format YYYY-MM-DD
$format = strtolower($_GET['format'] ?? 'xlsx'); // xlsx|csv

// Validate date
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
  http_response_code(400);
  echo "Format tanggal tidak valid. Gunakan YYYY-MM-DD."; exit;
}

$stmt = $pdo->prepare("SELECT * FROM visitors WHERE DATE(created_at) = ? ORDER BY created_at ASC, id ASC");
$stmt->execute([$date]);
$rows = $stmt->fetchAll();

$filenameBase = 'SiBUDI_Laporan_Harian_' . $date;
if ($format === 'csv') {
  stream_csv($filenameBase . '.csv', $rows);
} else {
  stream_xlsx_or_csv($filenameBase, $rows);
}
