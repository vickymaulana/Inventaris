<?php
include 'db.php';
include 'header.php';

$lantai_result = $conn->query("SELECT * FROM lantai");
?>

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Pilih Lantai</h1>
    <div class="flex justify-end mb-4">
        <a href="export_excel.php" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition mr-2">Export ke Excel</a>
        <a href="export_pdf.php" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">Export ke PDF</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php while ($lantai = $lantai_result->fetch_assoc()): ?>
            <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
                <h2 class="text-2xl font-bold">Lantai <?php echo $lantai['nomor_lantai']; ?></h2>
                <div class="mt-4 flex justify-between">
                    <a href="ruangan.php?lantai_id=<?php echo $lantai['id']; ?>" class="text-blue-500">Lihat Ruangan</a>
                    <div class="flex space-x-2">
                        <a href="edit_lantai.php?id=<?php echo $lantai['id']; ?>" class="text-green-500">Edit</a>
                        <a href="hapus_lantai.php?id=<?php echo $lantai['id']; ?>" class="text-red-500">Hapus</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
