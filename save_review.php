<?php
$conn = new PDO("mysql:host=localhost;dbname=restaulakaz", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$title = $_POST['title'];
$comment = $_POST['comment'];
$rating = $_POST['rating'];
$name = $_POST['name'];
$date = date("Y-m-d");

$stmt = $conn->prepare("INSERT INTO reviews (title, comment, rating, name, date)
                        VALUES (?, ?, ?, ?, ?)");

$stmt->execute([$title, $comment, $rating, $name, $date]);

$conn = null;

header("Location: home.php");
?>