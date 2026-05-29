<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Gunakan id_review karena itu nama kolom primary key kamu
    mysqli_query($conn, "DELETE FROM reviews WHERE id_review = '$id'");
    header("Location: admin.php?page=ulasan");
}
?>