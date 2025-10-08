<?php
 
 session_start();

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

// Ambil data dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id']; // ID pengguna yang login
    }

        // Ambil data yang diubah dari form
        $new_name = $_POST['new-name'];
        $new_phone = $_POST['new-phone'];
    $new_name = $_POST['new-name'];
    $new_phone = $_POST['new-phone'];

    // Variabel untuk foto profil
    $profile_picture = null;

    // Periksa apakah foto profil diupload
    if (isset($_FILES['new-profile-picture']) && $_FILES['new-profile-picture']['error'] == 0) {
        // Cek error upload
        if ($_FILES['new-profile-picture']['error'] !== 0) {
            echo "Error upload: " . $_FILES['new-profile-picture']['error']; // Menampilkan error yang lebih rinci
            exit;
        }

        // Handle upload foto profil
        $target_dir = "uploads/"; // Pastikan folder ini ada dan dapat ditulis
        $target_file = $target_dir . basename($_FILES['new-profile-picture']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file gambar valid
        if (getimagesize($_FILES['new-profile-picture']['tmp_name']) === false) {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }

        // Cek jika file sudah ada
        if (file_exists($target_file)) {
            echo "File sudah ada.";
            $uploadOk = 0;
        }

        // Cek ukuran file
        if ($_FILES['new-profile-picture']['size'] > 5000000) { // 5MB
            echo "File terlalu besar.";
            $uploadOk = 0;
        }

        // Cek format gambar
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Tipe file tidak valid.";
            $uploadOk = 0;
        }

        // Jika semua pengecekan berhasil, upload file
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES['new-profile-picture']['tmp_name'], $target_file)) {
                $profile_picture = $target_file; // Simpan path lengkap ke database
                $_SESSION['success_message'] = "Profil berhasil diperbarui!";
            } else {
                echo "Gagal mengupload foto profil.";
            }
        } else {
            echo "File tidak valid atau gagal diupload.";
        }
    }

    // Query untuk memperbarui data pengguna
    if ($profile_picture !== null) {
        // Jika ada foto yang diupload
        $sql = "UPDATE users SET nama = ?, nomor_telepon = ?, profile_picture = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $new_name, $new_phone, $profile_picture, $user_id);
    } else {
        // Jika tidak ada foto yang diupload, hanya update nama dan nomor telepon
        $sql = "UPDATE users SET nama = ?, nomor_telepon = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $new_name, $new_phone, $user_id);
    }
    if ($stmt->execute()) {
        // Redirect ke halaman profil dengan status success
        header("Location: profil.php?status=success");
    } else {
        // Redirect ke halaman profil dengan status error
        header("Location: profil.php?status=error");
    }

    // Menutup koneksi
    $stmt->close();
    $conn->close();
}
?>