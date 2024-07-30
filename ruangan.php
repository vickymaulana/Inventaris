<?php
include 'db.php';
include 'header.php';
if (!isset($_SESSION['session_token'])) {
    header("Location: login.php");
    exit();
}

$token = $_SESSION['session_token'];
$result = $conn->query("SELECT * FROM sessions WHERE session_token='$token'");

if ($result->num_rows != 1) {
    header("Location: login.php");
    exit();
}
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
                        <button onclick="showModal(<?php echo $ruangan['id']; ?>)" class="text-red-500">Hapus</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-1/4 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Konfirmasi Hapus</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus ruangan ini?</p>
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
            window.location.href = 'hapus_ruangan.php?id=' + id;
        }
    }

    document.getElementById('cancelButton').onclick = function () {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }
</script>

<?php include 'footer.php'; ?>
