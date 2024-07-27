<?php
require 'vendor/autoload.php';
include 'db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nama Barang');
$sheet->setCellValue('C1', 'Jumlah Barang');
$sheet->setCellValue('D1', 'Ruangan');
$sheet->setCellValue('E1', 'Lantai');

$query = "
    SELECT b.id, b.nama_barang, b.jumlah_barang, r.nama_ruangan, l.nomor_lantai 
    FROM barang b 
    LEFT JOIN ruangan r ON b.ruangan_id = r.id 
    LEFT JOIN lantai l ON b.lantai_id = l.id
";

$result = $conn->query($query);

$rowNumber = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowNumber, $row['id']);
    $sheet->setCellValue('B' . $rowNumber, $row['nama_barang']);
    $sheet->setCellValue('C' . $rowNumber, $row['jumlah_barang']);
    $sheet->setCellValue('D' . $rowNumber, $row['nama_ruangan']);
    $sheet->setCellValue('E' . $rowNumber, $row['nomor_lantai']);
    $rowNumber++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'inventaris_ruangan.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>
