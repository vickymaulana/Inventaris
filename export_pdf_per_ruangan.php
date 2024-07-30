<?php
require 'fpdf/fpdf.php';
include 'db.php';

class PDF extends FPDF
{
    function Header()
    {
        global $nama_ruangan;
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'DAFTAR INVENTARIS RUANGAN', 0, 1, 'C');
        $this->Cell(0, 10, 'DINAS PERPUSTAKAAN DAN ARSIP PROVINSI LAMPUNG', 0, 1, 'C');
        $this->Cell(0, 10, '2024', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }

    function FancyTable($header, $data)
    {
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B', 10);

        // Adjust column widths
        $w = array(10, 45, 25, 25, 35, 15, 25, 20, 30, 20, 35); // Adjusted widths

        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();

        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('', '', 10);

        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['no'], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row['nama_barang'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['kode_barang'], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row['kategori'], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, $row['merk_type'], 'LR', 0, 'L', $fill);
            $this->Cell($w[5], 6, $row['jumlah_barang'], 'LR', 0, 'C', $fill);
            $this->Cell($w[6], 6, $row['bahan'], 'LR', 0, 'L', $fill);
            $this->Cell($w[7], 6, $row['tahun_pembelian'], 'LR', 0, 'C', $fill);
            $this->Cell($w[8], 6, $row['kondisi'], 'LR', 0, 'L', $fill);
            $this->Cell($w[9], 6, $row['harga'], 'LR', 0, 'R', $fill);
            $this->Cell($w[10], 6, $row['keterangan'], 'LR', 0, 'L', $fill); // Removed WrapText function
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    function ChapterTitle($label)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, $label, 0, 1, 'L');
        $this->Ln(4);
    }

    function AddRoomTable($header, $data)
    {
        $this->FancyTable($header, $data);
        $this->Ln(10);
    }
}

$ruangan_id = $_GET['ruangan_id'];
$ruangan_result = $conn->query("SELECT nama_ruangan FROM ruangan WHERE id = $ruangan_id");
$ruangan = $ruangan_result->fetch_assoc();
$nama_ruangan = $ruangan['nama_ruangan'];

$query = "
    SELECT b.id, b.nama_barang, b.kode_barang, b.kategori, b.merk_type, b.jumlah_barang, b.bahan, b.tahun_pembelian, b.kondisi, b.harga, b.keterangan 
    FROM barang b 
    WHERE b.ruangan_id = $ruangan_id
    ORDER BY b.nama_barang
";

$result = $conn->query($query);
$data = [];
$no = 1;
while ($row = $result->fetch_assoc()) {
    $row['no'] = $no++;
    $data[] = $row;
}

$pdf = new PDF('L', 'mm', 'A4');
$header = array('No', 'Nama Barang', 'Kode', 'Kategori', 'Merk/Type', 'Jumlah', 'Bahan', 'Tahun', 'Kondisi', 'Harga', 'Keterangan');
$pdf->SetFont('Arial', '', 12);
$pdf->AddPage();
$pdf->ChapterTitle('Ruangan: ' . $nama_ruangan);
$pdf->AddRoomTable($header, $data);

$pdf->Output('D', 'inventaris_ruangan_' . $ruangan_id . '.pdf');
?>
