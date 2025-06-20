<?php
// PERINGATAN: HAPUS FILE INI SETELAH SELESAI MEMBUAT AKUN ADMIN!
// File ini hanya untuk sementara membuat akun admin

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    // Validasi input
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit;
    }
    
    // Cek apakah username atau email sudah ada
    $check_stmt = $conn->prepare("SELECT username FROM users WHERE username = ? OR email = ?");
    $check_stmt->bind_param("ss", $username, $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username atau Email sudah digunakan!'); window.history.back();</script>";
        exit;
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert ke database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);
    
    if ($stmt->execute()) {
        // Verifikasi bahwa password ter-hash dengan benar
        $verify_stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $verify_stmt->bind_param("s", $username);
        $verify_stmt->execute();
        $verify_result = $verify_stmt->get_result();
        $verify_user = $verify_result->fetch_assoc();
        
        // Test password verify
        $password_works = password_verify($password, $verify_user['password']);
        
        if ($password_works) {
            echo "<script>
                alert('✅ SUCCESS!\\n\\nAkun berhasil dibuat:\\nUsername: $username\\nEmail: $email\\nRole: $role\\nPassword Hash Length: " . strlen($verify_user['password']) . "\\n\\nPassword verification: WORKS!');
                window.location.href='register_admin.html';
            </script>";
        } else {
            echo "<script>
                alert('⚠️ WARNING!\\n\\nAkun dibuat tapi password verification GAGAL!\\nCoba lagi atau cek koneksi database.');
                window.location.href='register_admin.html';
            </script>";
        }
        
    } else {
        echo "<script>
            alert('❌ ERROR!\\n\\nGagal membuat akun: " . $conn->error . "');
            window.history.back();
        </script>";
    }
    
    $stmt->close();
    $check_stmt->close();
    if (isset($verify_stmt)) $verify_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing...</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
        .loading {
            text-align: center;
            padding: 20px;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .danger-note {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="loading">
        <div class="spinner"></div>
        <h3>Processing Registration...</h3>
        <p>Mohon tunggu sebentar...</p>
        
        <div class="danger-note">
            🚨 INGAT: HAPUS FILE INI SETELAH SELESAI! 🚨<br>
            File: register_admin.html & process_register_admin.php
        </div>
    </div>
</body>
</html>