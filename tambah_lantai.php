<?php
include 'db.php';
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomor_lantai = $_POST['nomor_lantai'];

    $sql = "INSERT INTO lantai (nomor_lantai) VALUES ('$nomor_lantai')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Tambah Lantai</h1>
    <form action="tambah_lantai.php" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="nomor_lantai" class="block text-gray-700 font-bold mb-2">Nomor Lantai:</label>
            <input type="number" id="nomor_lantai" name="nomor_lantai" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Tambah</button>
    </form>
</div>

<?php include 'footer.php'; ?>
