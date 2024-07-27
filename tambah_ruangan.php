<?php
include 'db.php';
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_ruangan = $_POST['nama_ruangan'];
    $lantai_id = $_POST['lantai_id'];

    $sql = "INSERT INTO ruangan (nama_ruangan, lantai_id) VALUES ('$nama_ruangan', '$lantai_id')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$lantai_result = $conn->query("SELECT * FROM lantai");
?>

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Tambah Ruangan</h1>
    <form action="tambah_ruangan.php" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="nama_ruangan" class="block text-gray-700 font-bold mb-2">Nama Ruangan:</label>
            <input type="text" id="nama_ruangan" name="nama_ruangan" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="lantai_id" class="block text-gray-700 font-bold mb-2">Lantai:</label>
            <select id="lantai_id" name="lantai_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                <?php while ($lantai = $lantai_result->fetch_assoc()): ?>
                    <option value="<?php echo $lantai['id']; ?>"><?php echo $lantai['nomor_lantai']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Tambah</button>
    </form>
</div>

<?php include 'footer.php'; ?>
