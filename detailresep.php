<?php
session_start(); // Tambahkan ini di baris pertama
// Ambil ID resep dari URL
if (!isset($_GET['id'])) {
    die("ID resep tidak ditemukan.");
}

$id = intval($_GET['id']); // Amankan ID

$asal = isset($_GET['asal']) ? $_GET['asal'] : 'semua.php';

// Koneksi database
$koneksi = new mysqli("127.0.0.1:3307", "root", "", "dapur_rasa");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data resep berdasarkan resep_id
$query = "SELECT resep.*, kategori.nama_kategori AS nama_kategori, users.username AS nama_pengguna
          FROM resep
          JOIN kategori ON resep.kategori_id = kategori.kategori_id
          JOIN users ON resep.pengguna_id = users.id
          WHERE resep.resep_id = $id";

$result = $koneksi->query($query);

if (!$result || $result->num_rows === 0) {
    die("Resep tidak ditemukan.");
}

$row = $result->fetch_assoc();

// Ambil semua komentar untuk resep ini
$komentarQuery = "SELECT * FROM komentar 
                  WHERE resep_id = $id 
                  ORDER BY dibuat_pada DESC";

$komentarResult = $koneksi->query($komentarQuery);

// Ambil rata-rata rating
$ratingQuery = "SELECT AVG(nilai) AS rata_rata FROM rating WHERE resep_id = $id";
$ratingResult = $koneksi->query($ratingQuery);
$rataRataRating = ($ratingResult && $ratingResult->num_rows > 0) ? round($ratingResult->fetch_assoc()['rata_rata'], 1) : "Belum ada rating";

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Resep - <?= htmlspecialchars($row['judul']) ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
      background-color: #fffdf8;
      color: #333;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    h1 {
      color: #ff7043;
    }
    img {
      width: 100%;
      max-height: 400px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .meta {
      font-size: 14px;
      color: #777;
      margin-bottom: 20px;
    }
    .section {
      margin-bottom: 25px;
    }
    .section h2 {
      font-size: 20px;
      color: #e05f33;
      margin-bottom: 10px;
    }
    .back-link {
      margin-top: 20px;
      display: inline-block;
      text-decoration: none;
      color: #ff7043;
    }
    .section .komentar {
      background: #fdf2e9;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 10px;
    }

  </style>
</head>
<body>
  <div class="container">
    <h1><?= htmlspecialchars($row['judul']) ?></h1>
    <div class="meta">
        Kategori: <?= htmlspecialchars($row['nama_kategori']) ?> |
        Diupload oleh: <?= htmlspecialchars($row['nama_pengguna']) ?>
    </div>

    <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['judul']) ?>">

    <div class="section">
      <h2>Bahan-Bahan</h2>
      <p><?= nl2br(htmlspecialchars($row['bahan'])) ?></p>
    </div>

    <div class="section">
      <h2>Langkah-Langkah</h2>
      <p><?= nl2br(htmlspecialchars($row['langkah'])) ?></p>
    </div>

    <div class="section">
      <h2>Rating</h2>
      <p>Rating rata-rata: <?= $rataRataRating ?> / 5</p>
    </div>

    <!-- Tampilkan Komentar -->
       <!-- Tampilkan Komentar -->
    <div class="section">
      <h2>Komentar</h2>
      <?php if ($komentarResult && $komentarResult->num_rows > 0): ?>
        <?php while ($komentar = $komentarResult->fetch_assoc()): ?>
          <div style="margin-bottom: 15px;">
            <strong><?= htmlspecialchars($komentar['username']) ?>:</strong><br>
            <span><?= nl2br(htmlspecialchars($komentar['isi'])) ?></span>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>Belum ada komentar.</p>
      <?php endif; ?>
    </div>

    <!-- Form Tambah Komentar dan Rating -->
    <?php if (isset($_SESSION['username']) && isset($_SESSION['user_id'])): ?>
      <div class="section">
        <h2>Berikan Komentar & Rating</h2>
        <form action="proses_komentar_rating.php" method="post">
          <input type="hidden" name="resep_id" value="<?= $id ?>">
          <textarea name="isi_komentar" rows="4" cols="50" placeholder="Tulis komentarmu..." required></textarea><br><br>
          <label for="nilai_rating">Beri Rating (1-5):</label>
          <select name="nilai_rating" id="nilai_rating" required>
            <option value="">-- Pilih --</option>
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
          </select><br><br>
          <button type="submit">Kirim</button>
        </form>
      </div>
    <?php else: ?>
      <p><a href="login_view.php">Login</a> untuk memberikan komentar dan rating.</p>
    <?php endif; ?>

    <a href="<?= htmlspecialchars($asal) ?>" class="back-link">← Kembali</a>
  </div>
</body>
</html>
