<?php
// Koneksi ke database
$koneksi = new mysqli("127.0.0.1:3307", "root", "", "dapur_rasa");
if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk menghitung total data
$totalResep = $koneksi->query("SELECT COUNT(*) as total FROM resep")->fetch_assoc()['total'];
$totalKategori = $koneksi->query("SELECT COUNT(*) as total FROM kategori")->fetch_assoc()['total'];
$totalPengguna = $koneksi->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Admin - DAPUR RASA</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

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
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .stats {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 40px;
      flex-wrap: wrap;
      margin-top: 50px;
    }

    .stat-box {
      background-color: #fff;
      border-radius: 16px;
      padding: 30px;
      width: 240px;
      height: 140px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      text-align: center;
      transition: transform 0.3s;
    }

    .stat-box:hover {
      transform: scale(1.05);
    }

    .stat-box h3 {
      font-size: 40px;
      color: #ff7043;
      margin-bottom: 10px;
    }

    .stat-box p {
      font-size: 18px;
      color: #555;
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
      <a href="dashboard.php" class="active">Dashboard</a>
      <a href="data_resep.php">Data Resep</a>
      <a href="data_kategori.php">Data Kategori</a>
      <a href="logout.php">Logout</a>
    </nav>
  </aside>

  <main class="main-content">
    <h1>Selamat Datang, Admin!</h1>
    <div class="stats">
      <div class="stat-box">
        <h3><?php echo $totalResep; ?></h3>
        <p>Total Resep</p>
      </div>
      <div class="stat-box">
        <h3><?php echo $totalKategori; ?></h3>
        <p>Total Kategori</p>
      </div>
      <div class="stat-box">
        <h3><?php echo $totalPengguna; ?></h3>
        <p>Pengguna Terdaftar</p>
      </div>
    </div>

    <footer>
      <b>Panel Admin - Dapur Rasa</b>
    </footer>
  </main>

</body>
</html>
