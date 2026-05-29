<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");

if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Ups! Anda harus login terlebih dahulu untuk memberikan ulasan.'); 
            window.location='login.php';
          </script>";
    exit; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['komentar'])) {
    $id_user = $_SESSION['id_user'];
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
    
    $sql = "INSERT INTO reviews (id_user, komentar) VALUES ('$id_user', '$komentar')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Terima kasih atas ulasan Anda!'); window.location='index.php#ulasan';</script>";
    } else {
        echo "<script>alert('Gagal mengirim ulasan: " . mysqli_real_escape_string($conn, mysqli_error($conn)) . "'); window.location='index.php';</script>";
    }
}
?>