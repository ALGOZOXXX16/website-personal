<?php
$host = "127.0.0.1:3307";
$user = "root";
$pass = "";
$db   = "dapur_rasa";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form dengan perlindungan dasar
$judul       = trim(strip_tags($_POST['judul']));
$bahan       = trim(strip_tags($_POST['bahan']));
$langkah     = trim(strip_tags($_POST['langkah']));
$kategori_id = (int) $_POST['kategori_id'];
$pengguna_id = (int) $_POST['pengguna_id'];

// Upload gambar
$folder_tujuan = "uploads/";
if (!is_dir($folder_tujuan)) {
    mkdir($folder_tujuan, 0777, true);
}

$gambar      = $_FILES['gambar']['name'];
$tmp_gambar  = $_FILES['gambar']['tmp_name'];
$gambar_ext  = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
$gambar_baru = uniqid() . '.' . $gambar_ext;

$allowed = ['jpg', 'jpeg', 'png', 'gif'];

if (!in_array($gambar_ext, $allowed)) {
    die("Format file tidak didukung. Hanya JPG, PNG, GIF.");
}

if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
    die("Ukuran gambar maksimal 2MB.");
}

if (!move_uploaded_file($tmp_gambar, $folder_tujuan . $gambar_baru)) {
    die("Gagal mengupload gambar.");
}

// Simpan ke database
$sql = "INSERT INTO resep (judul, bahan, langkah, gambar, kategori_id, pengguna_id) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssii", $judul, $bahan, $langkah, $gambar_baru, $kategori_id, $pengguna_id);

if ($stmt->execute()) {
    // Redirect ke halaman addresep.php dengan parameter sukses
    header("Location: addresep.php?success=1");
    exit();

} else {
    echo "Gagal menyimpan resep: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
