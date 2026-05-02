<?php 
session_start(); 

$session_id  = session_id();
$customer_id = $_SESSION['customerId'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Cart</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />
</head>

<body>

  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="checkout.php">
          <i class="fas fa-money-check-alt mr-2"></i>Checkout
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cart.php">
          <i class="fas fa-shopping-cart"></i>
          <span id="cart-item" class="badge badge-danger"></span>
        </a>
      </li>
    </ul>
  </div>

  </nav>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">

        <div 
          style="display:<?php 
            if (isset($_SESSION['showAlert'])) {
              echo $_SESSION['showAlert'];
            } else {
              echo 'none';
            } 
            unset($_SESSION['showAlert']); 
          ?>" 
          class="alert alert-success alert-dismissible mt-3"
        >
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>
            <?php 
              if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
              } 
              unset($_SESSION['showAlert']); 
            ?>
          </strong>
        </div>

        <div class="table-responsive mt-2">
          <table class="table table-bordered table-striped text-center">
            
            <thead>
              <tr>
                <td colspan="7">
                  <h4 class="text-center text-info m-0">Products in your cart!</h4>
                </td>
              </tr>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>
                  <a 
                    href="action.php?clear=all" 
                    class="badge-danger badge p-1"
                    onclick="return confirm('Are you sure want to clear your cart?');"
                  >
                    <i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart
                  </a>
                </th>
              </tr>
            </thead>

            <tbody>

              <?php
                require 'includes/db_connect.php';

                $session_id = session_id();

                $stmt = $conn->prepare("
                  SELECT * FROM cart 
                  WHERE session_id = ? 
                  ");
                  $stmt->execute([session_id()]);
                  $grand_total = 0;

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
              ?>

              <tr>
                <td><?= $row['id'] ?></td>

                <input type="hidden" class="pid" value="<?= $row['id'] ?>">

                <td>
                  <img src="images/<?= $row['Item_Image'] ?>" width="50">
                </td>

                <td><?= $row['Item_Name'] ?></td>

                <td>
                  <span class="currency">Rs</span>
                  <?= number_format($row['Item_Price'], 2); ?>
                </td>

                <input type="hidden" class="pprice" value="<?= $row['Item_Price'] ?>">

                <td>
                  <input 
                    type="number" 
                    class="form-control itemQty" 
                    value="<?= $row['qty'] ?>" 
                    style="width:75px;"
                  >
                </td>

                <td>
                  <span class="currency">Rs</span>
                  <?= number_format($row['total_price'], 2); ?>
                </td>

                <td>
                  <a 
                    href="action.php?remove=<?= $row['id'] ?>" 
                    class="text-danger lead"
                    onclick="return confirm('Are you sure want to remove this item?');"
                  >
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>

              <?php 
                $grand_total += $row['total_price']; 
                endwhile; 
              ?>

              <tr>
                <td colspan="3">
                  <a href="home.php" class="btn btn-success">
                    <i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Continue Shopping
                  </a>
                </td>

                <td colspan="2"><b>Grand Total</b></td>

                <td>
                  <b>
                    <span class="currency">Rs</span>&nbsp;&nbsp;
                    <?= number_format($grand_total, 2); ?>
                  </b>
                </td>

                <td>
                  <a 
                    href="checkout.php" 
                    class="btn btn-info <?= ($grand_total > 1) ? '' : 'disabled'; ?>"
                  >
                    <i class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout
                  </a>
                </td>
              </tr>

            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {

      // Change the item quantity
          $(".itemQty").on('change', function() {
        var $el = $(this).closest('tr');
        var pid = $el.find(".pid").val();
        var qty = $(this).val();

        $.ajax({
          url: 'action.php',
          method: 'post',
          data: {
            action: 'add',
            Item_ID: pid,
            Item_Name: '',
            Item_Price: 0,
            qty: qty,
            Item_Image: ''
          },
          success: function() {
            location.reload();
          }
        });
      });

      // Load cart item count
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