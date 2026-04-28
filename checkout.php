<?php
require 'includes/db_connect.php';

$grand_total = 0;
$allItems = '';
$items = [];

$sql = "SELECT Item_Name, qty, Item_Price, total_price FROM cart";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$cart_items = [];

foreach ($result as $row) {
  $grand_total += $row['total_price'];
  $cart_items[] = $row;
  $items[] = $row['Item_Name'] . "(" . $row['qty'] . ")";
}

$allItems = implode(', ', $items);
$delivery = 200;
$totalAmount = $grand_total + $delivery;
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
.error { color: red; margin: 10px 0; text-align: center; }
</style>

</head>
<body>

<div class="checkout-container">
<div id="order"></div>a
<h2>Checkout</h2>

<!-- Order Summary -->
<table>
<tr>
<th>Item</th>
<th>Quantity</th>
<th>Price</th>
<th>Total</th>
</tr>

<?php foreach ($cart_items as $item): ?>
<tr>
<td><?= $item['Item_Name'] ?></td>
<td><?= $item['qty'] ?></td>
<td>Rs <?= $item['Item_Price'] ?></td>
<td>Rs <?= $item['total_price'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<div class="total-line">
Grand Total: Rs <?= $grand_total; ?>
+ Rs <?= $delivery; ?> Delivery =
<b>Rs <?= $totalAmount; ?></b>
</div>

<!-- Checkout Form -->
<form id="placeOrder">

<input type="hidden" name="products" value="<?= $allItems; ?>">
<input type="hidden" name="grand_total" value="<?= $grand_total; ?>">

<div class="section-title">Delivery Information</div>
<input type="text" name="name" placeholder="Full Name" required>
<input type="text" name="region" placeholder="Region" required><br>
<input type="text" name="street" placeholder="Street Address" required>
<input type="email" name="email" placeholder="Email" required><br>
<input type="text" name="phone" id="phone" placeholder="Phone Number" class="full-width" required>

<div id="phone-error" class="error"></div>

<div class="section-title">Payment</div>
<select name="pmode" class="full-width">
<option value="cod">Cash on Delivery</option>
<option value="netbanking">Net Banking</option>
<option value="cards">Card</option>
</select>

<button type="submit" id = "placeOrder">Place Order</button>

</form>

</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Sending Form data to the server
    $("#placeOrder").submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: 'action.php',
        method: 'post',
        data: $('form').serialize() + "&action=order",
        success: function(response) {
          $("#order").html(response);
        }
      });
    });

    // Load total no.of items added in the cart and display in the navbar
    load_cart_item_number();

    function load_cart_item_number() {
      $.ajax({
        url: 'action.php',
        method: 'get',
        data: {
          cartItem: "cart_item"
        },
        success: function(response) {
          $("#cart-item").html(response);
        }
      });
    }
  });
  </script>

</body>
</html>