<?php
include 'db.php';
include 'header.php';

$lantai_id = $_GET['lantai_id'];
$ruangan_result = $conn->query("SELECT * FROM ruangan WHERE lantai_id = $lantai_id");
?>

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Pilih Ruangan di Lantai <?php echo $lantai_id; ?></h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php while ($ruangan = $ruangan_result->fetch_assoc()): ?>
            <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
                <h2 class="text-2xl font-bold"><?php echo $ruangan['nama_ruangan']; ?></h2>
                <div class="mt-4 flex justify-between">
                    <a href="barang.php?ruangan_id=<?php echo $ruangan['id']; ?>" class="text-blue-500">Lihat Barang</a>
                    <div class="flex space-x-2">
                        <a href="edit_ruangan.php?id=<?php echo $ruangan['id']; ?>" class="text-green-500">Edit</a>
                        <a href="hapus_ruangan.php?id=<?php echo $ruangan['id']; ?>" class="text-red-500">Hapus</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
