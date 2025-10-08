<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "justbuydb");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menangani upload gambar
    $targetDir = "admin/gambarAkunAov"; // Folder gambar berada di dalam folder admin
    
    // Pastikan folder gambarAkun ada, jika tidak, buat foldernya
    if (!is_dir($targetDir)) {
        if (mkdir($targetDir, 0777, true)) {
            echo "Folder berhasil dibuat!";
        } else {
            echo "Gagal membuat folder!";
            exit;
        }
    }

    $targetFile = $targetDir . "/" . basename($_FILES["preview_image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validasi ukuran dan ekstensi gambar
    $maxSize = 5 * 1024 * 1024; // Maksimal 5MB
    if ($_FILES["preview_image"]["size"] > $maxSize) {
        echo "File terlalu besar. Ukuran maksimal adalah 5MB.";
        exit;
    }

    // Cek apakah file adalah gambar
    if (getimagesize($_FILES["preview_image"]["tmp_name"])) {
        // Pindahkan file gambar ke folder yang ditentukan
        if (move_uploaded_file($_FILES["preview_image"]["tmp_name"], $targetFile)) {
            // Ambil data produk dari form
            $penjual = $_POST['penjual'];
            $skin = $_POST['skin'];
            $level = $_POST['level'];
            $hero = $_POST['hero'];
            $price = $_POST['price'];
            $deskripsi = $_POST['deskripsi'];
            $nomorWa = $_POST['nomor_wa'];  // Nomor WhatsApp
            $gambar = $targetFile; // Nama gambar yang diupload

            // Gunakan prepared statement untuk query
            $stmt = $koneksi->prepare("INSERT INTO akun (penjual, skin, level, hero, price, deskripsi, preview_image, nomor_wa) 
                                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("siisisss", $penjual, $skin, $level, $hero, $price, $deskripsi, $gambar, $nomorWa);

            if ($stmt->execute()) {
                // Setelah berhasil menambah produk, redirect ke halaman admin (misalnya halaman admin.php)
                header("Location: tambahAkunaov.php"); // Gantilah dengan halaman admin yang sesuai
                exit; // Pastikan proses PHP berhenti setelah redirect
            } else {
                echo "Gagal menambahkan produk.";
            }
            $stmt->close();
        } else {
            echo "Terjadi kesalahan saat mengunggah file.";
        }
    } else {
        echo "File yang diunggah bukan gambar.";
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    Penjual: <input type="text" name="penjual" required><br>
    Jumlah Skin: <input type="number" name="skin" required><br>
    Level: <input type="number" name="level" required><br>
    Jumlah Hero: <input type="number" name="hero" required><br>
    Harga: <input type="text" name="price" required><br>
    Deskripsi: <textarea name="deskripsi" required></textarea><br>
    Nomor WhatsApp: <input type="text" name="nomor_wa" required><br> <!-- Input Nomor WhatsApp -->
    Pilih gambar untuk diunggah: <input type="file" name="preview_image" required><br>
    <input type="submit" value="Tambahkan Produk">
</form>