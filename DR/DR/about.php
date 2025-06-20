<?php
session_start();
$loggedIn = isset($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tentang Kami - Dapur Rasa</title>
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
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background-color: #ff7043;
      color: white;
      padding: 12px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .logo-container {
      display: flex;
      align-items: center;
      gap: 10px;
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

    nav {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
    }

    nav a:hover {
      opacity: 0.8;
    }

    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 15px;
    }

    .about-container {
      width: 100%;
      max-width: 800px;
      background-color: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .about-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #ff7043;
      font-size: 28px;
    }

    .about-container p {
      margin-bottom: 18px;
      line-height: 1.6;
      font-size: 16px;
      text-align: justify;
    }

    footer {
      background-color: #f1f1f1;
      text-align: center;
      padding: 15px;
      font-size: 14px;
    }

    @media (max-width: 600px) {
      nav {
        justify-content: center;
        gap: 10px;
      }

      .about-container {
        padding: 20px;
      }

      .about-container h2 {
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
  </header>

  <main>
    <div class="about-container">
      <h2>Tentang Kami</h2>
      <p><strong>Dapur Rasa</strong> adalah platform yang dibuat oleh Kelompok 5 untuk berbagi berbagai resep masakan nusantara maupun internasional. Kami percaya bahwa memasak adalah seni yang dapat dinikmati semua orang, baik pemula maupun profesional.</p>
      
      <p>Website ini dirancang untuk memudahkan pengguna dalam mencari, menambahkan, dan berbagi resep favorit mereka. Semua fitur yang disediakan bertujuan untuk memperkaya pengalaman memasak di rumah.</p>
      
      <p>Kami berharap Dapur Rasa bisa menjadi sumber inspirasi dan tempat berbagi yang menyenangkan untuk para pecinta kuliner di mana saja.</p>
      
      <p><strong>Terima kasih telah menggunakan Dapur Rasa!</strong></p>
    </div>
  </main>

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