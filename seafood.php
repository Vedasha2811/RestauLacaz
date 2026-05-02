<?php
session_start();
include 'includes/db_connect.php';

// PDO (correct way)
$sql = "SELECT * FROM Item WHERE Item_Type = 'seafood'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seafood</title>
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
        margin-top: 16px;
        font-size: 20px;
        font-weight: 700;
    }

    .price {
        font-size: 18px;
        margin: 10px 0;
    }

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

    /* HEADER */
    .header {
        background-color: #a05b3d;
        padding: 20px;
        font-size: 28px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        color: white;
    }

    .header .logo {
        width: 90px;
        position: absolute;
        left: 20px;
    }

    .checkout-box {
        position: absolute;
        right: 30px;
        text-align: center;
    }

    .checkout-box a {
        text-decoration: none;
        color: black;
        font-size: 20px;
        font-weight: 600;
    }

    .checkout-box img {
        width: 35px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<body>

<div class="header">
    <img src="images/logo.png" class="logo">

    <h1>Seafood</h1>

    <div class="checkout-box">
        <a href="cart.php">
            <img src="images/cart.png" alt="Cart">
            Checkout
        </a>
    </div>
</div>

<div class="container">

<?php
include 'includes/db_connect.php';


if (!empty($items)) {
    foreach ($items as $row) {

        $itemName  = htmlspecialchars($row['Item_Name']);
        $itemPrice = htmlspecialchars($row['Item_Price']);
        $itemImage = htmlspecialchars($row['Item_Image']);
        $itemID    = $row['Item_ID'];

        $imagePath = "images/" . $itemImage;

        echo "
        <div class='card'>
            <img src='{$imagePath}' alt='{$itemName}' class='item-img'>
            <h3 class='item-name'>{$itemName}</h3>
            <p class='price'>Rs {$itemPrice}</p>

            <div class='card-footer p-1'>
              <form action='' class='form-submit'>
                <div class='row p-2'>
                  <div class='col-md-6 py-1 pl-4'>
                    <b>Quantity : </b>
                  </div>
                  <div class='col-md-6'>
                    <input type='number' class='form-control pqty' value='1' min='1'>
                  </div>
                </div>

                <input type='hidden' class='pid' value='{$itemID}'>
                <input type='hidden' class='pname' value='{$itemName}'>
                <input type='hidden' class='pprice' value='{$itemPrice}'>
                <input type='hidden' class='pimage' value='{$itemImage}'>
                
                <button class='btn btn-info btn-block addItemBtn'>
                  <i class='fas fa-cart-plus'></i> Add to cart
                </button>
              </form>
            </div>
        </div>
        ";
    }
} else {
    echo "<p>No items found.</p>";
}

// Close connection (optional in PDO, but fine)
$conn = null;
?>

</div>


<!-- Displaying Products End -->

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Send product details in the server
    $(".addItemBtn").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pid = $form.find(".pid").val();
      var pname = $form.find(".pname").val();
      var pprice = $form.find(".pprice").val();
      var pimage = $form.find(".pimage").val();
    

      var pqty = $form.find(".pqty").val();

      $.ajax({
        url: 'action.php',
        method: 'post',
        data: {
        action: 'add',
        Item_ID: pid,
        Item_Name: pname,
        Item_Price: pprice,
        qty: pqty,
        Item_Image: pimage
        
        },
        success: function(response) {
          $("#message").html(response);
          window.scrollTo(0, 0);
          load_cart_item_number();
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

<?php include 'footer.php'; ?>

</body>
</html>
