<?php
session_start();
include 'includes/db_connect.php';

$itemID = $_POST['item_id'];

// fetch item from database
$sql = "SELECT * FROM item WHERE Item_ID = $itemID";
$result = $conn->query($sql);
$item = $result->fetch_assoc();

// Build cart item
$cartItem = [
    "name" => $item['Item_Name'],
    "price" => $item['Item_Price'],
    "quantity" => 1
];

// If cart exists, merge
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// If item exists, increase quantity
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

// Return to seafood page
header("Location: seafood.php");
exit();
