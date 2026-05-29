<?php
session_start();

// 1. Koneksi ke Database
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. Ambil data dari form login
$input_nama = mysqli_real_escape_string($conn, $_POST['username']);
$input_pass = $_POST['password'];

// 3. Cari user berdasarkan nama
$query = mysqli_query($conn, "SELECT * FROM users WHERE nama = '$input_nama'");

if (mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);

    // 4. Verifikasi Password (menggunakan password_verify jika pakai hash)
    // Jika kamu menyimpan password tanpa hash, gunakan: if ($input_pass == $data['password'])
    if (password_verify($input_pass, $data['password'])) {
        
        // Simpan data ke session
        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role']; // Pastikan tabel users punya kolom 'role'

        // 5. Logika Redirect
        if ($data['role'] == 'Admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit;

    } else {
        // Password Salah
        echo "<script>alert('Password salah!'); window.location='login.php';</script>";
    }
} else {
    // Nama tidak ditemukan
    echo "<script>alert('Nama tidak terdaftar!'); window.location='login.php';</script>";
}
?>