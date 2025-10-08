<?php
$host = 'localhost';
$db = 'JustBuyDB';
$user = 'root';
$pass = ''; // Ganti dengan password MySQL Anda jika ada

// Buat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
