<?php
session_start();

// ONLY ADMIN
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Access denied");
}

include 'includes/db_connect.php';

$itemID = $_POST['item_id'];
$newPrice = $_POST['new_price'];

$stmt = $conn->prepare("UPDATE Item SET Item_Price = ? WHERE Item_ID = ?");
$stmt->execute([$newPrice, $itemID]);

$conn = null;

header("Location: admin_seafood.php");
exit();
?>
