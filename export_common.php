<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/auth.php';

/**
 * Stream CSV to browser from PDOStatement rows
 */
function stream_csv($filename, $rows) {
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename=' . $filename);
  $out = fopen('php://output', 'w');
  // Header
  fputcsv($out, ['No', 'Waktu', 'NIK', 'No HP', 'Asal Instansi', 'Keperluan', 'Bertemu', 'Foto']);
  $i = 0;
  foreach ($rows as $r) {
    $i++;
    fputcsv($out, [
      $i,
      $r['created_at'],
      $r['nik'],
      $r['no_hp'],
      $r['asal_instansi'],
      str_replace(["\r","\n"], ' ', $r['keperluan']),
      $r['bertemu'],
      $r['photo_path']
    ]);
  }
  fclose($out);
}

/**
 * Stream XLSX using PhpSpreadsheet if available. If not, fallback to CSV.
 */
function stream_xlsx_or_csv($filenameBase, $rows) {
  if (class_exists('PhpOffice\\PhpSpreadsheet\\Spreadsheet')) {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    // Header
    $headers = ['No','Waktu','NIK','Asal Instansi','Keperluan','Bertemu','Foto'];
    $col = 1;
    foreach ($headers as $h) { $sheet->setCellValueByColumnAndRow($col++, 1, $h); }
    // Data
    $i = 0; $rnum = 2;
    foreach ($rows as $r) {
      $i++; $col = 1;
      $sheet->setCellValueByColumnAndRow($col++, $rnum, $i);
      $sheet->setCellValueByColumnAndRow($col++, $rnum, $r['created_at']);
      $sheet->setCellValueByColumnAndRow($col++, $rnum, $r['nik']);
      $sheet->setCellValueByColumnAndRow($col++, $rnum, $r['no_hp']);
      $sheet->setCellValueByColumnAndRow($col++, $rnum, $r['asal_instansi']);
      $sheet->setCellValueByColumnAndRow($col++, $rnum, $r['keperluan']);
      $sheet->setCellValueByColumnAndRow($col++, $rnum, $r['bertemu']);
      $sheet->setCellValueByColumnAndRow($col++, $rnum, $r['photo_path']);
      $rnum++;
    }
    // Autosize
    foreach (range('A','G') as $colID) { $sheet->getColumnDimension($colID)->setAutoSize(true); }

    // Output
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename=' . $filenameBase . '.xlsx');
    header('Cache-Control: max-age=0');
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    return;
  }
  // Fallback to CSV if library not found
  stream_csv($filenameBase . '.csv', $rows);
}
