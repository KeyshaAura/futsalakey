<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Cilandak CSC</title>
    <style>
        body {
            background: #0f172a;
            color: white;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: rgba(255, 255, 255, 0.05);
            height: 100vh;
            padding: 20px;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
        }

        .content {
            flex: 1;
            padding: 40px;
        }

        .sidebar a {
            display: block;
            color: #94a3b8;
            text-decoration: none;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 5px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #00b894;
            color: white;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 20px;
            overflow-x: auto;
        }

        /* STYLE BARU UNTUK KOTAK DASHBOARD */
        .dashboard-container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .box-stat {
            flex: 1;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.01));
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 25px;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .box-stat span {
            font-size: 0.95rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .box-stat h3 {
            margin: 0;
            font-size: 2.2rem;
            color: #00b894;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: left;
        }

        th {
            color: #00b894;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        td {
            font-size: 0.9rem;
            color: #cbd5e1;
        }

        .price-text {
            color: #00b894;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2 style="color: #00b894;">Admin Panel</h2>
        <a href="admin.php?page=dashboard" class="<?= $page == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
        <a href="admin.php?page=lapangan" class="<?= $page == 'lapangan' ? 'active' : '' ?>">Kelola Lapangan</a>
        <a href="admin.php?page=booking" class="<?= $page == 'booking' ? 'active' : '' ?>">Kelola Booking</a>
        <a href="admin.php?page=ulasan" class="<?= $page == 'ulasan' ? 'active' : '' ?>">Kelola Ulasan</a>
        <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
        <a href="logout.php" style="color:#ff4757;">Logout</a>
    </div>

    <div class="content">
        
        <?php if ($page == 'dashboard'): ?>
            <h2>Dashboard Overview</h2>
            
            <div class="dashboard-container">
                <?php 
                $q_lapangan = mysqli_query($conn, "SELECT COUNT(*) as total FROM fields");
                $r_lapangan = mysqli_fetch_assoc($q_lapangan);
                ?>
                <div class="box-stat">
                    <span>Total Lapangan</span>
                    <h3><?= $r_lapangan['total'] ?></h3>
                </div>
                
                <?php 
                $q_booking = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings");
                $r_booking = mysqli_fetch_assoc($q_booking);
                ?>
                <div class="box-stat">
                    <span>Total Booking</span>
                    <h3><?= $r_booking['total'] ?></h3>
                </div>
            </div>

        <?php elseif ($page == 'lapangan'): ?>
            <h3>Kelola Lapangan</h3>
            <a href="tambah_lapangan.php"
                style="background:#00b894; padding:10px 20px; color:white; text-decoration:none; border-radius:10px; display: inline-block; margin-bottom: 10px;">+
                Tambah Lapangan</a>
            <div class="card">
                <table>
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                    <?php $fields = mysqli_query($conn, "SELECT * FROM fields");
                    while ($l = mysqli_fetch_assoc($fields)): ?>
                        <tr>
                            <td><?= $l['nama_lapangan'] ?></td>
                            <td>Rp <?= number_format($l['harga_per_jam']) ?></td>
                            <td>
                                <a href="edit_lapangan.php?id=<?= $l['id_lapangan'] ?>"
                                    style="color:yellow; text-decoration:none;">Edit</a> |
                                <a href="hapus_lapangan.php?id=<?= $l['id_lapangan'] ?>"
                                    style="color:red; text-decoration:none;"
                                    onclick="return confirm('Hapus lapangan ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>

        <?php elseif ($page == 'booking'): ?>
            <h3>Daftar Booking Masuk</h3>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Tanggal Main</th>
                            <th>Lapangan</th>
                            <th>Jam Mulai</th>
                            <th style="text-align: center;">Durasi</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_b = "SELECT bookings.*, users.nama, fields.nama_lapangan, schedules.jam_mulai 
                                    FROM bookings 
                                    LEFT JOIN users ON bookings.id_user = users.id_user 
                                    LEFT JOIN fields ON bookings.id_lapangan = fields.id_lapangan
                                    LEFT JOIN schedules ON bookings.id_jadwal = schedules.id_jadwal
                                    ORDER BY bookings.tanggal_sewa DESC";

                        $bookings = mysqli_query($conn, $query_b);
                        while ($b = mysqli_fetch_assoc($bookings)): ?>
                            <tr>
                                <td style="font-weight: 600; color: #fff;">
                                    <?= $b['nama'] ? htmlspecialchars($b['nama']) : 'User Dihapus/NULL' ?></td>

                                <td><?= isset($b['tanggal_sewa']) ? date('d-m-Y', strtotime($b['tanggal_sewa'])) : '-' ?></td>

                                <td><?= $b['nama_lapangan'] ? htmlspecialchars($b['nama_lapangan']) : 'Lapangan Dihapus/NULL' ?></td>
                                <td><span style="color: #e2e8f0;"><?= isset($b['jam_mulai']) ? substr($b['jam_mulai'], 0, 5) . ' WIB' : '-' ?></span></td>

                                <td style="text-align: center;">
                                    <span style="background: rgba(255, 255, 255, 0.1); padding: 5px 12px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; color: #fff; border: 1px solid rgba(255, 255, 255, 0.2); display: inline-block; white-space: nowrap;">
                                        <?= isset($b['durasi']) ? $b['durasi'] : '1' ?> Jam
                                    </span>
                                </td>

                                <td class="price-text">Rp <?= isset($b['total_harga']) ? number_format($b['total_harga'], 0, ',', '.') : '0' ?></td>

                                <td>
                                    <?php
                                    $status = htmlspecialchars($b['status_booking']);
                                    if (strtolower($status) == 'confirmed') {
                                        echo "<span style='color: #2ecc71; font-weight: 600;'>Confirmed</span>";
                                    } else {
                                        echo "<span style='color: #f1c40f; font-weight: 600;'>Pending</span>";
                                    }
                                    ?>
                                </td>

                                <td style="text-align: center;">
                                    <div style="display: flex; flex-direction: column; gap: 8px; align-items: center; justify-content: center;">
                                        <a href="update_status.php?id=<?= $b['id_booking'] ?>"
                                            style="display: inline-block; width: 85px; text-align: center; background: rgba(0, 184, 148, 0.1); color:#00b894; text-decoration:none; font-weight:600; padding: 6px 0; border-radius: 6px; border: 1px solid rgba(0, 184, 148, 0.2); font-size: 0.85rem;">Update</a>

                                        <a href="hapus_booking.php?id=<?= $b['id_booking'] ?>"
                                            style="display: inline-block; width: 85px; text-align: center; background: rgba(255, 71, 87, 0.1); color:#ff4757; text-decoration:none; font-weight:600; padding: 6px 0; border-radius: 6px; border: 1px solid rgba(255, 71, 87, 0.2); font-size: 0.85rem;"
                                            onclick="return confirm('Apakah kamu yakin ingin menghapus data booking ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($page == 'ulasan'): ?>
            <h3>Kelola Ulasan</h3>
            <div class="card">
                <table>
                    <tr>
                        <th>User</th>
                        <th>Komentar</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $ulasan = mysqli_query($conn, "SELECT reviews.*, users.nama FROM reviews JOIN users ON reviews.id_user = users.id_user");
                    while ($u = mysqli_fetch_assoc($ulasan)): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['nama']) ?></td>
                            <td><?= htmlspecialchars($u['komentar']) ?></td>
                            <td>
                                <a href="hapus_ulasan.php?id=<?= $u['id_review'] ?>" style="color:red; text-decoration:none;"
                                    onclick="return confirm('Hapus ulasan ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        <?php endif; ?>
        
    </div>
</body>

</html>