<?php
session_start();
include 'includes/db_connect.php';

$itemID = $_POST['item_id'];

// Use prepared statement (SECURITY)
$stmt = $conn->prepare("SELECT * FROM item WHERE Item_ID = ?");
$stmt->execute([$itemID]);

$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die("Item not found");
}

// Build cart item
$cartItem = [
    "name" => $item['Item_Name'],
    "price" => $item['Item_Price'],
    "quantity" => 1
];

// Init cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if item exists
$found = false;
foreach ($_SESSION['cart'] as &$c) {
    if ($c['name'] == $cartItem['name']) {
        $c['quantity']++;
        $found = true;
        break;
    }
}

if (!$found) {
    $_SESSION['cart'][] = $cartItem;
}

// Redirect
header("Location: seafood.php");
exit();
