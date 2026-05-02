<?php
session_start();

$session_id = session_id();
$customer_id = $_SESSION['customerId'] ?? null;

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

        // Check if item already exists for this user
        $stmt = $conn->prepare("
        SELECT * FROM cart 
        WHERE Item_ID = ? AND session_id = ? AND Customer_ID = ?
         ");
    $stmt->execute([$pid, $session_id, $customer_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Update quantity if already exists
        $newQty = $row['qty'] + $pqty;
        $newTotal = $newQty * $pprice;

        $update = $conn->prepare("
            UPDATE cart 
            SET qty = ?, total_price = ?
            WHERE Item_ID = ? AND session_id = ? AND Customer_ID = ?
        ");
        $update->execute([$newQty, $newTotal, $pid, $session_id, $customer_id]);

        echo '<div class="alert alert-info">Quantity updated!</div>';

    } else {
        $insert = $conn->prepare("
            INSERT INTO cart 
            (session_id, Customer_ID, Item_ID, Item_Name, Item_Price, Item_Image, qty, total_price)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $insert->execute([
            $session_id,
            $customer_id,
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

    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM cart WHERE session_id=?");
    $stmt->execute([$session_id]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $result['total'];
}


// Remove single items from cart
if (isset($_GET['remove'])) {

    $session_id = $_GET['remove'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE session_id=?");
    $stmt->execute([$session_id]);

    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'Item removed from the cart!';
    header('Location: cart.php');
    
}


	// Remove all items at once from cart
if (isset($_GET['clear'])) {

    $stmt = $conn->prepare("DELETE FROM cart WHERE session_id=?");
    $stmt->execute([$session_id]);

    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'All items removed from the cart!';
    header('Location: cart.php');
    
}


// place order
if (isset($_POST['action']) && $_POST['action'] == 'order') {

    if (!isset($_SESSION['customerId'])) {
        echo "Please login first!";
        exit();
    }

    $region = $_POST['region'];
    $street = $_POST['street'];
    $phone  = $_POST['phone'];
    $pmode  = $_POST['pmode'];

    $grand_total = $_POST['grand_total']; // base amount
    $totalAmount = $grand_total + 200; // add extra fee

    $email  = $_POST['email'];
    $items = $_POST['items'];  

    $customer_id = $_SESSION['customerId'];
    $name = $_SESSION['firstName'] . " " . $_SESSION['lastName'];

    $stmt = $conn->prepare("
        INSERT INTO orders 
        (Date, Time, Total_Amount, Order_Status, Region_Name, Street_Name, Phone, Customer_ID)
        VALUES (CURDATE(), CURTIME(), ?, 'Pending', ?, ?, ?, ?)
    ");

    $stmt->execute([$totalAmount, $region, $street, $phone, $customer_id]);

    echo "
    <div class='alert alert-success'>
        <h4>Order Successful!</h4>
        <p><b>Items:</b> $items</p>
        <p><b>Name:</b> $name</p>
        <p><b>Email:</b> $email</p>
        <p><b>Total:</b> Rs ".number_format($totalAmount,2)."</p>
    </div>";
}
?>