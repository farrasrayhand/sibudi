<?php
require __DIR__ . '/export_common.php';

$ym = $_GET['ym'] ?? date('Y-m'); // format YYYY-MM
$format = strtolower($_GET['format'] ?? 'xlsx'); // xlsx|csv

// Validate YYYY-MM
if (!preg_match('/^\d{4}-\d{2}$/', $ym)) {
  http_response_code(400);
  echo "Format bulan tidak valid. Gunakan YYYY-MM."; exit;
}

list($y,$m) = explode('-', $ym);
$stmt = $pdo->prepare("SELECT * FROM visitors WHERE YEAR(created_at)=? AND MONTH(created_at)=? ORDER BY created_at ASC, id ASC");
$stmt->execute([$y, $m]);
$rows = $stmt->fetchAll();

$filenameBase = 'SiBUDI_Laporan_Bulanan_' . $ym;
if ($format === 'csv') {
  stream_csv($filenameBase . '.csv', $rows);
} else {
  stream_xlsx_or_csv($filenameBase, $rows);
}
