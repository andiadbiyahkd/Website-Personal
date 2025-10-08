<?php
if (isset($_GET['penjual'])) {
    $penjual = $_GET['penjual'];
} else {
    echo "Penjual tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review - <?php echo htmlspecialchars($penjual); ?></title>
</head>
<body>
    <h1>Berikan Review untuk <?php echo htmlspecialchars($penjual); ?></h1>
    <form action="submit_review.php" method="POST">
        <label for="rating">Rating (1-5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>
        <br>
        <label for="review">Review:</label>
        <textarea id="review" name="review" required></textarea>
        <br>
        <input type="hidden" name="penjual" value="<?php echo htmlspecialchars($penjual); ?>">
        <button type="submit">Submit Review</button>
    </form>
</body>
</html>
