<?php
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    die("Akses ditolak. Silakan login.");
}

// Ambil data dari form
$resep_id = isset($_POST['resep_id']) ? intval($_POST['resep_id']) : 0;
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$isi_komentar = trim($_POST['isi_komentar']);
$nilai_rating = isset($_POST['nilai_rating']) ? intval($_POST['nilai_rating']) : 0;

// Validasi sederhana
if ($resep_id <= 0 || $nilai_rating < 1 || $nilai_rating > 5 || empty($isi_komentar)) {
    die("Data tidak valid.");
}

// Koneksi ke database
$koneksi = new mysqli("127.0.0.1:3307", "root", "", "dapur_rasa");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Simpan komentar (gunakan kolom: resep_id, user_id, username, isi, dibuat_pada)
$stmt_komentar = $koneksi->prepare("INSERT INTO komentar (resep_id, user_id, username, isi, dibuat_pada) VALUES (?, ?, ?, ?, NOW())");
$stmt_komentar->bind_param("iiss", $resep_id, $user_id, $username, $isi_komentar);
$stmt_komentar->execute();

// Simpan rating (gunakan kolom: resep_id, user_id, nilai)
$stmt_rating = $koneksi->prepare("INSERT INTO rating (resep_id, user_id, nilai) VALUES (?, ?, ?)
                                  ON DUPLICATE KEY UPDATE nilai = VALUES(nilai)");
$stmt_rating->bind_param("iii", $resep_id, $user_id, $nilai_rating);
$stmt_rating->execute();

// Tutup koneksi
$stmt_komentar->close();
$stmt_rating->close();
$koneksi->close();

// Redirect kembali ke halaman detail resep
header("Location: detailresep.php?id=" . $resep_id);
exit;
?>
