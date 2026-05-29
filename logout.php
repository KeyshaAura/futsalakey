<?php
session_start();
// Hapus semua data session
session_unset();
session_destroy();

// Balik ke beranda
header("Location: index.php");
exit;
?>