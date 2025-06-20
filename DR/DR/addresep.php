<?php
session_start();
$loggedIn = isset($_SESSION['username']);

if (!$loggedIn) {
  echo "<script>
    alert('Login untuk menambahkan resep anda');
    window.location.href = 'login_view.php';
  </script>";
  exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Resep - DAPUR RASA</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body {
      background-color: #fffdf8;
      color: #333;
    }

    header {
      background-color: #ff7043;
      color: white;
      padding: 12px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: nowrap;
    }

    .logo-container {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-shrink: 0;
    }

    .logo {
      max-height: 50px;
      width: auto;
      border-radius: 50%;
    }

    header h1 {
      font-size: 1.8rem;
      font-weight: bold;
    }

    .nav-container {
      display: flex;
      align-items: center;
      gap: 20px;
      flex: 1;
      justify-content: flex-end;
    }

    .search-form {
      display: flex;
      align-items: center;
      gap: 0;
    }

    .search-form input {
      height: 35px;
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-radius: 20px;
      outline: none;
      width: 200px;
      font-size: 14px;
    }

    .search-form button {
      height: 35px;
      padding: 6px 15px;
      background-color: #e05f33;
      color: white;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      font-weight: bold;
      font-size: 14px;
      margin-left: 8px;
    }

    .search-form button:hover {
      background-color: #d04a2a;
    }

    nav {
      display: flex;
      align-items: center;
      gap: 25px;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
      white-space: nowrap;
      transition: opacity 0.2s;
    }

    nav a:hover {
      opacity: 0.8;
    }

    .form-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #ff7043;
      font-size: 28px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 100px;
    }

    .form-group input[type="file"] {
      border: none;
      padding: 0;
    }

    .form-group button {
      background-color: #ff7043;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 10px;
      cursor: pointer;
      width: 100%;
    }

    .form-group button:hover {
      background-color: #e05f33;
    }

    footer {
      background-color: #f1f1f1;
      text-align: center;
      padding: 15px;
      margin-top: 40px;
      font-size: 14px;
    }

    @media (max-width: 600px) {
      .form-container {
        margin: 30px 15px;
        padding: 20px;
      }

      .form-container h2 {
        font-size: 22px;
      }
    }
  </style>
</head>
<body>

  <header>
    <div class="logo-container">
      <img src="image/logo.png" alt="Logo Dapur Rasa" class="logo">
      <h1>DAPUR RASA</h1>
    </div>

    <div class="nav-container">
      <form class="search-form" action="#" method="GET">
        <input type="text" name="q" placeholder="Cari resep..." />
        <button type="submit">Cari</button>
      </form>
      
    <nav>
      <a href="/dapur_rasa/semua.php">Semua</a>
      <a href="/dapur_rasa/kategori.php">Kategori</a>
      <a href="/dapur_rasa/addresep.php">Tambah Resep</a>
      <a href="/dapur_rasa/about.php">Tentang Kami</a>
      <?php if ($loggedIn): ?>
        <a href="#" onclick="confirmLogout()">Logout</a>
      <?php else: ?>
        <a href="/dapur_rasa/login_view.php">Login/Register</a>
      <?php endif; ?>
    </nav>
    </div>
  </header>

  <div class="form-container">
    <h2>Form Tambah Resep</h2>
    <form action="simpanresep.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="judul">Judul Resep</label>
        <input type="text" id="judul" name="judul" required>
      </div>

      <div class="form-group">
        <label for="bahan">Bahan-bahan</label>
        <textarea id="bahan" name="bahan" required></textarea>
      </div>

      <div class="form-group">
        <label for="langkah">Langkah-langkah</label>
        <textarea id="langkah" name="langkah" required></textarea>
      </div>

      <div class="form-group">
        <label for="gambar">Gambar Makanan</label>
        <input type="file" id="gambar" name="gambar" accept="image/*" required>
      </div>

      <div class="form-group">
        <label for="kategori_id">Kategori</label>
        <select id="kategori_id" name="kategori_id" required>
          <option value="">-- Pilih Kategori --</option>
          <option value="1">Makanan Utama</option>
          <option value="2">Makanan Pendamping</option>
          <option value="3">Camilan</option>
        </select>
      </div>

      <div class="form-group">
        <label for="pengguna_id">ID Pengguna</label>
        <input type="text" id="pengguna_id" name="pengguna_id" required>
      </div>

      <div class="form-group">
        <button type="submit">Simpan Resep</button>
      </div>
    </form>
  </div>

  <footer>
    <b>Kelompok 5 - Dapur Rasa -</b>
  </footer>
<script>
  function confirmLogout() {
    const confirmBox = document.createElement('div');
    confirmBox.style.position = 'fixed';
    confirmBox.style.top = '0';
    confirmBox.style.left = '0';
    confirmBox.style.width = '100%';
    confirmBox.style.height = '100%';
    confirmBox.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    confirmBox.style.display = 'flex';
    confirmBox.style.alignItems = 'center';
    confirmBox.style.justifyContent = 'center';
    confirmBox.style.zIndex = '9999';

    confirmBox.innerHTML = `
      <div style="
        background-color: white;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
        max-width: 300px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
      ">
        <p style="margin-bottom: 20px; font-size: 16px;">Anda yakin ingin logout?</p>
        <button onclick="window.location.href='logout.php'" style="
          padding: 8px 16px;
          background-color: #e74c3c;
          color: white;
          border: none;
          border-radius: 6px;
          margin-right: 10px;
          cursor: pointer;
        ">Logout</button>
        <button onclick="document.body.removeChild(this.parentNode.parentNode)" style="
          padding: 8px 16px;
          background-color: #95a5a6;
          color: white;
          border: none;
          border-radius: 6px;
          cursor: pointer;
        ">Batal</button>
      </div>
    `;

    document.body.appendChild(confirmBox);
  }
</script>
</body>
</html>
