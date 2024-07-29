<?php
include 'db.php';
include 'header.php';

$id = $_GET['id'];
$barang_result = $conn->query("SELECT * FROM barang WHERE id = $id");
$barang = $barang_result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $kode_barang = $_POST['kode_barang'];
    $kategori = $_POST['kategori'];
    $merk_type = $_POST['merk_type'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $bahan = $_POST['bahan'];
    $tahun_pembelian = $_POST['tahun_pembelian'];
    $kondisi = $_POST['kondisi'];
    $harga = $_POST['harga'];
    $keterangan = $_POST['keterangan'];

    $sql = "UPDATE barang SET 
            nama_barang='$nama_barang', 
            kode_barang='$kode_barang', 
            kategori='$kategori', 
            merk_type='$merk_type', 
            jumlah_barang='$jumlah_barang', 
            bahan='$bahan', 
            tahun_pembelian='$tahun_pembelian', 
            kondisi='$kondisi', 
            harga='$harga', 
            keterangan='$keterangan' 
            WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: barang.php?ruangan_id=" . $barang['ruangan_id']);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Edit Barang</h1>
    <form action="edit_barang.php?id=<?php echo $id; ?>" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="nama_barang" class="block text-gray-700 font-bold mb-2">Nama Barang:</label>
            <input type="text" id="nama_barang" name="nama_barang" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="<?php echo $barang['nama_barang']; ?>" required>
        </div>
        <div class="mb-4">
            <label for="kode_barang" class="block text-gray-700 font-bold mb-2">Kode Barang (Opsional):</label>
            <input type="text" id="kode_barang" name="kode_barang" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="<?php echo $barang['kode_barang']; ?>">
        </div>
        <div class="mb-4">
            <label for="kategori" class="block text-gray-700 font-bold mb-2">Kategori (Opsional):</label>
            <input type="text" id="kategori" name="kategori" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="<?php echo $barang['kategori']; ?>">
        </div>
        <div class="mb-4">
            <label for="merk_type" class="block text-gray-700 font-bold mb-2">Merk/Type (Opsional):</label>
            <input type="text" id="merk_type" name="merk_type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="<?php echo $barang['merk_type']; ?>">
        </div>
        <div class="mb-4">
            <label for="jumlah_barang" class="block text-gray-700 font-bold mb-2">Jumlah Barang:</label>
            <input type="number" id="jumlah_barang" name="jumlah_barang" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="<?php echo $barang['jumlah_barang']; ?>" required>
        </div>
        <div class="mb-4">
            <label for="bahan" class="block text-gray-700 font-bold mb-2">Bahan:</label>
            <input type="text" id="bahan" name="bahan" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="<?php echo $barang['bahan']; ?>" required>
        </div>
        <div class="mb-4">
            <label for="tahun_pembelian" class="block text-gray-700 font-bold mb-2">Tahun Pembelian (Opsional):</label>
            <input type="number" id="tahun_pembelian" name="tahun_pembelian" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="<?php echo $barang['tahun_pembelian']; ?>">
        </div>
        <div class="mb-4">
            <label for="kondisi" class="block text-gray-700 font-bold mb-2">Kondisi:</label>
            <input type="text" id="kondisi" name="kondisi" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="<?php echo $barang['kondisi']; ?>" required>
        </div>
        <div class="mb-4">
            <label for="harga" class="block text-gray-700 font-bold mb-2">Harga (Opsional):</label>
            <input type="number" id="harga" name="harga" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="<?php echo $barang['harga']; ?>">
        </div>
        <div class="mb-4">
            <label for="keterangan" class="block text-gray-700 font-bold mb-2">Keterangan (Opsional):</label>
            <textarea id="keterangan" name="keterangan" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"><?php echo $barang['keterangan']; ?></textarea>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Simpan</button>
    </form>
</div>

<?php include 'footer.php'; ?>
