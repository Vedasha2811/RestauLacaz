<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave a Review - RestauLakaz</title>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
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
        }

        header nav a {
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
            color: black;
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
            box-sizing: border-box;
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

        #message {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<header>
    <a href="home.php">
        <img src="images/logo.png" alt="Logo">
    </a>

    <nav>
        <a href="login.php">Login</a>
        <a href="signin.php">Create Account</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="form-container">
    <h2>Leave Your Review</h2>

    <form id="reviewForm">

        <label>Title:</label>
        <input type="text" name="title" id="title" required>

        <label>Comment:</label>
        <textarea name="comment" id="comment" required></textarea>

        <label>Rating:</label>
        <select name="rating" id="rating" required>
            <option value="">Select rating</option>
            <option value="5">⭐⭐⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="2">⭐⭐</option>
            <option value="1">⭐</option>
        </select>

        <label>Your Name:</label>
        <input type="text" name="name" id="name" required>

        <button type="submit">Submit Review</button>

    </form>

    <div id="message"></div>
</div>

<script>
$(document).ready(function(){

    $("#reviewForm").submit(function(e){
        e.preventDefault();

        let title = $("#title").val().trim();
        let comment = $("#comment").val().trim();
        let rating = $("#rating").val();
        let name = $("#name").val().trim();

        // Validation
        if(title === "" || comment === "" || rating === "" || name === ""){
            $("#message").html("All fields are required!").css("color", "red");
            return;
        }

        // AJAX Call
        $.ajax({
            url: "save_review.php",
            type: "POST",
            data: $(this).serialize(),

            success: function(response){
                $("#message").html(response).css("color", "green");
                $("#reviewForm")[0].reset();
            },

            error: function(){
                $("#message").html("Error submitting review.").css("color", "red");
            }
        });

    });

});
</script>

<?php include("footer.php"); ?>

</body>
</html>