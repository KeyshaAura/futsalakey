<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_futsal_csc");

// Ambil data dari database dengan pengecekan
$fields = mysqli_query($conn, "SELECT * FROM fields");
$schedules = mysqli_query($conn, "SELECT * FROM schedules");
$reviews = mysqli_query($conn, "SELECT * FROM reviews");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cilandak Sport Centre | Professional Arena</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00b894;
            --dark: #0f172a;
            --glass: rgba(255, 255, 255, 0.06);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #0f172a;
            color: #f1f5f9;
            line-height: 1.6;
        }

        /* NAVBAR */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 8%;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--glass-border);
        }

        .logo {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: 2px;
        }

        .nav-links a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* HERO */
        .hero {
            height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.9)), url('https://images.unsplash.com/photo-1575361204480-aadea25e6e68');
            background-size: cover;
            background-position: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        /* CONTAINER & GLASS CARD */
        .container {
            max-width: 1100px;
            margin: -50px auto 50px;
            padding: 0 20px;
        }

        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            margin-bottom: 40px;
        }

        .glass-card h2 {
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
        }

        .glass-card h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 50px;
            height: 3px;
            background: var(--primary);
            border-radius: 2px;
        }

        /* LAYOUT DUA LAPANGAN BERDAMPINGAN */
        .fields-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .field-card-item {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: 0.3s;
        }

        .field-card-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.04);
            border-color: var(--primary);
        }

        .field-image-wrapper {
            height: 240px;
            width: 100%;
            overflow: hidden;
        }

        .field-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .field-card-item:hover .field-image-wrapper img {
            transform: scale(1.05);
        }

        .field-info-wrapper {
            padding: 25px;
        }

        .field-info-wrapper h3 {
            font-size: 1.3rem;
            margin-bottom: 12px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .field-badge {
            background: rgba(0, 184, 148, 0.2);
            color: var(--primary);
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 50px;
            font-weight: 600;
        }

        .field-info-wrapper p {
            font-size: 0.9rem;
            color: #94a3b8;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .specs-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 15px;
        }

        .spec-detail {
            font-size: 0.85rem !important;
            color: #cbd5e1 !important;
            margin-bottom: 0 !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .spec-detail::before {
            content: '✓';
            color: var(--primary);
            font-weight: bold;
        }

        /* GRID UMUM */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        /* INPUT */
        .input-box {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.02);
            color: white;
            font-size: 1rem;
            border-radius: 8px 8px 0 0;
        }

        .input-box:focus {
            border-bottom: 2px solid var(--primary);
            background: rgba(255, 255, 255, 0.05);
            outline: none;
        }

        .input-box option {
            color: #000;
            background: #fff;
        }

        /* TAMPILAN ESTIMASI HARGA DAN WAKTU */
        .price-display-box {
            background: rgba(0, 184, 148, 0.1);
            border: 1px dashed var(--primary);
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price-title {
            font-size: 0.9rem;
            color: #cbd5e1;
        }

        .price-amount {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--primary);
        }

        /* GALERI */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .item {
            height: 200px;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--glass-border);
        }

        .item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .item:hover img {
            transform: scale(1.08);
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .fields-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 15px 20px;
            }

            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .container {
                margin-top: -20px;
            }
        }
    </style>
</head>

