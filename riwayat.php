<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");

// Query data
$id_user = $_SESSION['id_user'];
$query = "SELECT b.*, f.nama_lapangan, s.jam_mulai 
          FROM bookings b
          LEFT JOIN fields f ON b.id_lapangan = f.id_lapangan 
          LEFT JOIN schedules s ON b.id_jadwal = s.id_jadwal
          WHERE b.id_user = '$id_user'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body { background: #0f172a; color: white; font-family: sans-serif; padding: 40px; }
        .card { background: #1e293b; padding: 30px; border-radius: 20px; max-width: 800px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #334155; }
        th { color: #94a3b8; }
        .btn-back { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px; }
        .btn-back:hover { background: #2563eb; }
    </style>
</head>
<body>

<div class="card">
    <h2>Riwayat Pemesanan</h2>
    <table>
        <tr>
            <th>Lapangan</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
        </tr>
        <?php while ($r = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $r['nama_lapangan'] ?? 'N/A' ?></td>
            <td><?= $r['tanggal_sewa'] ?></td>
            <td><?= $r['jam_mulai'] ?? 'N/A' ?></td>
            <td><?= $r['status_booking'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="index.php" class="btn-back">← Kembali ke Beranda</a>
</div>

</body>
</html>