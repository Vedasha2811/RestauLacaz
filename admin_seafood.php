<?php
session_start();

// BLOCK NON-ADMIN
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: seafood.php");
    exit();
}

include 'includes/db_connect.php';

// FETCH ITEMS
$sql = "SELECT * FROM Item WHERE Item_Type = 'seafood'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Seafood</title>
</head>

<style>
body { font-family: Arial; background: #f4f4f4; }

.header {
    background: #a05b3d;
    padding: 20px;
    text-align: center;
    color: white;
    font-size: 26px;
    font-weight: bold;
}

.container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    padding: 30px;
}

.card {
    background: #fff;
    padding: 15px;
    border-radius: 10px;
}

.item-img {
    width: 100%;
    height: 160px;
    object-fit: cover;
}

input {
    width: 80px;
    padding: 5px;
}

button {
    padding: 6px 10px;
    background: #a05b3d;
    color: white;
    border: none;
}
</style>

<body>

<div class="header">Admin Panel - Seafood</div>

<div class="container">

<?php
foreach ($items as $row) {

    $itemID = $row['Item_ID'];
    $name = htmlspecialchars($row['Item_Name']);
    $price = htmlspecialchars($row['Item_Price']);
    $img = "images/" . $row['Item_Image'];

    echo "
    <div class='card'>
        <img src='$img' class='item-img'>
        <h3>$name</h3>
        <p>Current Price: Rs $price</p>

        <form action='update_price.php' method='POST'>
            <input type='hidden' name='item_id' value='$itemID'>
            <input type='number' name='new_price' required>
            <button type='submit'>Update</button>
        </form>
    </div>
    ";
}
?>

</div>

</body>
</html>
