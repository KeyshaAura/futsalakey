<?php
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");

// Pastikan variabel mengambil input dari form yang benar
$nama = $_POST['nama']; // Sesuai dengan name="nama" di form
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password biar aman
$nomor_hp = $_POST['nomor_hp'];
$role = 'User'; // Default role

// Pastikan query menggunakan nama kolom yang tepat (nama, bukan username)
$sql = "INSERT INTO users (nama, email, password, nomor_hp, role) VALUES ('$nama', '$email', '$password', '$nomor_hp', '$role')";

if (mysqli_query($conn, $sql)) {
    // Ambil data user yang baru saja daftar
    $id_baru = mysqli_insert_id($conn);
    
    // Set session langsung
    session_start();
    $_SESSION['login'] = true;
    $_SESSION['id_user'] = $id_baru;
    $_SESSION['nama'] = $nama;
    $_SESSION['role'] = 'User';
    
    echo "<script>alert('Registrasi Berhasil!'); window.location='index.php';</script>";
}
?>