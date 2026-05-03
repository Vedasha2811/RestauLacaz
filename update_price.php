<?php
session_start();

// 1. SECURITY: ONLY ADMIN
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Access denied");
}

// 2. DATABASE CONNECTION
$conn = new PDO("mysql:host=localhost;dbname=restaulakaz_database", "root", "");

$itemID = $_POST['item_id'];
$newPrice = $_POST['new_price'];

$stmt = $conn->prepare("UPDATE item SET Item_Price = :price WHERE Item_ID = :id");
$stmt->bindParam(':price', $newPrice);
$stmt->bindParam(':id', $itemID);
$stmt->execute();

header("Location: admin_seafood.php");
exit();
?>