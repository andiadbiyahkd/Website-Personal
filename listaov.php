<?php
$conn = new mysqli("localhost", "root", "", "justbuydb");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM akun";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Produk</title>
    <link rel="stylesheet" href="liststyle.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background: url('image/Benedetta.jpeg') no-repeat center center fixed;
            background-size: cover;
        }
        .filters {
            margin-bottom: 20px;
        }
        .filters button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }
        .filters button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <header>
        <button class="back-button" onclick="goToHome()">Back to Home</button>
        <h1>Daftar Produk di <span class="blue">J</span>ust<span class="blue">B</span>uy</h1>
    </header>
    
    <div class="slideshow-container">
        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
        <div class="slideshow" id="slideshow">
            <img src="image/aov.jpeg" alt="Slide 1" class="slide">
            <img src="image/aov1.jpeg" alt="Slide 2" class="slide">
            <img src="image/aov2.jpeg" alt="Slide 3" class="slide">
            <img src="image/aov3.jpeg" alt="Slide 4" class="slide">
            <img src="image/aov4.jpeg" alt="Slide 5" class="slide">
        </div>
        <button class="next" onclick="moveSlide(1)">&#10095;</button>
    </div>

    <div class="filters">
        <button onclick="sortList('skin')">Jumlah Skin</button>
        <button onclick="sortList('level')">Level</button>
        <button onclick="sortList('price')">Harga</button>
    </div>
    <div id="product-list">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Ambil nomor WhatsApp dari database
            $nomorWa = $row['nomor_wa'];
            echo '
            <div class="container" data-skin="' . $row['skin'] . '" data-level="' . $row['level'] . '" data-price="' . $row['price'] . '">
                <div class="image-gallery">
                    <img src="ADMIN/admin/gambarAkunAov/' . basename($row['preview_image']) . '" alt="Screenshot ' . $row['id'] . '" width="200">
                </div>
                <div class="product-details">
                    <h2>Produk Dari: ' . $row['penjual'] . '</h2>
                    <p>Jumlah Skin: ' . $row['skin'] . '</p>
                    <p>Jumlah Hero:'.$row['hero']. '</p>
                    <p>Level: ' . $row['level'] . '</p>
                    <p>Harga: Rp ' . number_format($row['price'], 2, ',', '.') . '</p>
                    <p>Deskripsi: ' . $row['deskripsi'] . '</p>
                    <!-- Tombol beli mengarahkan ke WhatsApp dengan nomor yang diambil dari database -->
                    <button class="buy-button" onclick="redirectToWhatsApp(\'' . $nomorWa . '\', \'Saya ingin membeli produk ini!\')">Beli</button>
                </div>
            </div>';
        }
    } else {
        echo "<p>Belum ada produk yang tersedia.</p>";
    }
    ?>
</div>

    <script>
        let currentIndex = 0;
        const slides = document.querySelectorAll('.slideshow .slide');
        const totalSlides = slides.length;

        function moveSlide(direction) {
            currentIndex += direction;
            if (currentIndex < 0) {
                currentIndex = totalSlides - 1;
            } else if (currentIndex >= totalSlides) {
                currentIndex = 0;
            }

            updateSlideVisibility();
        }

        function updateSlideVisibility() {
            slides.forEach((slide, index) => {
                if (index === currentIndex) {
                    slide.style.display = 'block';
                } else {
                    slide.style.display = 'none';
                }
            });
        }

        updateSlideVisibility();

        function sortList(criteria) {
            const products = [...document.querySelectorAll('.container')];
            const productList = document.getElementById('product-list');

            // Ascending order toggle
            const order = sortOrder[criteria];
            const isAscending = order === 'asc';

            products.sort((a, b) => {
                const valA = parseFloat(a.dataset[criteria]);
                const valB = parseFloat(b.dataset[criteria]);

                if (isAscending) return valA - valB;
                return valB - valA;
            });

            productList.innerHTML = '';
            products.forEach(product => productList.appendChild(product));

            sortOrder[criteria] = isAscending ? 'desc' : 'asc';
        }

        const sortOrder = {
            skin: 'asc',
            level: 'asc',
            price: 'asc',
        };

        function redirectToWhatsApp(phoneNumber, message) {
            const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
            window.open(url, '_blank');
        }

        function goToHome() {
            window.location.href = 'home.php';
        }
    </script>

    <footer class="footer">
        © 2024 JustBuy. Kelompok 5.
    </footer>
</body>

</html>

<?php
$conn->close();
?>
