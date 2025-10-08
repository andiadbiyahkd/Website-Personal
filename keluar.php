<?php
// Mulai sesi
session_start();

// Hapus semua sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Arahkan kembali ke halaman utama
header("Location: home.php");
exit;
?>
