<?php
// Koneksi ke database
$koneksi = new mysqli("127.0.0.1:3307", "root", "", "dapur_rasa");

// Cek koneksi
if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data resep dari database
$query = "SELECT resep.*, users.username, kategori.nama_kategori 
          FROM resep 
          JOIN users ON resep.pengguna_id = users.id 
          JOIN kategori ON resep.kategori_id = kategori.kategori_id";

$hasil = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Data Resep - DAPUR RASA</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      display: flex;
      min-height: 100vh;
      background-color: #fff8dc;
    }

    .sidebar {
      width: 220px;
      background-color: #ff7043;
      padding: 20px;
      color: white;
      flex-shrink: 0;
    }

    .sidebar .logo {
      display: flex;
      align-items: center;
      margin-bottom: 30px;
    }

    .sidebar .logo img {
      width: 40px;
      height: 40px;
      margin-right: 10px;
    }

    .sidebar h2 {
      font-size: 18px;
    }

    .sidebar nav a {
      display: block;
      color: white;
      text-decoration: none;
      margin: 10px 0;
      padding: 10px;
      border-radius: 6px;
      transition: background-color 0.2s;
    }

    .sidebar nav a:hover,
    .sidebar nav a.active {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .main-content {
      flex-grow: 1;
      padding: 40px;
      color: #333;
    }

    h1 {
      text-align: center;
      margin-bottom: 40px;
    }

    .card-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
    }

    .resep-card {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 20px;
      transition: transform 0.3s;
    }

    .resep-card:hover {
      transform: scale(1.03);
    }

    .resep-card h3 {
      color: #ff7043;
      font-size: 22px;
      margin-bottom: 10px;
    }

    .resep-card img {
      width: 100%;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    .resep-card p {
      color: #555;
      margin: 5px 0;
    }

    .aksi-btn {
      margin-top: 15px;
      display: flex;
      gap: 10px;
    }

    .btn-edit,
    .btn-hapus {
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      font-size: 14px;
      text-decoration: none;
      display: inline-block;
      text-align: center;
    }

    .btn-edit {
      background-color: #ffc107;
      color: black;
    }

    .btn-edit:hover {
      background-color: #e0a800;
    }

    .btn-hapus {
      background-color: #dc3545;
      color: white;
    }

    .btn-hapus:hover {
      background-color: #c82333;
    }

    footer {
      text-align: center;
      margin-top: 40px;
      font-size: 14px;
      background-color: #f1f1f1;
      padding: 15px;
      border-radius: 8px;
    }
  </style>
</head>
<body>

<aside class="sidebar">
  <div class="logo">
    <img src="image/logo.png" alt="Logo">
    <h2>Dapur Rasa</h2>
  </div>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="data_resep.php" class="active">Data Resep</a>
    <a href="data_kategori.php">Data Kategori</a>
    <a href="logout.php">Logout</a>
  </nav>
</aside>

<main class="main-content">
  <h1>Data Resep</h1>
  
  <?php if (isset($_GET['hapus']) && $_GET['hapus'] == 'berhasil'): ?>
  <p style="color: green; text-align:center; margin-bottom: 20px;">
    Resep berhasil dihapus.
  </p>
<?php endif; ?>

  <div class="card-container">
    <?php while ($row = $hasil->fetch_assoc()): ?>
      <div class="resep-card">
        <h3><?= htmlspecialchars($row['judul']) ?></h3>
        <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['judul']) ?>">
        <p><strong>Author:</strong> <?= htmlspecialchars($row['username']) ?></p>
        <p><strong>Kategori:</strong> <?= htmlspecialchars($row['nama_kategori']) ?></p>
        <div class="aksi-btn">
          <a href="edit_resep.php?id=<?= $row['resep_id'] ?>" class="btn-edit">Edit</a>
          <a href="hapus_resep.php?id=<?= $row['resep_id'] ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus resep ini?')">Hapus</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <footer>
    <b>Panel Admin - Dapur Rasa</b>
  </footer>
</main>

</body>
</html>
