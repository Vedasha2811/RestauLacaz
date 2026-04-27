<?php
include 'includes/db_connect.php';

// Fetch italian items
$sql = "SELECT * FROM Item WHERE Item_Type = 'italian'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Italian</title>
</head>

<style>
body {
    font-family: Arial, sans-serif;
    background: #fff;
}

.container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 25px;
    padding: 20px 40px;
}

.card {
    background: #f5e7e3;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    text-align: left;
}

.item-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 12px;
}

.item-name {
    margin-top: 15px;
    font-size: 20px;
    font-weight: 700;
    color: #000;
}

.price {
    font-size: 18px;
    margin: 10px 0;
    font-weight: 500;
}

/* FIXED BUTTON (LEFT) */
.add-btn {
    padding: 7px 15px;
    border-radius: 10px;
    border: 1px solid #000;
    background: #fff;
    cursor: pointer;
}

.add-btn:hover {
    background: #000;
    color: #fff;
}

/* HEADER EXACT LIKE SALAD */
.header {
    background-color: #a05b3d;
    padding: 20px;
    font-size: 28px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.logo {
    width: 90px;
    position: absolute;
    left: 20px;
}

.top-right-images {
    position: absolute;
    right: 20px;
    top: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.img-top {
    width: 60px;
}

.img-bottom {
    width: 50px;
}
</style>

<body>

<!-- HEADER -->
<div class="header">
    <img src="images/logo.png" class="logo">
    <h1>Italian</h1>

    <div class="top-right-images">
        <a href="checkout.php">
            <img class="img-top" src="images/shopping_cart.png" alt="cart">
        </a>
        <a href="checkout.php">
            <img class="img-bottom" src="images/checkout.png" alt="checkout">
        </a>
    </div>
</div>

<div class="container">

<?php
if (!empty($items)) {
    foreach ($items as $row) {

        $itemName = htmlspecialchars($row['Item_Name']);
        $itemPrice = htmlspecialchars($row['Item_Price']);
        $itemImage = htmlspecialchars($row['Item_Image']);
        $itemID = $row['Item_ID'];

        $imagePath = "images/" . $itemImage;

        echo "
        <div class='card'>
            <img src='$imagePath' alt='$itemName' class='item-img'>
            <h3 class='item-name'>$itemName</h3>
            <p class='price'>Rs $itemPrice</p>

            <form action='add_to_cart.php' method='POST'>
                <input type='hidden' name='item_id' value='$itemID'>
                <button type='submit' class='add-btn'>Add To Cart</button>
            </form>
        </div>
        ";
    }
} else {
    echo "<p>No italian items found.</p>";
}

$conn = null;
?>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
