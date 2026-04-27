<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave a Review - RestauLakaz</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f5f5f5;
        }

        header {
            background:#a05b3d;
            display:flex;
            justify-content:space-between;
            padding:10px 30px;
            align-items:center;
        }

        header img { width:70px; }

        header nav a {
            margin-left:20px;
            text-decoration:none;
            font-weight:bold;
            color:black;
        }

        .form-container {
            width: 400px;
            margin: 60px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #a05b3d;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #8a4d33;
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

<div class="form-container">
    <h2>Leave Your Review</h2>

    <form action="save_review.php" method="POST">

        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Comment:</label>
        <textarea name="comment" required></textarea>

        <label>Rating:</label>
        <select name="rating" required>
            <option value="">Select rating</option>
            <option value="5">⭐⭐⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="2">⭐⭐</option>
            <option value="1">⭐</option>
        </select>

        <label>Your Name:</label>
        <input type="text" name="name" required>

        <button type="submit">Submit Review</button>

    </form>
</div>

<?php include("footer.php"); ?>

</body>
</html>