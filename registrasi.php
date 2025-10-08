<?php


include 'KoneksiDatabase/config.php'; // Pastikan path benar

// Mulai session untuk menyimpan status login
session_start();

$message = ""; // Variabel untuk pesan error atau sukses

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama = $_POST['Nama'];
    $nomor_telepon = $_POST['nomor_handphone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['Konfirmasi_password'];

    // Validasi panjang password
    if (strlen($password) < 6) {
        $message = "Password harus memiliki minimal 6 karakter.";
    } else if ($password !== $confirm_password) {
        $message = "Password tidak sesuai dengan yang dimasukkan.";
    } else {
        // Jika validasi sukses, simpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $check_sql = "SELECT * FROM users WHERE nomor_telepon = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("s", $nomor_telepon);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Nomor telepon sudah terdaftar.";
        } else {
            $sql = "INSERT INTO users (nama, nomor_telepon, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nama, $nomor_telepon, $hashed_password);

            if ($stmt->execute()) {
                // Pendaftaran berhasil, arahkan ke halaman login
                header("Location: masuk.php");
                exit;
            } else {
                $message = "Terjadi kesalahan saat registrasi.";
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - JustBuy</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="logo">
                <span>J</span>ust<span>B</span>uy
            </div>
            <h1>Daftar</h1>
            <p>Mohon masukan informasi pendaftaran dengan valid</p>

            <!-- Formulir Registrasi -->
            <form action="" method="POST">
                <div class="input-group">
                    <input type="text" name="Nama" placeholder="Nama" required value="<?php echo isset($_POST['Nama']) ? htmlspecialchars($_POST['Nama']) : ''; ?>">
                </div>
                <div class="input-group">
                    <input type="text" name="nomor_handphone" placeholder="Nomor Handphone" required value="<?php echo isset($_POST['nomor_handphone']) ? htmlspecialchars($_POST['nomor_handphone']) : ''; ?>">
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <input type="password" name="Konfirmasi_password" placeholder="Konfirmasi Password" required>
                </div>

                <!-- Tampilkan pesan error jika ada -->
                <?php if (!empty($message)): ?>
                    <p class="error-message"><?= htmlspecialchars($message); ?></p>
                <?php endif; ?>

                <button type="submit" class="btn">Daftar</button>
            </form>

            <div class="divider">Sudah punya akun?</div>
            <a href="masuk.php">
                <button class="btn btn-secondary">Masuk Sekarang</button>
            </a>
            <div class="footer">
                © 2024 JustBuy. Kelompok 5
            </div>
        </div>
    </div>
</body>
</html>
