<?php
// Koneksi database
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");

// Ambil id booking dari URL
if (isset($_GET['id'])) {
    $id_booking = $_GET['id'];

    // Eksekusi query hapus
    $query_hapus = mysqli_query($conn, "DELETE FROM bookings WHERE id_booking = '$id_booking'");

    if ($query_hapus) {
        // REDIRECT TETAP DI KELOLA BOOKING
        echo "<script>
                alert('Data Booking Berhasil Dihapus!'); 
                window.location='admin.php?page=booking';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data booking: " . mysqli_error($conn) . "'); 
                window.location='admin.php?page=booking';
              </script>";
    }
} else {
    // Jika tidak ada ID, kembalikan ke menu booking
    header("Location: admin.php?page=booking");
}
?>