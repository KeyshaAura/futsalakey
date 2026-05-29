<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Cilandak CSC</title>
    <style>
        body { 
            background: #0f172a; 
            color: white; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            font-family: 'Poppins', sans-serif; 
            margin: 0; 
        }
        .card { 
            background: rgba(255, 255, 255, 0.05); 
            padding: 40px; 
            border-radius: 20px; 
            width: 320px; 
            text-align: center; 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            backdrop-filter: blur(10px); 
        }
        h2 { margin-bottom: 25px; font-weight: 600; color: #00b894; }
        input { 
            width: 100%; 
            padding: 12px; 
            margin: 8px 0; 
            border-radius: 10px; 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            background: #1e293b; 
            color: white; 
            box-sizing: border-box;
        }
        input:focus { outline: none; border: 1px solid #00b894; }
        /* Trik anti-autofill */
        input:-webkit-autofill { -webkit-text-fill-color: white; transition: background-color 5000s ease-in-out 0s; }
        button { 
            width: 100%; 
            padding: 12px; 
            margin-top: 15px; 
            background: #00b894; 
            border: none; 
            color: white; 
            font-weight: 700; 
            cursor: pointer; 
            border-radius: 10px; 
            transition: 0.3s; 
        }
        button:hover { background: #009d7d; }
    </style>
</head>
<body>
    <div class="card">
        <h2>LOGIN</h2>
        <form action="proses_login.php" method="POST" autocomplete="off">
            <input type="text" name="username" placeholder="Nama Lengkap" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required>
            <input type="password" name="password" placeholder="Password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required>
            <button type="submit">MASUK</button>
        </form>

        <div style="margin-top:20px;">
            <a href="index.php" style="color: #64748b; text-decoration: none; font-size: 0.85rem;">&larr; Kembali ke Beranda</a>
            <span style="color: #334155; margin: 0 10px;">|</span>
            <a href="register.php" style="color: #00b894; text-decoration: none; font-size: 0.85rem;">Daftar Akun</a>
        </div>
    </div>
</body>
</html>