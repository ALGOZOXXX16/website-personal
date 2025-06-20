<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Gunakan IP langsung, bukan "localhost"
$host = "127.0.0.1:3307";
$user = "root";
$pass = ""; // Tetap kosong karena root tidak pakai password
$db   = "dapur_rasa";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("❌ Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>
