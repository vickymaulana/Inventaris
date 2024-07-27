<?php
include 'db.php';
include 'header.php';

$id = $_GET['id'];
$lantai_result = $conn->query("SELECT * FROM lantai WHERE id = $id");
$lantai = $lantai_result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomor_lantai = $_POST['nomor_lantai'];

    $sql = "UPDATE lantai SET nomor_lantai='$nomor_lantai' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Edit Lantai</h1>
    <form action="edit_lantai.php?id=<?php echo $id; ?>" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="nomor_lantai" class="block text-gray-700 font-bold mb-2">Nomor Lantai:</label>
            <input type="number" id="nomor_lantai" name="nomor_lantai" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="<?php echo $lantai['nomor_lantai']; ?>" required>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Simpan</button>
    </form>
</div>

<?php include 'footer.php'; ?>
