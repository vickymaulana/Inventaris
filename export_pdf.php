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
        $this->SetFont('', 'B', 10);

        $w = array(10, 40, 25, 30, 35, 15, 20, 20, 20, 25, 50);
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
            $this->Cell($w[1], 6, $this->WrapText($row['nama_barang'], $w[1]), 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['kode_barang'], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row['kategori'], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, $row['merk_type'], 'LR', 0, 'L', $fill);
            $this->Cell($w[5], 6, $row['jumlah_barang'], 'LR', 0, 'C', $fill);
            $this->Cell($w[6], 6, $row['bahan'], 'LR', 0, 'L', $fill);
            $this->Cell($w[7], 6, $row['tahun_pembelian'], 'LR', 0, 'C', $fill);
            $this->Cell($w[8], 6, $row['kondisi'], 'LR', 0, 'L', $fill);
            $this->Cell($w[9], 6, $row['harga'], 'LR', 0, 'R', $fill);
            $this->Cell($w[10], 6, $this->WrapText($row['keterangan'], $w[10]), 'LR', 0, 'L', $fill);
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

    function WrapText($text, $width)
    {
        $charWidth = $this->GetStringWidth('A'); // Approximate width of a single character
        $maxChars = floor($width / $charWidth); // Max characters that fit within the cell width
        if (strlen($text) > $maxChars) {
            $text = substr($text, 0, $maxChars - 3) . '...'; // Truncate and add ellipsis
        }
        return $text;
    }
}

$query = "
    SELECT b.id, b.nama_barang, b.kode_barang, b.kategori, b.merk_type, b.jumlah_barang, b.bahan, b.tahun_pembelian, b.kondisi, b.harga, b.keterangan, r.nama_ruangan, l.nomor_lantai 
    FROM barang b 
    LEFT JOIN ruangan r ON b.ruangan_id = r.id 
    LEFT JOIN lantai l ON b.lantai_id = l.id
    ORDER BY l.nomor_lantai, r.nama_ruangan
";

$result = $conn->query($query);
$data = [];
$no = 1;
while ($row = $result->fetch_assoc()) {
    $row['no'] = $no++;
    $data[$row['nomor_lantai']][$row['nama_ruangan']][] = $row;
}

$pdf = new PDF('L', 'mm', 'A4');
$header = array('No', 'Nama Barang', 'Kode', 'Kategori', 'Merk/Type', 'Jumlah', 'Bahan', 'Tahun', 'Kondisi', 'Harga', 'Keterangan');
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
