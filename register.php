<?php
include 'db.php';

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

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    $user_check = $conn->query("SELECT * FROM users WHERE username='$username'");
    
    if ($user_check->num_rows == 0) {
        if ($conn->query("INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')")) {
            $success = 'Akun berhasil dibuat';
        } else {
            $error = 'Terjadi kesalahan saat membuat akun';
        }
    } else {
        $error = 'Username sudah ada';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen bg-gray-200">
    <div class="bg-white p-6 rounded-lg shadow-lg w-80">
        <h2 class="text-2xl font-bold mb-4">Register</h2>
        <?php if ($error): ?>
            <div class="mb-4 text-red-500"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="mb-4 text-green-500"><?php echo $success; ?></div>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="username">Username</label>
                <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" type="text" name="username" id="username" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="password">Password</label>
                <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" type="password" name="password" id="password" required>
            </div>
            <button class="w-full bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600 transition" type="submit">Register</button>
        </form>
    </div>
</body>
</html>
