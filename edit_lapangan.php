<?php
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM fields WHERE id_lapangan = '$id'"));

if (isset($_POST['update'])) {
    $nama      = $_POST['nama_lapangan'];
    $luas      = $_POST['luas_lapangan'];
    $lantai    = $_POST['jenis_lantai'];
    $harga     = $_POST['harga_per_jam'];
    $kapasitas = $_POST['kapasitas_orang'];
    $desk      = $_POST['deskripsi'];
    $gambar_final = $_POST['gambar_lama'];

    // Cek upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {
        $gambar_baru = time() . '_' . $_FILES['gambar']['name'];
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads/" . $gambar_baru)) {
            if (file_exists("uploads/" . $gambar_final) && !empty($gambar_final)) {
                unlink("uploads/" . $gambar_final);
            }
            $gambar_final = $gambar_baru;
        }
    }

    $query = "UPDATE fields SET nama_lapangan='$nama', luas_lapangan='$luas', jenis_lantai='$lantai', 
              harga_per_jam='$harga', kapasitas_orang='$kapasitas', deskripsi='$desk', gambar='$gambar_final' WHERE id_lapangan='$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Lapangan Berhasil Diperbarui!'); window.location='admin.php?page=lapangan';</script>";
    }
}
?>

<style>
    .form-container {
        background: #1e2330; border-radius: 10px; padding: 25px; max-width: 600px; margin: 20px auto;
        font-family: 'Segoe UI', sans-serif; color: #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    .form-container h3 { color: #00b894; margin: 0 0 20px 0; font-size: 22px; }
    .form-grid { display: flex; gap: 15px; }
    .form-group { margin-bottom: 15px; flex: 1; }
    .form-group label { display: block; color: #e0e0e0; margin-bottom: 6px; font-size: 13px; }
    .form-control-custom {
        width: 100%; padding: 10px 12px; background: #151922; border: 1px solid #2d3446;
        border-radius: 6px; color: #fff; font-size: 14px; box-sizing: border-box;
    }
    .form-control-custom:focus { outline: none; border-color: #00b894; }
    .preview-section { display: flex; align-items: center; gap: 15px; background: #151922; padding: 10px; border-radius: 6px; border: 1px dashed #2d3446; }
    .btn-group { display: flex; gap: 10px; margin-top: 25px; }
    .btn-submit { background: #00b894; color: #fff; border: none; padding: 12px; font-weight: 600; border-radius: 6px; cursor: pointer; flex: 2; }
    .btn-submit:hover { background: #009475; }
    .btn-cancel { background: #343a40; color: #a0a5b5; border: 1px solid #4f566b; padding: 12px; text-align: center; text-decoration: none; font-weight: 600; border-radius: 6px; flex: 1; }
</style>

<div class="form-container">
    <h3>Edit Data Lapangan</h3>
    
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="gambar_lama" value="<?= $data['gambar'] ?>">

        <div class="form-group">
            <label>Nama Lapangan</label>
            <input type="text" name="nama_lapangan" class="form-control-custom" value="<?= $data['nama_lapangan'] ?>" required>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Luas Lapangan</label>
                <input type="text" name="luas_lapangan" class="form-control-custom" value="<?= $data['luas_lapangan'] ?>" required>
            </div>
            <div class="form-group">
                <label>Jenis Lantai</label>
                <input type="text" name="jenis_lantai" class="form-control-custom" value="<?= $data['jenis_lantai'] ?>" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Harga Per Jam (Rp)</label>
                <input type="number" name="harga_per_jam" class="form-control-custom" value="<?= $data['harga_per_jam'] ?>" required>
            </div>
            <div class="form-group">
                <label>Kapasitas Orang</label>
                <input type="number" name="kapasitas_orang" class="form-control-custom" value="<?= $data['kapasitas_orang'] ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi Lapangan</label>
            <textarea name="deskripsi" class="form-control-custom" rows="3" required><?= $data['deskripsi'] ?></textarea>
        </div>

        <div class="form-group">
            <label>Gambar Lapangan</label>
            <div class="preview-section">
                <?php if (!empty($data['gambar'])): ?>
                    <img src="uploads/<?= $data['gambar'] ?>" width="90" height="60" style="object-fit: cover; border-radius: 4px;">
                <?php endif; ?>
                <div style="flex: 1;">
                    <input type="file" name="gambar" class="form-control-custom" accept="image/*" style="padding: 5px;">
                    <small style="color: #a0a5b5; font-size: 11px; display: block; margin-top: 4px;">*Kosongkan jika tak ingin ganti gambar.</small>
                </div>
            </div>
        </div>

        <div class="btn-group">
            <a href="admin.php?page=lapangan" class="btn-cancel">Batal</a>
            <button type="submit" name="update" class="btn-submit">Simpan Perubahan</button>
        </div>
    </form>
    <!-- testing euyyy -->
</div>