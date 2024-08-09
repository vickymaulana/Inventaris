<?php
require 'vendor/autoload.php'; // Pastikan path ke autoload benar
include 'db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$ruangan_id = $_GET['ruangan_id'];
$ruangan_result = $conn->query("SELECT nama_ruangan FROM ruangan WHERE id = $ruangan_id");
$ruangan = $ruangan_result->fetch_assoc();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set judul
$sheet->setCellValue('A1', 'Daftar Barang di Ruangan ' . $ruangan['nama_ruangan']);
$sheet->mergeCells('A1:L1');

// Set header tabel
$sheet->setCellValue('A3', 'No');
$sheet->setCellValue('B3', 'Nama Barang');
$sheet->setCellValue('C3', 'Kode Barang');
$sheet->setCellValue('D3', 'Kategori');
$sheet->setCellValue('E3', 'Merk/Type');
$sheet->setCellValue('F3', 'Jumlah');
$sheet->setCellValue('G3', 'Bahan');
$sheet->setCellValue('H3', 'Tahun Pembelian');
$sheet->setCellValue('I3', 'Kondisi');
$sheet->setCellValue('J3', 'Harga');
$sheet->setCellValue('K3', 'Keterangan');

$barang_result = $conn->query("SELECT * FROM barang WHERE ruangan_id = $ruangan_id");

$no = 1;
$row = 4;
while ($barang = $barang_result->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $no++);
    $sheet->setCellValue('B' . $row, $barang['nama_barang']);
    $sheet->setCellValue('C' . $row, $barang['kode_barang']);
    $sheet->setCellValue('D' . $row, $barang['kategori']);
    $sheet->setCellValue('E' . $row, $barang['merk_type']);
    $sheet->setCellValue('F' . $row, $barang['jumlah_barang']);
    $sheet->setCellValue('G' . $row, $barang['bahan']);
    $sheet->setCellValue('H' . $row, $barang['tahun_pembelian']);
    $sheet->setCellValue('I' . $row, $barang['kondisi']);
    $sheet->setCellValue('J' . $row, $barang['harga']);
    $sheet->setCellValue('K' . $row, $barang['keterangan']);
    $row++;
}

// Set auto width pada kolom
foreach(range('A','K') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Download file
$filename = 'Daftar_Barang_Ruangan_' . $ruangan['nama_ruangan'] . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'. $filename .'"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
