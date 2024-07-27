<?php
include 'db.php';

$id = $_GET['id'];
$barang_result = $conn->query("SELECT * FROM barang WHERE id = $id");
$barang = $barang_result->fetch_assoc();
$ruangan_id = $barang['ruangan_id'];

$sql = "DELETE FROM barang WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: barang.php?ruangan_id=$ruangan_id");
} else {
    echo "Error: " . $conn->error;
}
?>
