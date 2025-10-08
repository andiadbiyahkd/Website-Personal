<?php
session_start(); // Mulai session untuk mengakses data session

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JustBuy</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header */
        .header {
            background-color: #32323e;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header img {
            height: 50px;
        }

        .nav {
            display: flex;
            gap: 15px;
        }

        .nav a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: color 0.3s;
        }

        .nav a:hover {
            color: #00BFFF;
        }

        /* Main Content */
        .main-content {
            padding: 20px;
            text-align: center;
            background-image: url(image/11.jpg);
        }

        .main-content .large-placeholder {
            width: 80%;
            height: 300px;
            background-image: url('image/genshin1.jpeg');
            background-size: cover;
            background-position: center;
            margin: 0 auto;
        }

        /* Game List */
        .game-list {
            padding: 20px;
            background-image: url('image/jett.jpg');
            background-position: center;
            background-size: cover;
        }

        .game-list h2 {
            font-size: 24px;
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }

        .game-category h3 {
            font-size: 20px;
            color: #fff;
            margin-bottom: 15px;
        }

        .game-item {
            position: relative;
            width: 250px;
            height: 150px;
            margin: 15px;
            border-radius: 15px;
            overflow: hidden;
            display: inline-block;
            background-size: cover;
            background-position: center;
            transition: transform 0.3s ease-in-out;
            background-color: #00BFFF;
        }

        .game-item:hover {
            transform: scale(1.05);
        }

        .game-item .text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .game-item:hover .text {
            opacity: 1;
        }

        .game-item .text p {
            color: #fff;
            font-size: 18px;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            color: #fff;
            background-color: #32323e;
            padding: 20px 40px;
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

        /* Dropdown Content */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 160px;
            z-index: 1;
            border-radius: 5px;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            /* Space between icon and text */
        }

        .dropdown-content a:hover {
            background-color: #ffffff3d;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Social Icons */
        .dropdown-content a i {
            font-size: 20px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <a href="home.php">
            <img src="image/justbuy.png" alt="JustBuy JB Logo">
        </a>
        <div class="nav">
            <div class="dropdown">
                <a href="#" class="dropbtn">Layanan Pengguna</a>
                <div class="dropdown-content">
                    <a href="https://wa.me/+6285240779188">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="https://www.instagram.com/tekom_c23">
                        <i class="fab fa-instagram"></i> Instagram
                    </a>
                </div>
            </div>
            <a href="Profil.php">Profil</a>
            <a href="panduan.html">Panduan</a>
            <a href="masuk.php">Masuk/Daftar</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="large-placeholder"></div>
    </div>

    <!-- Game List -->
    <div class="game-list">
        <h2>Daftar Game</h2>
        <div class="game-category">
            <h3>MOBA</h3>
            <a href="listml.php">
            <div class="game-item moba1">
                <div class="text">
                    <p>Mobile Legend</p>
                </div>
            </div>
            </a>
            <a href="listaov.php">
            <div class="game-item moba2">
                <div class="text">
                    <p>Arena Of Valor</p>
                </div>
            </div>
            </a>
            <a href="listwr.php">
            <div class="game-item moba3">
                <div class="text">
                    <p>Wild Rift</p>
                </div>
            </div>
            </a>
        </div>

        <div class="game-category">
            <h3>RPG</h3>
            <a href="listgenshin.html">
                <div class="game-item rpg1">
                    <div class="text">
                        <p>Genshin Impact</p>
                    </div>
                </div>
            </a>
            <a href="listhsr.html">
            <div class="game-item rpg2">
                <div class="text">
                    <p>Star Rail</p>
                </div>
            </div>
            </a>
            <a href="listzzz.html">
            <div class="game-item rpg3">
                <div class="text">
                    <p>Zenless Zone Zero</p>
                </div>
            </div>
            </a>
        </div>

        <div class="game-category">
            <h3>SHOOTER</h3>
            <a href="listpubg.html">
                <div class="game-item shooter1">
                    <div class="text">
                    <p>PUBG</p>
                    </div>
                </div>
            </a>
            <a href="listff.html">
                <div class="game-item shooter2">
                    <div class="text">
                        <p>Free Fire</p>
                    </div>
                </div>
            </a>
            <a href = "listvalo.html">
            <div class="game-item shooter3">
                <div class="text">
                    <p>Valorant</p>
                </div>
            </div>
            </a>
        </div>
    </div>

    <!-- Footer -->
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
                    <li><a href="masuk.php">Masuk</a></li>
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