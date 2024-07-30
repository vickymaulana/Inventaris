<?php
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    
    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $token = generateToken();
            $user_id = $user['id'];
            $conn->query("INSERT INTO sessions (user_id, session_token) VALUES ($user_id, '$token')");
            
            $_SESSION['session_token'] = $token;
            header("Location: index.php");
            exit();
        } else {
            $error = 'Password salah';
        }
    } else {
        $error = 'Username tidak ditemukan';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen bg-gray-200">
    <div class="bg-white p-6 rounded-lg shadow-lg w-80">
        <h2 class="text-2xl font-bold mb-4">Login</h2>
        <?php if ($error): ?>
            <div class="mb-4 text-red-500"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="username">Username</label>
                <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" type="text" name="username" id="username" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="password">Password</label>
                <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" type="password" name="password" id="password" required>
            </div>
            <button class="w-full bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600 transition" type="submit">Login</button>
        </form>
    </div>
</body>
</html>
