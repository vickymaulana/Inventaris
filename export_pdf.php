<?php
require 'fpdf/fpdf.php';
include 'db.php';

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Perpustakaan Lampung - Inventaris Ruangan', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function FancyTable($header, $data)
    {
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');

        $w = array(10, 60, 30, 50, 30);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();

        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['id'], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row['nama_barang'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['jumlah_barang'], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row['nama_ruangan'], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, $row['nomor_lantai'], 'LR', 0, 'C', $fill);
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

    function AddRoomTable($roomName, $header, $data)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 8, $roomName, 0, 1, 'L');
        $this->Ln(2);

        $this->FancyTable($header, $data);
        $this->Ln(10);
    }
}

$query = "
    SELECT b.id, b.nama_barang, b.jumlah_barang, r.nama_ruangan, l.nomor_lantai 
    FROM barang b 
    LEFT JOIN ruangan r ON b.ruangan_id = r.id 
    LEFT JOIN lantai l ON b.lantai_id = l.id
    ORDER BY l.nomor_lantai, r.nama_ruangan
";

$result = $conn->query($query);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[$row['nomor_lantai']][$row['nama_ruangan']][] = $row;
}

$pdf = new PDF();
$header = array('ID', 'Nama Barang', 'Jumlah', 'Ruangan', 'Lantai');
$pdf->SetFont('Arial', '', 12);
$pdf->AddPage();

foreach ($data as $lantai => $rooms) {
    $pdf->ChapterTitle('Lantai ' . $lantai);
    foreach ($rooms as $roomName => $items) {
        $pdf->AddRoomTable($roomName, $header, $items);
    }
}

$pdf->Output('D', 'inventaris_ruangan.pdf');
?>
