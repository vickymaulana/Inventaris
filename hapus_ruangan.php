<?php
include 'db.php';

$id = $_GET['id'];
$ruangan_result = $conn->query("SELECT * FROM ruangan WHERE id = $id");
$ruangan = $ruangan_result->fetch_assoc();
$lantai_id = $ruangan['lantai_id'];

$sql = "DELETE FROM ruangan WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: ruangan.php?lantai_id=$lantai_id");
} else {
    echo "Error: " . $conn->error;
}
?>
