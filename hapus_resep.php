<?php
// Koneksi ke database
$koneksi = new mysqli("127.0.0.1:3307", "root", "", "dapur_rasa");

// Cek koneksi
if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil ID dari URL
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  // Hapus gambar terlebih dahulu (jika ada)
  $getGambar = $koneksi->query("SELECT gambar FROM resep WHERE resep_id = $id");
  if ($getGambar && $getGambar->num_rows > 0) {
    $gambarData = $getGambar->fetch_assoc();
    $gambarPath = "uploads/" . $gambarData['gambar'];
    if (file_exists($gambarPath)) {
      unlink($gambarPath); // hapus file gambar dari folder
    }
  }

  // Hapus data resep
  $query = "DELETE FROM resep WHERE resep_id = $id";
  if ($koneksi->query($query)) {
    header("Location: data_resep.php?hapus=berhasil");
    exit();
  } else {
    echo "Gagal menghapus data: " . $koneksi->error;
  }
} else {
  echo "ID tidak ditemukan.";
}
?>