<body>

    <nav>
        <div class="logo">FUTSAL<span style="color: #00b894;">.CSC</span></div>
        <div class="nav-links">
            <a href="#info">Fasilitas</a>
            <a href="#operasional">Info</a>
            <a href="#galeri">Galeri</a>
            <a href="#ulasan">Ulasan</a>
            <a href="#booking">Booking</a>

            <?php if (isset($_SESSION['login'])): ?>
                <a href="riwayat.php" style="color: #00b894; font-weight: bold;">Riwayat Saya</a>
                <span style="color:white; margin-left: 20px;">Hi, <?= htmlspecialchars($_SESSION['nama']) ?>!</span>
                <a href="logout.php" style="color: #ff4757; font-weight: bold; margin-left: 10px;">Logout</a>
            <?php else: ?>
                <a href="login.php" style="background: #00b894; padding: 8px 20px; border-radius: 20px; text-decoration: none; color: white;">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <header class="hero">
        <h1>Cilandak Sport Centre</h1>
        <p>Premium Futsal Arena in South Jakarta</p>
    </header>

    <div class="container">
        
        <section id="info" class="glass-card">
            <h2>Pilihan Lapangan Arena</h2>
            
            <div class="fields-container">
                
                <div class="field-card-item">
                    <div class="field-image-wrapper">
                        <img src="csc.webp" alt="Lapangan Utama Vinyl">
                    </div>
                    <div class="field-info-wrapper">
                        <h3>Lapangan Utama (Vinyl) <span class="field-badge">Premium</span></h3>
                        <p>Lapangan utama menggunakan lantai material vinyl premium berstandar internasional yang empuk, memiliki daya cengkram tinggi untuk sepatu futsal, serta meredam benturan ekstrem secara optimal guna menghindari cedera lutut pemain.</p>
                        <div class="specs-list">
                            <p class="spec-detail">Lantai Vinyl Kelas Kompetisi</p>
                            <p class="spec-detail">Pencahayaan LED Match-Pro Tanpa Bayangan</p>
                            <p class="spec-detail">Ukuran Standar Turnamen Regional</p>
                        </div>
                    </div>
                </div>

                <div class="field-card-item">
                    <div class="field-image-wrapper">
                        <img src="csc3.webp" alt="Lapangan Rumput Sintetis">
                    </div>
                    <div class="field-info-wrapper">
                        <h3>Lapangan Kedua (Sintetis) <span class="field-badge" style="background:rgba(9, 132, 227, 0.2); color:#0984e3;">Rumput</span></h3>
                        <p>Lapangan kedua dibekali rumput sintetis berkualitas tinggi yang dirancang tebal dan lembut. Dilengkapi dengan lapisan interlock berkualitas di bawahnya, memberikan sensasi kontrol bola menyerupai rumput lapangan sepak bola asli.</p>
                        <div class="specs-list">
                            <p class="spec-detail">Rumput Sintetis Premium Lembut</p>
                            <p class="spec-detail">Sirkulasi Udara Samping Optimal</p>
                            <p class="spec-detail">Ideal Untuk Latihan & Pertandingan Kasual</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section id="operasional" class="glass-card">
            <h2>Jam Operasional & Alamat</h2>
            <p style="margin-top:10px;"><strong>Buka:</strong> Senin - Minggu | 06.00 - 22.00 WIB</p>
            <p><strong>Alamat:</strong> Jl. TB Simatupang No.Kav. 17, Cilandak Barat, Jakarta Selatan.</p>
        </section>

        <section id="galeri" class="glass-card">
            <h2>Galeri Arena</h2>
            <div class="gallery-grid" style="margin-top:20px;">
                <div class="item"><img src="csc4.png"></div>
                <div class="item"><img src="csc5.png"></div>
                <div class="item"><img src="csc6.png"></div>
            </div>
        </section>

        <section id="ulasan" class="glass-card">
            <h2 style="margin-bottom:20px;">Ulasan Pelanggan</h2>
            <?php
            $reviews_query = "SELECT reviews.*, users.nama FROM reviews JOIN users ON reviews.id_user = users.id_user";
            $reviews_result = mysqli_query($conn, $reviews_query);
            while ($r = mysqli_fetch_assoc($reviews_result)): ?>
                <div style="padding:15px; border-bottom:1px solid rgba(255,255,255,0.1);">
                    <p>"<?= htmlspecialchars($r['komentar']) ?>"</p>
                    <small style="color:#00b894;">— <?= htmlspecialchars($r['nama']) ?></small>
                </div>
            <?php endwhile; ?>

            <form action="proses_ulasan.php" method="POST" style="margin-top:20px;">
                <textarea name="komentar" class="input-box" placeholder="Tulis ulasanmu disini..." required></textarea>
                <button type="submit" style="background:#00b894; border:none; padding:10px 25px; border-radius:50px; color:white; cursor:pointer; font-weight:800; margin-top:10px;">KIRIM ULASAN</button>
            </form>
        </section>

        <section id="booking" class="glass-card">
            <h2 style="text-align:center; margin-bottom: 25px;">Form Booking</h2>

            <?php if (isset($_SESSION['login'])): ?>
                <form action="proses_booking.php" method="POST" style="max-width: 500px; margin: auto;">
                    <input type="text" name="nama" class="input-box" placeholder="Nama Lengkap" value="<?= htmlspecialchars($_SESSION['nama']) ?>" required>
                    <input type="date" name="tanggal" class="input-box" required>

                    <select name="field_id" class="input-box" required>
                        <option value="">Pilih Lapangan...</option>
                        <?php
                        if (mysqli_num_rows($fields) > 0) {
                            mysqli_data_seek($fields, 0);
                            while ($f = mysqli_fetch_assoc($fields)): ?>
                                <option value="<?= $f['id_lapangan'] ?>"><?= htmlspecialchars($f['nama_lapangan']) ?></option>
                            <?php endwhile;
                        } ?>
                    </select>

                    <select name="schedule_id" id="jam_mulai" class="input-box" required>
                        <option value="">Pilih Jam Mulai...</option>
                        <?php
                        if (mysqli_num_rows($schedules) > 0) {
                            mysqli_data_seek($schedules, 0);
                            while ($s = mysqli_fetch_assoc($schedules)): 
                                // Memotong format jam ambil bagian depannya saja (misal 19:00)
                                $jam_saja = substr($s['jam_mulai'], 0, 5); 
                            ?>
                                <option value="<?= $s['id_jadwal'] ?>" data-jam="<?= $jam_saja ?>">Jam <?= htmlspecialchars($jam_saja) ?></option>
                            <?php endwhile;
                        } ?>
                    </select>

                    <select name="durasi" id="durasi" class="input-box" required>
                        <option value="">Pilih Durasi Bermain...</option>
                        <option value="1">1 Jam</option>
                        <option value="2">2 Jam</option>
                        <option value="3">3 Jam</option>
                        <option value="4">4 Jam</option>
                    </select>

                    <div class="price-display-box" style="flex-direction: column; align-items: flex-start; gap: 5px;">
                        <div style="width: 100%; display: flex; justify-content: space-between;">
                            <span class="price-title">Estimasi Waktu:</span>
                            <span style="font-weight: 600; color: #fff;" id="estimasiWaktuDisplay">-</span>
                        </div>
                        <div style="width: 100%; display: flex; justify-content: space-between; margin-top: 5px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 5px;">
                            <span class="price-title">Total Biaya Lapangan:</span>
                            <span class="price-amount" id="totalHargaDisplay">Rp 0</span>
                        </div>
                    </div>
                    
                    <input type="hidden" name="total_harga" id="total_harga_input" value="0">

                    <button type="submit" class="input-box" style="background:var(--primary); font-weight:800; cursor:pointer; color: white;">SUBMIT RESERVASI</button>
                </form>
            <?php else: ?>
                <div style="text-align: center; padding: 20px 0;">
                    <p style="color: #cbd5e1; margin-bottom: 20px;">Kamu harus masuk akun terlebih dahulu untuk melakukan reservasi lapangan.</p>
                    <a href="login.php" style="background: #00b894; padding: 12px 35px; border-radius: 50px; text-decoration: none; color: white; font-weight: bold; display: inline-block;">Login Sekarang</a>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <footer>
        <div style="text-align:center; padding: 40px; color:rgba(255,255,255,0.5);">
            <p>&copy; 2026 Cilandak Sport Centre. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        const jamMulaiSelect = document.getElementById('jam_mulai');
        const durasiSelect = document.getElementById('durasi');
        const hargaDisplay = document.getElementById('totalHargaDisplay');
        const waktuDisplay = document.getElementById('estimasiWaktuDisplay');
        const hargaInputHidden = document.getElementById('total_harga_input');

        // KOMENTAR: Ubah nominal 150000 di bawah ini sesuai harga sewa per jam lapangannya
        const hargaPerJam = 150000; 

        function hitungBooking() {
            const durasi = parseInt(durasiSelect.value);
            const selectedOption = jamMulaiSelect.options[jamMulaiSelect.selectedIndex];
            const jamMulaiRaw = selectedOption ? selectedOption.getAttribute('data-jam') : null;

            // 1. Hitung Total Harga
            if (!isNaN(durasi) && durasi > 0) {
                const totalHarga = durasi * hargaPerJam;
                hargaInputHidden.value = totalHarga;
                hargaDisplay.textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
            } else {
                hargaDisplay.textContent = 'Rp 0';
                hargaInputHidden.value = 0;
            }

            // 2. Hitung Estimasi Rentang Jam Bermain (Jam Mulai s/d Jam Selesai)
            if (jamMulaiRaw && !isNaN(durasi) && durasi > 0) {
                let jam = parseInt(jamMulaiRaw.replace('.', ':').split(':')[0]);
                let menit = jamMulaiRaw.replace('.', ':').split(':')[1] || "00";
                
                let jamSelesai = jam + durasi;
                
                let stringJamMulai = jam.toString().padStart(2, '0') + ':' + menit;
                let stringJamSelesai = jamSelesai.toString().padStart(2, '0') + ':' + menit;

                waktuDisplay.textContent = stringJamMulai + ' s/d ' + stringJamSelesai + ' WIB';
            } else {
                waktuDisplay.textContent = '-';
            }
        }

        if(durasiSelect && jamMulaiSelect) {
            durasiSelect.addEventListener('change', hitungBooking);
            jamMulaiSelect.addEventListener('change', hitungBooking);
        }
    </script>

</body>
</html>