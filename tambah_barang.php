<?php
include 'db.php';
include 'header.php';

$ruangan_id = $_GET['ruangan_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];

    $sql = "INSERT INTO barang (nama_barang, jumlah_barang, ruangan_id) VALUES ('$nama_barang', '$jumlah_barang', '$ruangan_id')";
    if ($conn->query($sql) === TRUE) {
        header("Location: barang.php?ruangan_id=$ruangan_id");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Tambah Barang di Ruangan <?php echo $ruangan_id; ?></h1>
    <form action="tambah_barang.php?ruangan_id=<?php echo $ruangan_id; ?>" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="nama_barang" class="block text-gray-700 font-bold mb-2">Nama Barang:</label>
            <input type="text" id="nama_barang" name="nama_barang" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="jumlah_barang" class="block text-gray-700 font-bold mb-2">Jumlah Barang:</label>
            <input type="number" id="jumlah_barang" name="jumlah_barang" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Tambah</button>
    </form>
</div>

<?php include 'footer.php'; ?>
