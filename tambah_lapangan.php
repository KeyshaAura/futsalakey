<?php
// Koneksi database (menggunakan variabel $conn agar senada dengan admin.php lu)
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");

if (isset($_POST['simpan'])) {
    $nama      = $_POST['nama_lapangan'];
    $luas      = $_POST['luas_lapangan'];
    $lantai    = $_POST['jenis_lantai'];
    $harga     = $_POST['harga_per_jam'];
    $kapasitas = $_POST['kapasitas_orang'];
    $desk      = $_POST['deskripsi'];

    // LOGIC UPLOAD GAMBAR
    $gambar_nama = $_FILES['gambar']['name'];
    $gambar_tmp  = $_FILES['gambar']['tmp_name'];
    $gambar_baru = time() . '_' . $gambar_nama; // Biar nama file unik
    $target_dir  = "uploads/";

    // Buat folder uploads jika belum ada
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Proses pindah file dan insert ke DB
    if (move_uploaded_file($gambar_tmp, $target_dir . $gambar_baru)) {
        $query = "INSERT INTO fields (nama_lapangan, luas_lapangan, jenis_lantai, harga_per_jam, kapasitas_orang, deskripsi, gambar) 
                  VALUES ('$nama', '$luas', '$lantai', '$harga', '$kapasitas', '$desk', '$gambar_baru')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Data Lapangan Berhasil Ditambahkan!'); window.location='admin.php?page=lapangan';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan ke database: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengunggah gambar!');</script>";
    }
}
?>

<style>
    .form-container {
        background-color: #1e2330; /* Warna card gelap senada background content */
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        max-width: 650px;
        margin: 20px auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-container h3 {
        color: #00b894; /* Warna hijau/teal khas admin panel lu */
        margin-top: 0;
        margin-bottom: 5px;
        font-size: 24px;
    }

    .form-container p {
        color: #a0a5b5;
        font-size: 14px;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        color: #e0e0e0;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 500;
    }

    .form-control-custom {
        width: 100%;
        padding: 12px 15px;
        background-color: #151922; /* Input box lebih gelap */
        border: 1px solid #2d3446;
        border-radius: 6px;
        color: #ffffff;
        font-size: 15px;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: #00b894;
        box-shadow: 0 0 8px rgba(0, 184, 148, 0.2);
    }

    .form-control-custom::placeholder {
        color: #4f566b;
    }

    textarea.form-control-custom {
        resize: vertical;
        min-height: 100px;
    }

    /* Style khusus untuk input file agar rapi */
    input[type="file"].form-control-custom {
        padding: 8px 12px;
        cursor: pointer;
    }

    .btn-group-custom {
        display: flex;
        gap: 12px;
        margin-top: 30px;
    }

    .btn-submit {
        background-color: #00b894;
        color: #ffffff;
        border: none;
        padding: 12px 24px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        flex: 2;
    }

    .btn-submit:hover {
        background-color: #009475;
    }

    .btn-cancel {
        background-color: #343a40;
        color: #a0a5b5;
        border: 1px solid #4f566b;
        padding: 12px 24px;
        text-align: center;
        font-size: 15px;
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
        flex: 1;
    }

    .btn-cancel:hover {
        background-color: #23272b;
        color: #ffffff;
    }
</style>

<div class="form-container">
    <h3>Tambah Lapangan Baru</h3>
    <p>Silakan isi formulir di bawah ini untuk menambahkan data lapangan futsal baru.</p>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Lapangan</label>
            <input type="text" name="nama_lapangan" class="form-control-custom" placeholder="Masukkan nama lapangan (ex: Lapangan A)" required>
        </div>

        <div class="form-group">
            <label>Luas Lapangan</label>
            <input type="text" name="luas_lapangan" class="form-control-custom" placeholder="Contoh: 26m x 16m" required>
        </div>

        <div class="form-group">
            <label>Jenis Lantai</label>
            <input type="text" name="jenis_lantai" class="form-control-custom" placeholder="Contoh: Vinyl / Interlock" required>
        </div>

        <div class="form-group">
            <label>Harga Per Jam (Rp)</label>
            <input type="number" name="harga_per_jam" class="form-control-custom" placeholder="Contoh: 150000" required>
        </div>

        <div class="form-group">
            <label>Kapasitas Orang</label>
            <input type="number" name="kapasitas_orang" class="form-control-custom" placeholder="Contoh: 10" required>
        </div>

        <div class="form-group">
            <label>Deskripsi Lapangan</label>
            <textarea name="deskripsi" class="form-control-custom" placeholder="Tuliskan deskripsi atau fasilitas lapangan..." required></textarea>
        </div>

        <div class="form-group">
            <label>Foto / Gambar Lapangan</label>
            <input type="file" name="gambar" class="form-control-custom" accept="image/*" required>
        </div>

        <div class="btn-group-custom">
            <a href="admin.php?page=lapangan" class="btn-cancel">Kembali</a>
            <button type="submit" name="simpan" class="btn-submit">Simpan Data</button>
        </div>
    </form>
</div>