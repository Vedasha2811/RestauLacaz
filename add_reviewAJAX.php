<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave a Review - RestauLakaz</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { margin: 0; font-family: Arial; background: #f5f5f5; }
        header { background:#a05b3d; display:flex; justify-content:space-between; padding:10px 30px; align-items:center; }
        header img { width:70px; }
        header nav a { margin-left:20px; text-decoration:none; font-weight:bold; color:black; }
        .form-container { width: 400px; margin: 60px auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; }
        label { font-weight: bold; }
        input, textarea, select { width: 100%; padding: 8px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #a05b3d; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>

<header>
    <a href="home.php"><img src="images/logo.png"></a>
    <nav>
        <a href="login.php">Login</a>
        <a href="signin.php">Create account</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="form-container">
    <h2>Leave Your Review</h2>
    <div id="response-msg" style="text-align:center; margin-bottom:10px; font-weight:bold;"></div>

    <form id="reviewForm">
        <label>Title:</label>
        <input type="text" id="title" required>

        <label>Comment:</label>
        <textarea id="comment" required></textarea>

        <label>Rating:</label>
        <select id="rating" required>
            <option value="5">⭐⭐⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="2">⭐⭐</option>
            <option value="1">⭐</option>
        </select>

        <label>Your Name:</label>
        <input type="text" id="name" required>

        <button type="submit">Submit Review</button>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#reviewForm').on('submit', function(e) {
        e.preventDefault();

        var reviewData = {
            title: $('#title').val(),
            comment: $('#comment').val(),
            rating: parseInt($('#rating').val()), 
            name: $('#name').val()
        };

        $.ajax({
            url: 'save_reviewJSON.php', 
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(reviewData),
            dataType: 'json',
            success: function(data) {
                if (data.status === "success") {
                    $('#response-msg').css('color', 'green').text(data.message + " Redirecting...");
                    $('#reviewForm')[0].reset();
                    setTimeout(function() { window.location.href = 'home.php'; }, 1000);
                } else {
                    $('#response-msg').css('color', 'red').text(data.message);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText); 
                $('#response-msg').css('color', 'red').text("Error: System issue.");
            }
        });
    });
});
</script>
</body>
</html>