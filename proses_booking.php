<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");

// Pastikan user sudah login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Tangkap data dari form booking
$id_user       = $_SESSION['id_user']; 
$id_lapangan   = $_POST['field_id'];
$id_jadwal     = $_POST['schedule_id'];
$durasi        = $_POST['durasi'];
$total_harga   = $_POST['total_harga']; 
$status_booking = "Pending"; 

// BARU: Kita isi tanggal_sewa dengan tanggal hari ini otomatis menggunakan fungsi date() PHP
$tanggal_sewa  = date("Y-m-d"); 

// PERBAIKAN UTAMA: Memasukkan kolom tanggal_sewa ke dalam query INSERT
$query = "INSERT INTO bookings (id_user, id_lapangan, id_jadwal, tanggal_sewa, durasi, total_harga, status_booking) 
          VALUES ('$id_user', '$id_lapangan', '$id_jadwal', '$tanggal_sewa', '$durasi', '$total_harga', '$status_booking')";

$simpan = mysqli_query($conn, $query);

if ($simpan) {
    echo "<script>
            alert('Booking berhasil diajukan! Menunggu konfirmasi admin.');
            window.location.href = 'index.php#booking'; 
          </script>";
} else {
    echo "<script>
            alert('Gagal melakukan booking, silakan coba lagi.');
            window.location.href = 'index.php#booking';
          </script>";
}
?>