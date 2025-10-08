<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: masuk.php");
    exit;
}

// Konfigurasi koneksi ke database
$servername = "localhost";
$username_db = "root"; // Ganti sesuai username database Anda
$password_db = ""; // Ganti sesuai password database Anda
$dbname = "JustBuydb";

// Membuat koneksi
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data user tertentu (contoh dengan id yang diambil dari session)
$user_id = $_SESSION['user_id'];
$sql = "SELECT nama, nomor_telepon, profile_picture FROM users WHERE id = $user_id";
$result = $conn->query($sql);

// Memeriksa apakah data ditemukan
if ($result->num_rows > 0) {
    // Ambil data user
    $row = $result->fetch_assoc();
    $username = $row['nama'];
    $phone = $row['nomor_telepon'];
    $profile_picture = $row['profile_picture']; // Mendapatkan path foto profil
} else {
    $username = "Guest";
    $phone = "-";
    $profile_picture = null;
}

$status_message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $status_message = '<div class="alert alert-success show" id="alert-container">Profil berhasil diperbarui!</div>';
    } elseif ($_GET['status'] == 'error') {
        $status_message = '<div class="alert alert-danger" id="alert-container">Terjadi kesalahan, coba lagi nanti!</div>';
    }
}

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JustBuy</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="styleProfile.css">
    <link rel="stylesheet" href="anim.css">
 

    <style>
        #alert-container {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            width: auto;
            max-width: 90%;
            text-align: center;
        }

        #alert-container.show {
            opacity: 1;
            display:block;
        }

        #alert-container.hide {
            opacity: 0;}
       /* Footer */
       .footer {
            
            color: #fff;
            background-color: #32323e;
            padding: 10% 40px;
        }

        .footer-title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 1px 0 15px 0;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 20px;
        }

        .about-section img {
            width: 100px;
            margin: 25px 0 1px;
        }

        .about-section p {
            font-size: 14px;
            line-height: 1.5;
        }

        .links-section ul,
        .games-section ul {
            list-style: none;
            padding: 0;
        }

        .games-section ul li {
            margin-bottom: 10px;
        }

        .links-section a {
            color: #fff;
            text-decoration: none;
        }

        .payment-icons {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .payment-method1, .payment-method2, .payment-method3 {
            width: 100px;
            height: 50px;
            background-size: contain;
            /* Memastikan gambar sesuai dengan elemen */
            background-position: center;
            /* Memusatkan gambar dalam elemen */
            background-repeat: no-repeat;
            /* Mencegah pengulangan gambar */
        }

        .payment-method1 {
            background-image: url('image/alfa.webp');
        }

        .payment-method2 {
            background-image: url('image/qris.png');
        }

        .payment-method3 {
            background-image: url('image/BNI.webp');
        }

        .social-section .social-icons {
            display: flex;
            gap: 15px;
        }

        .social-icons i {
            font-size: 24px;
            color: #fff;
            transition: color 0.3s;
        }

        .social-icons i:hover {
            color: #0400ff;
        }

        /* Background for each game item */
        .game-item.moba1 {
            background-image: url('image/Benedetta.jpeg');
        }

        .game-item.moba2 {
            background-image: url('image/aov.jpeg');
        }

        .game-item.moba3 {
            background-image: url('image/wildrift.jpeg');
        }

        .game-item.rpg1 {
            background-image: url('image/genshin1.jpeg');
        }

        .game-item.rpg2 {
            background-image: url('image/starrail1.jpeg');
        }

        .game-item.rpg3 {
            background-image: url('image/zzz.jpeg');
        }

        .game-item.shooter1 {
            background-image: url('image/pubg.jpeg');
        }

        .game-item.shooter2 {
            background-image: url('image/ff.jpeg');
        }

        .game-item.shooter3 {
            background-image: url('image/valo.jpeg');
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background-color: transparent;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            padding: 10px;
            transition: color 0.3s;
        }

        .dropbtn:hover {
            color: #0059ff;
        }


    </style>
    <script>
        window.onload = function() {
            var alertContainer = document.getElementById('alert-container');
            if (alertContainer && alertContainer.classList.contains('show')) {
                // Menghilangkan alert setelah 1 detik (1000ms)
                setTimeout(function() {
                    alertContainer.classList.remove('show');
                    alertContainer.classList.add('hide');
                }, 1000);
            }
        };
        function showEditForm() {
    const mainContent = document.getElementById('main-content');
    const form = document.getElementById('edit-profile-form');
    form.style.display = 'block'; // Pastikan form ditampilkan terlebih dahulu
    form.classList.add('show');
    form.classList.remove('hide');  // Hapus animasi keluar jika form muncul
    document.getElementById('profile-info').style.display = 'none';
    document.getElementById('phone-info').style.display = 'none';  // Sembunyikan nomor telepon
    document.getElementById('edit-message').style.display = 'block';
    
    // Menambahkan animasi pemanjangan background saat tombol Edit Profil ditekan
    mainContent.classList.add('expand'); 
    mainContent.classList.remove('shrink'); // Menghapus kelas shrink
}

function hideEditForm() {
    const form = document.getElementById('edit-profile-form');
    const mainContent = document.getElementById('main-content');
    
    form.classList.add('hide');  // Menambahkan animasi keluar
    form.classList.remove('show');  // Menghapus animasi masuk
    
    // Setelah animasi selesai, sembunyikan form
    setTimeout(function() {
        form.style.display = 'none';  // Menyembunyikan form setelah animasi keluar
    }, 500);  // Durasi animasi keluar
    
    document.getElementById('profile-info').style.display = 'block';
    document.getElementById('phone-info').style.display = 'block'; // Tampilkan nomor telepon kembali
    
    // Menambahkan animasi pengecilan background saat tombol Batal ditekan
    mainContent.classList.add('shrink'); 
    mainContent.classList.remove('expand'); // Menghapus kelas expand
}


    </script>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <h1><span class="blue">J</span>ust<span class="blue">B</span>uy</h1>
        <p>Bukan sekadar website jual beli akun biasa, ini pintu menuju juara, aman, cepat, tanpa cela!</p>
    </div>

    <!-- Checkbox dan label untuk ikon hamburger -->
    <input type="checkbox" id="sidebar-toggle" class="sidebar-checkbox">
    <label for="sidebar-toggle" class="hamburger-menu">&#9776;</label>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Tombol close di dalam sidebar -->
        <label for="sidebar-toggle" class="close-btn">&times;</label>
        <h1><span class="blue">J</span>ust<span class="blue">B</span>uy</h1>
        <ul>
            <li class="menu-home"><a href="home.php"style="text-decoration: none; color: inherit;"
             onfocus="this.style.textDecoration='none';
              this.style.color='inherit'" onmouseover="this.style.textDecoration='none'; 
              this.style.color='inherit'" onmouseout="this.style.textDecoration='none';
               this.style.color='inherit'">Beranda</a></li>

        </ul>
    </div>

    <!-- Navbar (dengan tombol hamburger) -->
    <div class="navbar">
        <span class="hamburger-menu">&#9776;</span>
        <h1><span class="blue">J</span>ust<span class="blue">B</span>uy</h1>
        <p>Bukan sekadar website jual beli akun biasa, ini pintu menuju juara, aman, cepat, tanpa cela!</p>
    </div>

    <!-- Konten Utama -->
    <div class="container" id="main-container">
        <div class="main-content">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-picture">
                    <?php 
                    if ($profile_picture && file_exists($profile_picture)) {
                        // Tampilkan gambar profil jika ada
                        echo '<img src="' . $profile_picture . '" alt="Profile Picture" class="img-fluid">';
                    } else {
                        // Tampilkan dua huruf pertama dari username jika tidak ada gambar
                        echo '<span>' . strtoupper(substr($username, 0, 2)) . '</span>';
                    }
                    ?>
                </div>

                <div class="profile-info" id="profile-info">
                    <h2><?php echo htmlspecialchars($username); ?></h2>
                    <a href="javascript:void(0);" class="edit-button" onclick="showEditForm()">Edit Profile</a>
                </div>
            </div>

            <!-- Form Edit Profile (Tersembunyi pada awalnya) -->
            <div id="edit-profile-form" style="display: none;">
    
            <form action="updateProfil.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="new-name">Nama</label>
                <input type="text" id="new-name" name="new-name" class="form-control" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div>
                <label for="new-phone">No HP</label>
                <input type="text" id="new-phone" name="new-phone" class="form-control" value="<?php echo htmlspecialchars($phone); ?>" required>
            </div>
            <div>
                <label for="new-profile-picture">Foto Profil</label>
                <input type="file" id="new-profile-picture" name="new-profile-picture" class="form-control">
            </div>
            <button type="submit" class="save-btn py-2 px-4">Simpan Perubahan</button>
            <button type="button" class="save-btn py-2 px-4" onclick="hideEditForm()">Batal</button>
        </form>
            </div>

            <!-- Tampilan Profil -->
            <div class="profile-details">
                <p id="phone-info"><i class="icon-phone"></i>No HP: <?php echo htmlspecialchars($phone); ?></p>
            </div>
            <!-- Display Alert -->
            <?php echo $status_message; ?>
        </div>

        <div class="btn-container">
            <a href="https://wa.me/6288804740295?text=Halo%20saya%20ingin%20mulai%20jualan%20di%20JustBuy!" class="btn btn-success">Mulai Jual</a>
            <a href="keluar.php" class="btn btn-danger">Log Out</a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/bootstrap.js"></script>

    


    <div class="footer">
        <h2 class="footer-title">Tentang Kami</h2>
        <div class="footer-content">
            <div class="about-section">
                <img src="image/justbuy.png" alt="JustBuy JB Logo">
                <p>
                    Justbuy Hadir Sebagai Solusi Untuk Mengatasi Tantangan Ini. Kami Adalah Platform Yang Mengutamakan
                    Keamanan,
                    Transparansi, Dan Kepercayaan Antara Pembeli Dan Penjual. Dengan Fokus Pada Akun Game Online Dari
                    Berbagai
                    Genre, Justbuy Memungkinkan Anda Untuk Melakukan Transaksi Dengan Aman, Tanpa Khawatir Akan Risiko
                    Penipuan.
                </p>
            </div>
            <div class="links-section">
                <h3>PETA SITUS</h3>
                <ul>
                    <li><a href="#">Beranda</a></li>
                    <li><a href="login.html">Masuk</a></li>
                    <li><a href="signin.html">Daftar</a></li>
                </ul>
                <h3>Metode Pembayaran</h3>
                <div class="payment-icons">
                    <div class="payment-method1"></div>
                    <div class="payment-method2"></div>
                    <div class="payment-method3"></div>
                </div>

            </div>
            <div class="games-section">
                <h3>GAME POPULER</h3>
                <ul>
                    <li>Mobile Legends</li>
                    <li>Genshin Impact</li>
                    <li>PUBG</li>
                </ul>
            </div>
            <div class="social-section">
                <h3>IKUTI KAMI</h3>
                <div class="social-icons">
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
