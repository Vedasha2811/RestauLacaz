<?php

// Database Connection
$conn = new PDO("mysql:host=localhost;dbname=restaulakaz_database", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize Inputs
    $title = htmlspecialchars(trim($_POST['title']));
    $comment = htmlspecialchars(trim($_POST['comment']));
    $rating = htmlspecialchars(trim($_POST['rating']));
    $name = htmlspecialchars(trim($_POST['name']));
    $date = date("Y-m-d");

    // Validate Empty Fields
    if(empty($title) || empty($comment) || empty($rating) || empty($name)){
        echo "All fields are required!";
        exit();
    }

    // Insert Review into Database
    $stmt = $conn->prepare("INSERT INTO reviews (title, comment, rating, name, date) 
                            VALUES (?, ?, ?, ?, ?)");

    if($stmt->execute([$title, $comment, $rating, $name, $date])){
        echo "Review submitted successfully!";
    } else {
        echo "Failed to submit review.";
    }

}

// Close Connection
$conn = null;

?>
