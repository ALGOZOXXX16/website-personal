<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Hindari SQL injection (gunakan prepared statement jika bisa)
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
         $_SESSION['user_id'] = $user['id'];

        if ($user['role'] === 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: semua.php");
        }
        exit;
    } else {
        header("Location: login_view.php?login_error=1");
    }

    $stmt->close();
}
?>
