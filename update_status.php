<?php
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");
$id = $_GET['id'];

if (isset($_POST['update_status'])) {
    $status = $_POST['status_booking'];
    mysqli_query($conn, "UPDATE bookings SET status_booking = '$status' WHERE id_booking = '$id'");
    header("Location: admin.php?page=booking"); // Balik ke tab booking
}

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE id_booking = '$id'"));
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Update Status</title>
    <style>
        body {
            background: #0f172a;
            color: white;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            padding-top: 50px;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 400px;
        }

        select {
            background: #1e293b;
            color: white;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #334155;
            width: 100%;
            margin: 20px 0;
        }

        button {
            background: #00b894;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
        }

        a {
            color: #94a3b8;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Update Booking #<?= $id ?></h2>
        <form method="POST">
            <select name="status_booking" style="padding:10px; width:200px;">
                <option value="Pending" <?= ($data['status_booking'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                <option value="Confirmed" <?= ($data['status_booking'] == 'Confirmed') ? 'selected' : '' ?>>Confirmed
                </option>
                <option value="Cancelled" <?= ($data['status_booking'] == 'Cancelled') ? 'selected' : '' ?>>Cancelled
                </option>
            </select>
            <button type="submit" name="update_status">Simpan Perubahan</button>
        </form>
        <a href="admin.php?page=booking">Kembali ke Dashboard</a>
    </div>

</body>

</html>