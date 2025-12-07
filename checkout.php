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

// Current date and time for the order
$date = date('Y-m-d');
$time = date('H:i:s');
 // login customer ID
$customerID = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout</title>
<style>
body { font-family: Arial, sans-serif; background: #f7f7f7; padding: 30px; }
.checkout-container { background: white; padding: 25px; width: 600px; margin: auto; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
h2 { margin-bottom: 20px; }
table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
table th, table td { text-align: left; padding: 10px 0; }
.total-line { text-align: center; font-size: 18px; margin: 20px 0; }
.section-title { margin-top: 25px; font-weight: bold; }
input, select { width: 48%; padding: 10px; margin: 5px 1%; border: 1px solid #ccc; border-radius: 8px; font-size: 14px; }
.full-width { width: 98%; }
button { width: 200px; margin: 20px auto; display: block; padding: 12px; background: #9c583a; color: white; border: none; border-radius: 20px; font-size: 16px; cursor: pointer; }
button:hover { background: #7f462f; }

/*popup */
#popup { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; justify-content: center; align-items: center; }
.popup-box { background: white; padding: 30px 40px; border-radius: 12px; text-align: center; width: 350px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); animation: popup-zoom 0.3s ease; }
@keyframes popup-zoom { 0% { transform: scale(0.5); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
.popup-box h3 { margin-bottom: 10px; font-size: 22px; }
.popup-box p { font-size: 16px; margin-bottom: 20px; }
.close-btn { background: #9c583a; padding: 10px 30px; color: white; border-radius: 20px; cursor: pointer; border: none; }
.close-btn:hover { background: #7f462f; }
.error { color: red; margin: 10px 0; text-align: center; }
</style>
</head>
<body>

<div class="checkout-container">

    <h2>Checkout</h2>

    <!-- Order Summary -->
    <table>
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>

        <?php
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $total = $item['quantity'] * $item['price'];
                echo "
                <tr>
                    <td>{$item['name']}</td>
                    <td>{$item['quantity']}</td>
                    <td>Rs {$item['price']}</td>
                    <td>Rs $total</td>
                </tr>
                ";
            }
        }
        ?>
    </table>

    <div class='total-line'>
        Grand Total: Rs <?php echo $grandTotal; ?>
        + Rs <?php echo $delivery; ?> Delivery =
        <b>Rs <?php echo $totalAmount; ?></b>
    </div>

    <!-- Checkout Form -->
    <form method="POST" action="checkout.php" onsubmit="return validatePhone()">
        <div class="section-title">Delivery Information</div>
        <input type="text" name="region" placeholder="Enter your region" required>
        <input type="text" name="street" placeholder="Enter your street name" required><br>
        <input type="text" name="phone" id="phone" placeholder="Enter your phone number" class="full-width" required>
        <div id="phone-error" class="error"></div>

        <div class="section-title">Payment</div>
        <select name="payment_method" class="full-width">
            <option>CASH</option>
        </select>

        <button type="submit" name="pay">Pay</button>
    </form>

</div>

<!-- Success Popup -->
<div id="popup">
    <div class="popup-box">
        <h3>Payment Successful ✔</h3>
        <p>Your order has been confirmed.<br>Thank you for choosing us!</p>
        <button class="close-btn" onclick="closePopup()">Close</button>
    </div>
</div>

<script>
// Client-side validation: 8 digits, starts with 5
function validatePhone() {
    var phoneInput = document.getElementById('phone');
    var phone = phoneInput.value.trim();

    // Remove non-digit characters
    phone = phone.replace(/\D/g, '');
    phoneInput.value = phone;

    var regex = /^5\d{7}$/;
    if (!regex.test(phone)) {
        document.getElementById('phone-error').innerText = "Invalid phone number. Must be 8 digits starting with 5";
        return false;
    }
    document.getElementById('phone-error').innerText = "";
    return true;
}

function showPopup() {
    document.getElementById("popup").style.display = "flex";
}
function closePopup() {
    document.getElementById("popup").style.display = "none";
}
</script>

<?php
// Process order if form submitted /XSS
if (isset($_POST['pay'])) {
    $region = htmlspecialchars($_POST['region']);
    $street = htmlspecialchars($_POST['street']);
    $phone = htmlspecialchars($_POST['phone']);
    $orderStatus = "Pending";

    // Server-side validation: 8 digits, starts with 5
    if (!preg_match('/^5\d{7}$/', $phone)) {
        echo "<p class='error'>Invalid phone number. Must be 8 digits starting with 5</p>";
    } else {
        // Insert into database/ sql injection(prepare statement)
        $stmt = $conn->prepare("INSERT INTO orders (Date, Time, Total_Amount, Order_Status, Region_Name, Street_Name, Phone, Customer_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssii", $date, $time, $totalAmount, $orderStatus, $region, $street, $phone, $customerID);

        if ($stmt->execute()) {
            // Clear cart
            unset($_SESSION['cart']);

            // Show success popup
            echo "<script>showPopup();</script>";
        } else {
            echo "<p class='error'>Error: " . $stmt->error . "</p>";
        }
    }
}
$conn->close();
?>

</body>
</html>
