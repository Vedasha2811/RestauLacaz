<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RestauLakaz - Home</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #ffffff;
        }

        header {
            background: #a05b3d;
            display: flex;
            justify-content: space-between;
            padding: 10px 30px;
            align-items: center;
        }
        header img {
            width: 70px;
            cursor: pointer;
        }
        header nav a {
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
            color: black;
        }

        .hero {
            background-image: url('images/home background.jpg');
            background-size: cover;
            background-position: center;
            height: 380px;
            color: white;
            padding: 120px 40px;
        }
        .hero h1 {
            font-size: 45px;
            font-weight: bold;
        }
        .hero p {
            font-size: 20px;
            margin: 5px 0;
        }

        .section-title {
            font-size: 25px;
            margin: 40px 0 20px 40px;
            font-weight: bold;
            text-decoration: underline;
        }
        .category-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            justify-items: center;
            padding: 0 40px;
        }
        .category {
            text-align: center;
        }
        .category img {
            width: 250px;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }
        .category p {
            margin-top: 8px;
            font-size: 18px;
        }

        .reviews {
            margin: 40px 40px;
        }
        .reviews h2 {
            font-size: 22px;
            font-weight: bold;
            text-decoration: underline;
        }
        .review-cards {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            width: 220px;
        }
        .card h3 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        .card small {
            color: gray;
        }
    </style>
</head>

<body>

<header>
    <a href="home.php">
        <img src="images/logo.png" alt="RestauLakaz Logo">
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
    <p>Kan nu la zero traka Pas bouZ nou vin kiT</p>
</div>

<div class="section-title">Food Categories</div>

<div class="category-container">

    <div class="category">
        <a href="italian.php">
            <img src="images/Italian.jpg">
             <p>Italian</p>
        </a>
    </div>

    <div class="category">
        <a href="indian.php">
            <img src="images/Indian.jpg">
            <p>Indian</p>
        </a>
    </div>

    <div class="category">
        <a href="chinese.php">
            <img src="images/chinese.jpg">
            <p>Chinese</p>
        </a>
    </div>

    <div class="category">
        <a href="seafood.php">
            <img src="images/seafood.jpg">
            <p>Seafood</p>
        </a>
    </div>

    <div class="category">
        <a href="fastfood.php">
            <img src="images/fastfood.jpg">
            <p>Fast Food</p>
        </a>
    </div>

    <div class="category">
        <a href = "salad.php">
            <img src="images/salad.jpg">
            <p>Salad</p>
        </a>
       
    </div>

    <div class="category">
        <a href = "drinks.php">
            <img src="images/drinks.jpg">
            <p>Drinks</p>
        </a>
    </div>

    <div class="category">
        <a href = "dessert.php">
            <img src="images/dessert.jpg">
            <p>Dessert</p>
        </a>
    </div>

</div>

<div class="reviews">
    <h2>Review</h2>

    <div class="review-cards">

        <div class="card">
            ⭐⭐⭐⭐⭐
            <h3>Quick delivery</h3>
            <p>The delivery was on time</p>
            <small>– Anwar Chuttoo<br>25.09.25</small>
        </div>

        <div class="card">
            ⭐⭐⭐⭐⭐
            <h3>Good customer service</h3>
            <p>The food was delicious and nicely packed</p>
            <small>– Vedasha<br>15.10.25</small>
        </div>

        <div class="card">
            ⭐⭐⭐⭐☆
            <h3>Review title</h3>
            <p>Review body</p>
            <small>Reviewer name<br>Date</small>
        </div>

        <div class="card">
            ⭐⭐⭐⭐☆
            <h3>Review title</h3>
            <p>Review body</p>
            <small>Reviewer name<br>Date</small>
        </div>

    </div>
</div>

<?php include("footer.php"); ?>

</body>
</html>
