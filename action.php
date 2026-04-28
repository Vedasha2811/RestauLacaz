<?php
session_start();
require 'includes/db_connect.php';

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Add products into the cart table
if (isset($_POST['action']) && $_POST['action'] == 'add') {

    $pid    = $_POST['Item_ID'];     // Item_ID
    $pname  = $_POST['Item_Name'];   // Item_Name
    $pprice = $_POST['Item_Price'];  // Item_Price
    $pimage = $_POST['Item_Image'];  // Item_Image
    $pqty   = $_POST['qty'];    // qty

    $total_price = $pprice * $pqty;

    // Check if item already exists
    $stmt = $conn->prepare("SELECT * FROM cart WHERE Item_ID = ?");
    $stmt->execute([$pid]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Update quantity if already exists
        $newQty = $row['qty'] + $pqty;
        $newTotal = $newQty * $pprice;

        $update = $conn->prepare("
            UPDATE cart 
            SET qty = ?, total_price = ? 
            WHERE Item_ID = ?
        ");
        $update->execute([$newQty, $newTotal, $pid]);

        echo '<div class="alert alert-info mt-2">Quantity updated in cart!</div>';

    } else {
        // Insert new item
        $insert = $conn->prepare("
            INSERT INTO cart 
            (Item_ID, Item_Name, Item_Price, Item_Image, qty, total_price)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $insert->execute([
            $pid,
            $pname,
            $pprice,
            $pimage,
            $pqty,
            $total_price
        ]);

        echo '<div class="alert alert-success mt-2">Item added to cart!</div>';
    }
}


	// Get no.of items available in the cart table
if (isset($_GET['cartItem'])) {

    $stmt = $conn->query("SELECT COUNT(*) AS total FROM cart");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $result['total'];
}


// Remove single items from cart
if (isset($_GET['remove'])) {

    $id = $_GET['remove'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'Item removed from the cart!';
    header('Location: cart.php');
    
}


	// Remove all items at once from cart
if (isset($_GET['clear'])) {

    $conn->query("DELETE FROM cart");

    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'All items removed from the cart!';
    header('Location: cart.php');
    
}


// place order
if (isset($_POST['action']) && $_POST['action'] == 'order') {

    $region = $_POST['region'];
    $street = $_POST['street'];
    $phone  = $_POST['phone'];
    $pmode  = $_POST['pmode'];
    $grand_total = $_POST['grand_total'];

    $stmt = $conn->prepare("
        INSERT INTO orders 
        (Date, Time, Total_Amount, Order_Status, Region_Name, Street_Name, Phone, Customer_ID)
        VALUES (CURDATE(), CURTIME(), ?, 'Pending', ?, ?, ?, 0)
    ");

    $stmt->execute([$grand_total, $region, $street, $phone]);

    $data .= '<div class="text-center">
								<h1 class="display-4 mt-2 text-danger">Thank You!</h1>
								<h2 class="text-success">Your Order Placed Successfully!</h2>
								<h4 class="bg-danger text-light rounded p-2">Items Purchased : ' . $products . '</h4>
								<h4>Your Name : ' . $name . '</h4>
								<h4>Your E-mail : ' . $email . '</h4>
								<h4>Your Phone : ' . $phone . '</h4>
								<h4>Total Amount Paid : ' . number_format($grand_total,2) . '</h4>
								<h4>Payment Mode : ' . $pmode . '</h4>
						  </div>';

    
}
?>