<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Lampung - Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-4">
    <nav class="mb-6">
        <ul class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
            <li><a href="index.php" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Home</a></li>
            <li><a href="tambah_ruangan.php" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Tambah Ruangan</a></li>
            <li><a href="tambah_lantai.php" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Tambah Lantai</a></li>
        </ul>
        <div class="flex justify-end mt-2 sm:mt-0">
            <a href="logout.php" class="block px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">Logout</a>
        </div>
    </nav>
</body>
</html>
<?php
$token = $_SESSION['session_token'];
$result = $conn->query("SELECT * FROM sessions WHERE session_token='$token'");

if ($result->num_rows != 1) {
    header("Location: login.php");
    exit();
}
?>