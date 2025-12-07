<?php
include 'includes/db_connect.php'; 

// Fetch only salads
$sql = "SELECT * FROM Item WHERE Item_Type = 'salad'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Salads</title>
</head>

<style>
    body {
    font-family: Arial, sans-serif;
    background: #fff;
}

.title {
    text-align: center;
    font-size: 40px;
    margin-top: 20px;
    color: #3a1f14;
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

.add-btn {
    padding: 7px 15px;
    border-radius: 10px;
    border: 1px solid #000;
    background: #fff;
    cursor: pointer;
    float: right;
}

.add-btn:hover {
    background: #000;
    color: #fff;
}

.header {
    background-color: #a05b3d;;
    padding: 20px;
    text-align: center;
    font-size: 28px;
    font-weight: bold;
    position: relative;
    display: flex;    
}

.logo {
    width: 90px;
    height: auto;
}  

.top-right-images {
    position: fixed;
    top: 0;
    right: 0;
    display: flex;
    flex-direction: column;  
    align-items: flex-end;                  
    padding: 10px;
}

.img-top {
    width: 100px;  
    height: auto;
}

.img-bottom {
    width: 60px;    
    height: auto;
}

</style>

<body>

   <div class="header">
        <img src="images/logo.png" class="logo">
        <h1>Salads</h1>

        <div class="top-right-images">
            <a href="checkout.php">
            <img class="img-top" src="images/shopping_cart.png" alt="shopping cart">
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
            // Sanitize output to prevent XSS
            $itemName = htmlspecialchars($row['Item_Name']);
            $itemPrice = htmlspecialchars($row['Item_Price']);
            $itemImage = htmlspecialchars($row['Item_Image']);
            
            $imagePath = "images/" . $itemImage;

            echo "
            <div class='card'>
                <img src='$imagePath' alt='$itemName' class='item-img'>
                <h3 class='item-name'>$itemName</h3>
                <p class='price'>Rs $itemPrice</p>
                <button class='add-btn'>Add To Cart</button>
            </div>
            ";
        }
    } else {
        echo "<p>No salads found.</p>";
    }

    $conn = null;
    ?>

</div>


<?php include 'footer.php'; ?>

</body>
</html>
