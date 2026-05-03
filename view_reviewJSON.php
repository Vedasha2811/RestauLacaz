<?php
// Tell the browser to display this as a JSON file
header('Content-Type: application/json');

$conn = new PDO("mysql:host=localhost;dbname=restaulakaz_database", "root", "");

// Fetch all data from the reviews table
$stmt = $conn->query("SELECT * FROM reviews ORDER BY id DESC");
$allReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the JSON Array
echo json_encode($allReviews, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
?>