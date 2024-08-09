<?php
require 'vendor/autoload.php'; // Pastikan path ke autoload benar
include 'db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set judul
$sheet->setCellValue('A1', 'Daftar Inventaris Per Lantai');
$sheet->mergeCells('A1:L1');

// Set header tabel
$sheet->setCellValue('A3', 'No');
$sheet->setCellValue('B3', 'Lantai');
$sheet->setCellValue('C3', 'Ruangan');
$sheet->setCellValue('D3', 'Nama Barang');
$sheet->setCellValue('E3', 'Kode Barang');
$sheet->setCellValue('F3', 'Kategori');
$sheet->setCellValue('G3', 'Merk/Type');
$sheet->setCellValue('H3', 'Jumlah');
$sheet->setCellValue('I3', 'Bahan');
$sheet->setCellValue('J3', 'Tahun Pembelian');
$sheet->setCellValue('K3', 'Kondisi');
$sheet->setCellValue('L3', 'Harga');
$sheet->setCellValue('M3', 'Keterangan');

$query = "
    SELECT l.nomor_lantai, r.nama_ruangan, b.nama_barang, b.kode_barang, b.kategori, b.merk_type, b.jumlah_barang, b.bahan, b.tahun_pembelian, b.kondisi, b.harga, b.keterangan 
    FROM barang b 
    LEFT JOIN ruangan r ON b.ruangan_id = r.id 
    LEFT JOIN lantai l ON r.lantai_id = l.id 
    ORDER BY l.nomor_lantai, r.nama_ruangan, b.nama_barang
";

$result = $conn->query($query);
$no = 1;
$row = 4;

while ($data = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $no++);
    $sheet->setCellValue('B' . $row, 'Lantai ' . $data['nomor_lantai']);
    $sheet->setCellValue('C' . $row, $data['nama_ruangan']);
    $sheet->setCellValue('D' . $row, $data['nama_barang']);
    $sheet->setCellValue('E' . $row, $data['kode_barang']);
    $sheet->setCellValue('F' . $row, $data['kategori']);
    $sheet->setCellValue('G' . $row, $data['merk_type']);
    $sheet->setCellValue('H' . $row, $data['jumlah_barang']);
    $sheet->setCellValue('I' . $row, $data['bahan']);
    $sheet->setCellValue('J' . $row, $data['tahun_pembelian']);
    $sheet->setCellValue('K' . $row, $data['kondisi']);
    $sheet->setCellValue('L' . $row, $data['harga']);
    $sheet->setCellValue('M' . $row, $data['keterangan']);
    $row++;
}

// Set auto width pada kolom
foreach(range('A','M') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Download file
$filename = 'Inventaris_Per_Lantai.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'. $filename .'"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
