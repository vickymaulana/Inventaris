<?php
include 'db.php';

if (isset($_SESSION['session_token'])) {
    $token = $_SESSION['session_token'];
    $conn->query("DELETE FROM sessions WHERE session_token='$token'");
    unset($_SESSION['session_token']);
}

header("Location: login.php");
exit();
?>
