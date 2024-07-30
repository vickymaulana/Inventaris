<?php
include 'db.php';
include 'header.php';

$ruangan_id = $_GET['ruangan_id'];
$ruangan_result = $conn->query("SELECT nama_ruangan FROM ruangan WHERE id = $ruangan_id");
$ruangan = $ruangan_result->fetch_assoc();
$barang_result = $conn->query("SELECT * FROM barang WHERE ruangan_id = $ruangan_id");
?>

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Daftar Barang di Ruangan <?php echo $ruangan['nama_ruangan']; ?></h1>
    <a href="tambah_barang.php?ruangan_id=<?php echo $ruangan_id; ?>" class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Tambah Barang</a>
    <a href="export_pdf_per_ruangan.php?ruangan_id=<?php echo $ruangan_id; ?>" class="mb-4 ml-2 inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">Export PDF</a>
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead>
            <tr>
                <th class="py-3 px-4 bg-gray-200">No</th>
                <th class="py-3 px-4 bg-gray-200">Nama Barang</th>
                <th class="py-3 px-4 bg-gray-200">Kode Barang</th>
                <th class="py-3 px-4 bg-gray-200">Kategori</th>
                <th class="py-3 px-4 bg-gray-200">Merk/Type</th>
                <th class="py-3 px-4 bg-gray-200">Jumlah</th>
                <th class="py-3 px-4 bg-gray-200">Bahan</th>
                <th class="py-3 px-4 bg-gray-200">Tahun Pembelian</th>
                <th class="py-3 px-4 bg-gray-200">Kondisi</th>
                <th class="py-3 px-4 bg-gray-200">Harga</th>
                <th class="py-3 px-4 bg-gray-200">Keterangan</th>
                <th class="py-3 px-4 bg-gray-200">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($barang = $barang_result->fetch_assoc()): ?>
                <tr class="border-b">
                    <td class="py-3 px-4"><?php echo $no++; ?></td>
                    <td class="py-3 px-4"><?php echo $barang['nama_barang']; ?></td>
                    <td class="py-3 px-4"><?php echo $barang['kode_barang']; ?></td>
                    <td class="py-3 px-4"><?php echo $barang['kategori']; ?></td>
                    <td class="py-3 px-4"><?php echo $barang['merk_type']; ?></td>
                    <td class="py-3 px-4"><?php echo $barang['jumlah_barang']; ?></td>
                    <td class="py-3 px-4"><?php echo $barang['bahan']; ?></td>
                    <td class="py-3 px-4"><?php echo $barang['tahun_pembelian']; ?></td>
                    <td class="py-3 px-4"><?php echo $barang['kondisi']; ?></td>
                    <td class="py-3 px-4"><?php echo $barang['harga']; ?></td>
                    <td class="py-3 px-4"><?php echo $barang['keterangan']; ?></td>
                    <td class="py-3 px-4">
                        <a href="edit_barang.php?id=<?php echo $barang['id']; ?>" class="text-blue-500 hover:text-blue-700 transition">Edit</a>
                        <button onclick="showModal(<?php echo $barang['id']; ?>)" class="text-red-500 hover:text-red-700 ml-2 transition">Hapus</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-1/4 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Konfirmasi Hapus</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus barang ini?</p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="cancelButton" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Batal</button>
                <button id="confirmButton" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 mt-2">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(id) {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        const confirmButton = document.getElementById('confirmButton');
        confirmButton.onclick = function () {
            window.location.href = 'hapus_barang.php?id=' + id;
        }
    }

    document.getElementById('cancelButton').onclick = function () {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }
</script>

<?php include 'footer.php'; ?>
