<?php
// Koneksi database
$host = "localhost";
$username = "root";
$password = "";
$database = "justbuydb";
$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Fungsi redirect dengan pesan
function redirectWithMessage($messageType, $messageContent)
{
    header("Location: " . $_SERVER['PHP_SELF'] . "?$messageType=" . urlencode($messageContent));
    exit();
}

// Tambah data
if (isset($_POST['add_data'])) {
    $targetDir = "admin/gambarAkunWr";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $targetFile = $targetDir . "/" . basename($_FILES["preview_image"]["name"]);
    if (move_uploaded_file($_FILES["preview_image"]["tmp_name"], $targetFile)) {
        // Data form
        $penjual = $_POST['penjual'];
        $skin = $_POST['skin'];
        $level = $_POST['level'];
        $hero = $_POST['hero'];
        $price = $_POST['price'];
        $deskripsi = $_POST['deskripsi'];
        $nomorWa = $_POST['nomor_wa'];

        $stmt = $koneksi->prepare("INSERT INTO akunwr (penjual, skin, level, hero, price, deskripsi, preview_image, nomor_wa) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siisisss", $penjual, $skin, $level, $hero, $price, $deskripsi, $targetFile, $nomorWa);

        if ($stmt->execute()) {
            redirectWithMessage("success_message", "Akun berhasil ditambahkan");
        } else {
            redirectWithMessage("error_message", "Gagal menambahkan Akun");
        }
        $stmt->close();
    } else {
        redirectWithMessage("error_message", "Gagal mengunggah gambar");
    }
}

// Hapus data
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    // Ambil path gambar untuk dihapus
    $stmt = $koneksi->prepare("SELECT preview_image FROM akunwr WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->bind_result($imagePath);
    $stmt->fetch();
    $stmt->close();

    if ($imagePath && file_exists($imagePath)) {
        unlink($imagePath); // Hapus gambar
    }

    $stmt = $koneksi->prepare("DELETE FROM akunwr WHERE id = ?");
    $stmt->bind_param("i", $deleteId);

    if ($stmt->execute()) {
        redirectWithMessage("success_message", "Data berhasil dihapus");
    } else {
        redirectWithMessage("error_message", "Gagal menghapus data");
    }
}

// Edit data
if (isset($_POST['edit_data'])) {
    $id = $_POST['id'];
    $penjual = $_POST['penjual'];
    $skin = $_POST['skin'];
    $level = $_POST['level'];
    $hero = $_POST['hero'];
    $price = $_POST['price'];
    $deskripsi = $_POST['deskripsi'];
    $nomorWa = $_POST['nomor_wa'];

    // Jika ada gambar baru diunggah
    if (!empty($_FILES["preview_image"]["name"])) {
        $targetDir = "admin/gambarAkunWr";
        $targetFile = $targetDir . "/" . basename($_FILES["preview_image"]["name"]);
        if (move_uploaded_file($_FILES["preview_image"]["tmp_name"], $targetFile)) {
            // Hapus gambar lama
            $stmt = $koneksi->prepare("SELECT preview_image FROM akunwr WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($oldImage);
            $stmt->fetch();
            $stmt->close();

            if ($oldImage && file_exists($oldImage)) {
                unlink($oldImage);
            }

            $stmt = $koneksi->prepare("UPDATE akunwr SET penjual=?, skin=?, level=?, hero=?, price=?, deskripsi=?, preview_image=?, nomor_wa=? WHERE id=?");
            $stmt->bind_param("siisisssi", $penjual, $skin, $level, $hero, $price, $deskripsi, $targetFile, $nomorWa, $id);
        }
    } else {
        $stmt = $koneksi->prepare("UPDATE akunwr SET penjual=?, skin=?, level=?, hero=?, price=?, deskripsi=?, nomor_wa=? WHERE id=?");
        $stmt->bind_param("siisissi", $penjual, $skin, $level, $hero, $price, $deskripsi, $nomorWa, $id);
    }

    if ($stmt->execute()) {
        redirectWithMessage("success_message", "Data berhasil diperbarui");
    } else {
        redirectWithMessage("error_message", "Gagal memperbarui data");
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah akun WildRift</title>
    <link rel="stylesheet" href="styletambahakun.css">
</head>
<body style="background-image: url('../image/wildrift.jpeg'); background-size: cover; background-repeat: no-repeat;">
    
    <form action="" method="POST" enctype="multipart/form-data">
    <h1>Tambah Akun</h1>
        <input type="text" name="penjual" placeholder="Nama Penjual" required><br>
        <input type="number" name="skin" placeholder="Jumlah Skin" required><br>
        <input type="number" name="level" placeholder="Level Akun" required><br>
        <input type="text" name="hero" placeholder="Champion" required><br>
        <input type="number" name="price" placeholder="Harga" required><br>
        <textarea name="deskripsi" placeholder="Deskripsi" required></textarea><br>
        <input type="file" name="preview_image" accept="image/*" required><br>
        <input type="text" name="nomor_wa" placeholder="Nomor WhatsApp" required><br>
        <button type="submit" name="add_data">Tambah Akun</button>
        <table border="1">
        <thead>
        <tr>
                <th>Penjual</th>
                <th>Skin</th>
                <th>Level</th>
                <th>Champion</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Nomor WA</th>
                <th>aksi</th>
          
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $koneksi->query("SELECT * FROM akunwr");
            while ($row = $result->fetch_assoc()) {
                
                echo "<tr>
                        
                        <td>{$row['penjual']}</td>
                        <td>{$row['skin']}</td>
                        <td>{$row['level']}</td>
                        <td>{$row['hero']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['deskripsi']}</td>
                        <td><img src='{$row['preview_image']}' alt='Gambar' width='100'></td>
                        <td>{$row['nomor_wa']}</td>
                        <td>
                            <a href='?edit_id={$row['id']}'>Edit</a> |
                            <a href='?delete_id={$row['id']}'>Hapus</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
    </form>

    


    <?php
    if (isset($_GET['edit_id'])) {
        $editId = $_GET['edit_id'];
        $stmt = $koneksi->prepare("SELECT * FROM akunwr WHERE id = ?");
        $stmt->bind_param("i", $editId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        ?>
        
        <form action="" method="POST" enctype="multipart/form-data">
        <h1>Edit Akun</h1>
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            <input type="text" name="penjual" value="<?php echo $data['penjual']; ?>" required><br>
            <input type="number" name="skin" value="<?php echo $data['skin']; ?>" required><br>
            <input type="number" name="level" value="<?php echo $data['level']; ?>" required><br>
            <input type="text" name="hero" value="<?php echo $data['hero']; ?>" required><br>
            <input type="number" name="price" value="<?php echo $data['price']; ?>" required><br>
            <textarea name="deskripsi" required><?php echo $data['deskripsi']; ?></textarea><br>
            <input type="file" name="preview_image" accept="image/*"><br>
            <input type="text" name="nomor_wa" value="<?php echo $data['nomor_wa']; ?>" required><br>
            <button type="submit" name="edit_data">Simpan Perubahan</button>
        </form>
        <?php
    }
    ?>

    <script>
        // Ambil parameter dari URL
        const urlParams = new URLSearchParams(window.location.search);
        const successMessage = urlParams.get('success_message');
        const errorMessage = urlParams.get('error_message');

        // Tampilkan pesan
        if (successMessage) {
            alert(successMessage);
        } else if (errorMessage) {
            alert(errorMessage);
        }

        // Hapus parameter dari URL setelah menampilkan pesan
        const newURL = window.location.href.split("?")[0];
        window.history.replaceState(null, null, newURL);
    </script>
</body>
</html>
