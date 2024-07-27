<?php
include 'db.php';
include 'header.php';

$ruangan_id = $_GET['ruangan_id'];
$barang_result = $conn->query("SELECT * FROM barang WHERE ruangan_id = $ruangan_id");
?>

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Daftar Barang di Ruangan <?php echo $ruangan_id; ?></h1>
    <a href="tambah_barang.php?ruangan_id=<?php echo $ruangan_id; ?>" class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Tambah Barang</a>
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead>
            <tr>
                <th class="py-3 px-4 bg-gray-200">ID</th>
                <th class="py-3 px-4 bg-gray-200">Nama Barang</th>
                <th class="py-3 px-4 bg-gray-200">Jumlah</th>
                <th class="py-3 px-4 bg-gray-200">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($barang = $barang_result->fetch_assoc()): ?>
                <tr class="border-b">
                    <td class="py-3 px-4"><?php echo $barang['id']; ?></td>
                    <td class="py-3 px-4"><?php echo $barang['nama_barang']; ?></td>
                    <td class="py-3 px-4"><?php echo $barang['jumlah_barang']; ?></td>
                    <td class="py-3 px-4">
                        <a href="edit_barang.php?id=<?php echo $barang['id']; ?>" class="text-blue-500 hover:text-blue-700 transition">Edit</a>
                        <a href="hapus_barang.php?id=<?php echo $barang['id']; ?>" class="text-red-500 hover:text-red-700 ml-2 transition">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
