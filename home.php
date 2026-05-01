<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>RestauLakaz - Home</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: #f5f5f5;
}

/* HEADER */
header {
    background: #a05b3d;
    display: flex;
    justify-content: space-between;
    padding: 10px 30px;
    align-items: center;
}

header img {
    width: 70px;
}

header nav a {
    margin-left: 20px;
    text-decoration: none;
    font-weight: bold;
    color: black;
}

/* HERO */
.hero {
    background-image: url('images/home background.jpg');
    background-size: cover;
    background-position: center;
    height: 380px;
    color: white;
    padding: 120px 40px;
}

/* TITLE */
.section-title {
    font-size: 25px;
    margin: 40px;
    font-weight: bold;
    text-decoration: underline;
}

/* CATEGORY GRID (BIG STYLE RESTORED) */
.category-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
    padding: 0 40px;
    justify-items: center;
}

/* CLICKABLE CATEGORY */
.category {
    text-align: center;
    text-decoration: none;
    color: black;
}

.category img {
    width: 250px;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
    transition: 0.3s ease;
}

.category img:hover {
    transform: scale(1.05);
}

.category p {
    font-size: 18px;
    margin-top: 8px;
}

/* REVIEWS */
.reviews {
    margin: 40px;
}

.reviews h2 a {
    text-decoration: none;
    color: black;
}

.review-cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

/* REVIEW CARD */
.card {
    width: 220px;
    padding: 15px;
    border-radius: 15px;

    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);

    border: 1px solid rgba(255,255,255,0.3);
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);

    transition: 0.3s ease;
}

/* HOVER POP EFFECT */
.card:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 25px rgba(0,0,0,0.25);
}

.card h3 {
    font-size: 16px;
}

.card small {
    color: gray;
}

</style>
</head>

<body>

<header>
<a href="home.php">
    <img src="images/logo.png">
</a>

<nav>
<a href="login.php">Login</a>
<a href="signin.php">Create account</a>
<a href="logout.php">Logout</a>
</nav>
</header>

<div class="hero">
<h1>RestauLakaz</h1>
<p>We Deliver For You</p>
</div>

<div class="section-title">Food Categories</div>

<!-- ✅ CLICKABLE CATEGORIES FIXED -->
<div class="category-container">

<a href="italian.php" class="category">
    <img src="images/Italian.jpg">
    <p>Italian</p>
</a>

<a href="indian.php" class="category">
    <img src="images/Indian.jpg">
    <p>Indian</p>
</a>

<a href="chinese.php" class="category">
    <img src="images/chinese.jpg">
    <p>Chinese</p>
</a>

<a href="seafood.php" class="category">
    <img src="images/seafood.jpg">
    <p>Seafood</p>
</a>

<a href="fastfood.php" class="category">
    <img src="images/fastfood.jpg">
    <p>Fast Food</p>
</a>

<a href="salad.php" class="category">
    <img src="images/salad.jpg">
    <p>Salad</p>
</a>

<a href="drinks.php" class="category">
    <img src="images/drinks.jpg">
    <p>Drinks</p>
</a>

<a href="dessert.php" class="category">
    <img src="images/dessert.jpg">
    <p>Dessert</p>
</a>

</div>

<!-- REVIEWS -->
<div class="reviews">

<h2>
<a href="add_review.php">Review (click me to Add review)</a>
</h2>

<div class="review-cards">

<!-- STATIC -->
<div class="card">
⭐⭐⭐⭐⭐
<h3>Quick delivery</h3>
<p>On time service</p>
<small>– Anwar<br>25.09.25</small>
</div>

<div class="card">
⭐⭐⭐⭐⭐
<h3>Great food</h3>
<p>Very tasty meals</p>
<small>– Vedasha<br>15.10.25</small>
</div>

<!-- DYNAMIC -->
<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=restaulakaz_database", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT * FROM reviews ORDER BY id DESC");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        echo "<div class='card'>";

        for ($i = 1; $i <= $row['rating']; $i++) {
            echo "⭐";
        }

        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['comment']) . "</p>";
        echo "<small>– " . htmlspecialchars($row['name']) . "<br>" . htmlspecialchars($row['date']) . "</small>";

        echo "</div>";
    }

} catch (PDOException $e) {
    echo "<p>Error loading reviews</p>";
}
?>

</div>
</div>

<?php include("footer.php"); ?>

</body>
</html>