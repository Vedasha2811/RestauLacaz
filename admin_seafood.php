<?php
include 'includes/db_connect.php';

// Fetch seafood items
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
body {
    font-family: Arial;
    background: #f4f4f4;
}

/* HEADER */
.header {
    background: #a05b3d;
    padding: 20px;
    text-align: center;
    color: white;
    font-size: 26px;
    font-weight: bold;
}

/* GRID */
.container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    padding: 30px;
}

/* CARD */
.card {
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.item-img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 10px;
}

.item-name {
    font-size: 18px;
    font-weight: bold;
    margin-top: 10px;
}

.price {
    margin: 10px 0;
}

/* FORM */
input {
    width: 80px;
    padding: 5px;
}

button {
    padding: 6px 10px;
    background: #a05b3d;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #7c432c;
}
</style>

<body>

<div class="header">Admin Panel - Seafood Items</div>

<div class="container">

<?php
foreach ($items as $row) {

    $itemID = $row['Item_ID'];
    $itemName = htmlspecialchars($row['Item_Name']);
    $itemPrice = htmlspecialchars($row['Item_Price']);
    $itemImage = htmlspecialchars($row['Item_Image']);
    $imagePath = "images/" . $itemImage;

    echo "
    <div class='card'>
        <img src='$imagePath' class='item-img'>

        <div class='item-name'>$itemName</div>
        <div class='price'>Current Price: Rs $itemPrice</div>

        <form action='update_price.php' method='POST'>
            <input type='hidden' name='item_id' value='$itemID'>

            New Price:
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