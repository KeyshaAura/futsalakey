<?php
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM fields WHERE id_lapangan = '$id'");
header("Location: admin.php");
?>