<?php
session_start();
$loggedIn = isset($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>DAPUR RASA - Kategori</title>
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
      margin: 0;
      font-weight: 700;
      font-size: 1.8rem;
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

    .banner {
      background-image: linear-gradient(135deg, #000000, #ff9068);
      background-size: cover;
      background-position: center;
      height: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 36px;
      font-weight: bold;
      text-shadow: 2px 2px 5px rgba(0,0,0,0.5);
    }

    .kategori {
      display: flex;
      flex-direction: column;
      gap: 30px;
      padding: 60px 20px;
      max-width: 1000px;
      margin: 0 auto;
    }

    .card {
      display: flex;
      align-items: center;
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      overflow: hidden;
      transition: all 0.3s ease;
      cursor: pointer;
      height: 200px;
    }

    .card:hover {
      transform: translateY(-5px) scale(1.01);
      box-shadow: 0 15px 30px rgba(0,0,0,0.25);
    }

    .card img {
      width: 300px;
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s ease;
      flex-shrink: 0;
    }

    .card:hover img {
      transform: scale(1.05);
    }

    .card h3 {
      flex: 1;
      padding: 25px;
      font-size: 28px;
      color: #ff7043;
      text-align: center;
      font-weight: 700;
      letter-spacing: 0.5px;
    }

    footer {
      background-color: #f1f1f1;
      text-align: center;
      padding: 15px;
      margin-top: 40px;
      font-size: 14px;
    }

    /* Responsive design */
    @media (max-width: 768px) {
      header {
        flex-direction: column;
        gap: 15px;
      }
      
      .nav-container {
        justify-content: center;
        width: 100%;
      }
      
      nav {
        gap: 15px;
        flex-wrap: wrap;
        justify-content: center;
      }
      
      .search-form input {
        width: 150px;
      }

      .banner {
        font-size: 28px;
        height: 250px;
      }

      .card {
        flex-direction: column;
        height: auto;
      }

      .card img {
        width: 100%;
        height: 200px;
      }

      .card h3 {
        font-size: 22px;
        padding: 20px;
      }
    }

    @media (max-width: 480px) {
      .kategori {
        gap: 20px;
        padding: 40px 15px;
      }

      .card h3 {
        font-size: 20px;
        padding: 15px;
      }

      .card img {
        height: 150px;
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
      <?php if ($loggedIn): ?>
      <a href="/dapur_rasa/addresep.php">Tambah Resep</a>
      <?php else: ?>
        <a href="#" onclick="showLoginPopup()">Tambah Resep</a>
      <?php endif; ?>
      <a href="/dapur_rasa/about.php">Tentang Kami</a>
      <?php if ($loggedIn): ?>
        <a href="#" onclick="confirmLogout()">Logout</a>
      <?php else: ?>
        <a href="/dapur_rasa/login_view.php">Login/Register</a>
      <?php endif; ?>
    </nav>
    </div>
  </header>

  <div class="banner">
    Pilih Kategori Resep
  </div>

  <section class="kategori">
    <div class="card">
      <img src="image/utama.jpeg" alt="Makanan Utama">
      <h3>Makanan Utama</h3>
    </div>
    <div class="card">
      <img src="image/pendamping.jpg" alt="Makanan Pendamping">
      <h3>Makanan Pendamping</h3>
    </div>
    <div class="card">
      <img src="image/camilan.jpeg" alt="Camilan">
      <h3>Camilan</h3>
    </div>
  </section>

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
<!-- POPUP UNTUK LOGIN -->
<div id="loginPopup" style="
  display: none;
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 9999;
  align-items: center;
  justify-content: center;
">
  <div style="
    background-color: white;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    max-width: 300px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
  ">
    <p style="margin-bottom: 20px; font-size: 16px;">Masuk untuk menambahkan suatu resep! 🫡</p>
    <button onclick="window.location.href='login_view.php'" style="
      padding: 8px 16px;
      background-color: #e74c3c;
      color: white;
      border: none;
      border-radius: 6px;
      margin-right: 10px;
      cursor: pointer;
    ">Login</button>
    <button onclick="document.getElementById('loginPopup').style.display='none'" style="
      padding: 8px 16px;
      background-color: #95a5a6;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    ">Batal</button>
  </div>
</div>

<script>
  function showLoginPopup() {
    document.getElementById('loginPopup').style.display = 'flex';
  }
</script>
</body>
</html>