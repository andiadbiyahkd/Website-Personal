<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Game List */
        .game-list {
            padding: 5%;
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
    </style>
</head>

<body>
    <!-- Game List -->
    <div class="game-list">
        <h2>DashBoard</h2>
        <div class="game-category">
            <h3>MOBA</h3>
            <a href="ADMIN/tambahAkunml.php">
                <div class="game-item moba1">
                    <div class="text">
                        <p>Mobile Legend</p>
                    </div>
                </div>
            </a>
            <a href="ADMIN/tambahAkunaov.php">
                <div class="game-item moba2">
                    <div class="text">
                        <p>Arena Of Valor</p>
                    </div>
                </div>
            </a>
            <a href="ADMIN/tambahAkunwr.php">
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
            <a href="listvalo.html">
                <div class="game-item shooter3">
                    <div class="text">
                        <p>Valorant</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</body>

</html>
