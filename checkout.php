<?php
session_start();
include 'includes/db_connect.php';

$delivery = 200;
$grandTotal = 0;

// Calculate total
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $grandTotal += $item['price'] * $item['quantity'];
    }
}
$totalAmount = $grandTotal + $delivery;

// Date & time
$date = date('Y-m-d');
$time = date('H:i:s');

// Customer ID
$customerID = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;

// Process order
$error = "";
$success = false;

if (isset($_POST['pay'])) {
    $region = htmlspecialchars($_POST['region']);
    $street = htmlspecialchars($_POST['street']);
    $phone = htmlspecialchars($_POST['phone']);
    $orderStatus = "Pending";

    // Validate phone
    if (!preg_match('/^5\d{7}$/', $phone)) {
        $error = "Invalid phone number. Must be 8 digits starting with 5";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO orders 
            (Date, Time, Total_Amount, Order_Status, Region_Name, Street_Name, Phone, Customer_ID) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([
                $date,
                $time,
                $totalAmount,
                $orderStatus,
                $region,
                $street,
                $phone,
                $customerID
            ]);

            // Clear cart
            unset($_SESSION['cart']);
            $success = true;

        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout</title>

<style>
body { font-family: Arial; background: #f7f7f7; padding: 30px; }
.checkout-container { background: white; padding: 25px; width: 600px; margin: auto; border-radius: 10px; }
table { width: 100%; margin-bottom: 10px; }
th, td { padding: 10px; }
button { padding: 12px; background: #9c583a; color: white; border: none; border-radius: 20px; cursor: pointer; }
.error { color: red; text-align: center; }
.success { color: green; text-align: center; font-weight: bold; }
</style>

</head>
<body>

<div class="checkout-container">
<h2>Checkout</h2>

<table>
<tr>
<th>Item</th>
<th>Qty</th>
<th>Price</th>
<th>Total</th>
</tr>

<?php
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total = $item['price'] * $item['quantity'];
        echo "<tr>
            <td>{$item['name']}</td>
            <td>{$item['quantity']}</td>
            <td>Rs {$item['price']}</td>
            <td>Rs $total</td>
        </tr>";
    }
}
?>
</table>

<p><b>Total: Rs <?php echo $totalAmount; ?></b></p>

<?php if ($error): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p class="success">✔ Order placed successfully!</p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="region" placeholder="Region" required><br><br>
    <input type="text" name="street" placeholder="Street" required><br><br>
    <input type="text" name="phone" placeholder="Phone (5xxxxxxx)" required><br><br>

    <button type="submit" name="pay">Pay</button>
</form>

</div>

</body>
</html>
