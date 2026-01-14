<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - CV Rizky Cipta Al-Fazza</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a237e;
            --error-red: #e53e3e;
            --text-muted: #666;
        }

        body { 
            background-color: #f4f7f6; 
            font-family: 'Inter', sans-serif; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 100vh; 
            margin: 0; 
        }

        .card { 
            background: white; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
            width: 420px; 
            max-width: 90%;
            text-align: center; 
        }

        /* Lingkaran Merah dengan Ikon Gembok */
        .icon-box { 
            width: 70px; 
            height: 70px; 
            background: #fff5f5; /* Latar belakang merah muda */
            color: var(--error-red); /* Ikon merah */
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 25px; 
            font-size: 28px; 
        }

        h2 { font-size: 22px; color: #333; margin-bottom: 12px; }
        p { color: var(--text-muted); font-size: 14px; line-height: 1.6; margin-bottom: 30px; }

        /* Button WhatsApp */
        .contact-btn { 
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: var(--primary-color); 
            color: white; 
            text-decoration: none; 
            padding: 14px; 
            border-radius: 10px; 
            font-weight: bold; 
            font-size: 15px;
            transition: all 0.3s ease; 
        }

        .contact-btn:hover { 
            background: #0d47a1; 
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 35, 126, 0.2);
        }

        .back-link { 
            display: inline-block; 
            margin-top: 25px; 
            color: #888; 
            font-size: 13px; 
            text-decoration: none; 
            transition: color 0.2s;
        }

        .back-link:hover { color: var(--primary-color); }
        .back-link i { margin-right: 5px; }
    </style>
</head>
<body>

    <div class="card">
        <div class="icon-box">
            <i class="fa-solid fa-lock"></i>
        </div>
        
        <h2>Akses Terkunci?</h2>
        <p>
            Untuk alasan keamanan, pemulihan akun harus dilakukan secara manual oleh administrator sistem. Silakan klik tombol di bawah untuk meminta bantuan reset password.
        </p>

        <a href="https://wa.me/6285155338997?text=Lupa%20password" target="_blank" class="contact-btn">
            <i class="fa-brands fa-whatsapp fa-lg"></i>
            Hubungi IT Support
        </a>

        <a href="login.php" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Login
        </a>
    </div>

</body>
</html>