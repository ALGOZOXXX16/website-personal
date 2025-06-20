<?php
// Debug aktif penuh
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

// Cek koneksi
if (!$conn) {
  die("❌ Koneksi database gagal: " . mysqli_connect_error());
}

// Cek apakah form dikirim dengan POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  echo "<h3>Data diterima dari form:</h3><pre>";
  print_r($_POST);
  echo "</pre>";

  $username = htmlspecialchars($_POST['username']);
  $email = htmlspecialchars($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  // Cek duplikasi
  $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");
  if (!$check) {
    die("❌ Query duplikasi gagal: " . mysqli_error($conn));
  }

  if (mysqli_num_rows($check) > 0) {
    die("⚠️ Username atau email sudah digunakan.");
  }

  // Simpan ke DB
  $query = "INSERT INTO users (username, email, password, role)
            VALUES ('$username', '$email', '$password', 'user')";

  echo "<h4>Query SQL:</h4>$query<br>";

  $insert = mysqli_query($conn, $query);
 if ($insert) {
  header("Location: register_success.html");
  exit();
} else {
  echo "<p style='color:red'>❌ Gagal menyimpan: " . mysqli_error($conn) . "</p>";
}
} else {
  echo "⛔ Form belum dikirim (bukan POST).";
}
?>
