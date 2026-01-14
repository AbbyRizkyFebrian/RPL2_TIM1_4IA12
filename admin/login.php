<?php
session_start();
include '../config/koneksi.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); 

    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($query) === 1) {
        $data = mysqli_fetch_assoc($query);
        
        // Simpan session penting
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['role']     = $data['role']; // Simpan role (admin/owner)

        // Logika Pengalihan Berdasarkan Role
        if ($data['role'] == 'owner') {
            header("Location: ../owner/owner_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    } else {
        $error_message = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - CV Rizky Cipta Al-Fazza</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #1a237e; --secondary: #0d47a1; --bg: #f8f9fa; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: var(--bg); display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-card { background: white; width: 900px; max-width: 95%; display: flex; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .left-panel { flex: 1; background: linear-gradient(rgba(26,35,126,0.9), rgba(13,71,161,0.9)), url('https://source.unsplash.com/600x800/?construction'); background-size: cover; color: white; padding: 40px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; }
        .left-panel img { width: 80px; margin-bottom: 20px; filter: brightness(0) invert(1); }
        .right-panel { flex: 1; padding: 50px; display: flex; flex-direction: column; justify-content: center; }
        .right-panel h2 { color: var(--primary); font-size: 24px; margin-bottom: 10px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: #555; }
        .input-box { position: relative; }
        .input-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa; }
        .input-box input { width: 100%; padding: 12px 15px 12px 45px; border: 1px solid #ddd; border-radius: 8px; outline: none; transition: 0.3s; }
        .input-box input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(26,35,126,0.1); }
        .btn-login { width: 100%; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn-login:hover { background: var(--secondary); transform: translateY(-2px); }
        .forgot-link { text-align: right; margin-top: 10px; }
        .forgot-link a { font-size: 12px; color: var(--primary); text-decoration: none; font-weight: 600; }
        .alert { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 13px; border-left: 4px solid #b91c1c; }
        @media (max-width: 768px) { .left-panel { display: none; } }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="left-panel">
            <img src="../assets/images/pppl_icon.png" alt="Logo">
            <h1>Admin Panel</h1>
            <p>Sistem Informasi Pencatatan Proyek CV. Rizky Cipta Al-Fazza</p>
        </div>
        <div class="right-panel">
            <h2>Masuk Akun</h2>
            <p style="color:#777; margin-bottom:30px; font-size:14px;">Gunakan kredensial admin Anda untuk melanjutkan.</p>
            <?php if(!empty($error_message)): ?>
                <div class="alert"><i class="fas fa-exclamation-circle"></i> <?= $error_message; ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-box">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Masukkan username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-box">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" class="btn-login">LOGIN</button>
                <div class="forgot-link">
                    <a href="lupa_password.php">Lupa Password?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>