<?php

session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: home.php"); // Arahkan ke halaman utama jika sudah login
    exit;
}

include 'KoneksiDatabase/config.php'; // Pastikan path benar

// Mulai session untuk menyimpan status login

// Jika sudah login, alihkan ke halaman utama
if (isset($_SESSION['user_id'])) {
    header("Location: home.php"); // Arahkan ke halaman utama jika sudah login
    exit;
}

$error_message = ""; // Variabel untuk pesan error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $phone_number = trim($_POST['phone_number']);
    $password = trim($_POST['password']);

    // Query untuk memeriksa pengguna
    $sql = "SELECT * FROM users WHERE nomor_telepon = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $phone_number);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verifikasi password
        if ($user && password_verify($password, $user['password'])) {
            // Login berhasil, simpan data ke session
            $_SESSION['user_id'] = $user['id']; // Simpan ID pengguna ke session
            $_SESSION['user_name'] = $user['nama']; // Simpan nama pengguna
            header("Location: home.php"); // Arahkan ke halaman utama
            exit;
        } else {
            // Login gagal, tampilkan pesan error
            $error_message = "Nomor atau kata sandi salah.";
        }

        $stmt->close();
    } else {
        $error_message = "Terjadi kesalahan pada server. Silakan coba lagi nanti.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JustBuy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="image/justbuy.png" type="image/png">
    <style>
        .error-message {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="logo">
                <span>J</span>ust<span>B</span>uy
            </div>
            <h1>Masuk</h1>
            <p>Masuk Menggunakan Akun Terdaftar Kamu.</p>

            <!-- Formulir Login -->
            <form action="" method="POST">
                <div class="input-group">
                    <input type="text" name="phone_number" placeholder="Nomor Handphone" required value="<?php echo isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : ''; ?>">
                </div>
                <div class="input-group" style="position: relative;">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="options">
                    <label>
                        <input type="checkbox" name="remember_me"> Ingatkan saya
                    </label>
                    <a href="#">Lupa Password</a>
                </div>
                <button type="submit" class="btn">Masuk</button>
            </form>

            <!-- Tampilkan pesan error jika ada -->
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
            <?php endif; ?>

            <div class="divider">Belum punya akun?</div>
            <a href="registrasi.php">
                <button class="btn btn-secondary">Daftar Sekarang</button>
            </a>
            <div class="footer">
                © 2024 JustBuy. Kelompok 5
            </div>
        </div>
    </div>

    <script>
        // Reset form setelah login atau saat form dimuat ulang
        window.onload = function() {
            <?php if (!empty($error_message)): ?>
                // Form akan tetap terisi jika login gagal, jika tidak gagal, form akan reset
                document.querySelector('form').reset();
            <?php endif; ?>
        };
    </script>
</body>
</html>
