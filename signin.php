<?php
session_start();

$firstnameErr = $lastnameErr = $emailErr = $passwordErr = "";
$firstname = $lastname = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["txt_firstname"])) {
    $firstnameErr = "First name is required";
  } else {
    $firstname = ($_POST["txt_firstname"]);
  }


  if (empty($_POST["txt_lastname"])) {
    $lastnameErr = "Last name is required";
  } else {
    $lastname = ($_POST["txt_lastname"]);
  }

  if (empty($_POST["txt_email"])) {
    $emailErr = "Email is required";
  } else {
    $email = trim($_POST["txt_email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }


  if (empty($_POST["txt_password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = trim($_POST["txt_password"]);
  }

  if ($firstnameErr == "" && $lastnameErr == "" && $emailErr == "" && $passwordErr == "") 
{
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    require_once "includes/db_connect.php";
    $stmt = $conn->prepare("
        INSERT INTO customer (firstname, lastname, email, password)
        VALUES (:firstname, :lastname, :email, :password)
    ");


    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    
    if ($stmt->execute()) {
        echo "Success!";
    } else {
        echo "ERROR: Could not save credentials!";
    }
}

  


}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .left {
            width: 50%;
        }

        .left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .right {
            width: 50%;
            padding: 50px 80px;
            position: relative;
        }

        .login-btn {
            position: absolute;
            right: 60px;
            top: 20px;
            padding: 10px 30px;
            background: #9b4d37;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
        }

        .row {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            margin-top: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 25px;
            font-size: 16px;
        }

        .submit-btn {
            width: 100%;
            margin-top: 30px;
            padding: 12px;
            background: #9b4d37;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
        }

        .input-group {
        width: 100%;
        }

        .input-group label {
        display: block;
        margin: 0 0 5px 0;  
        padding: 0;         
        text-align: left;   
        font-weight: bold;
        }

    </style>
</head>

<body>

<?php
 $activemenu = "signin";
 include('includes/menu.php');
 ?>

<div class="container">

    <div class="left">
        <img src="images/burger.png" alt="Side Image">
    </div>

    <div class="right">
        <a href="login.php"><button class="login-btn">Log in</button></a>
        
        <?php
         if(isset($_SESSION['username']))
        { 
            echo "<h3 style=\"color:red\">You are already logged in</h3>";
        }
        else
        {	  
        ?>
        <h1>Create An Account</h1>

         <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>"  >
         
        <div class="row">
            <div class="input-group">
                <label for="firstname">First Name</label>
                <input type="text" name="txt_firstname" placeholder="First Name" maxlength="30" required>
                <span class="error">* <?php echo $firstnameErr; ?></span><br><br>
            </div>

            <div class="input-group">
                <label for="lastname">Last Name</label>
                <input type="text" name="txt_lastname" placeholder="Last Name" required>
                <span class="error">* <?php echo $lastnameErr; ?></span>
            </div>
        </div>
    
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="txt_email" placeholder="Email" required>
            <span class="error">* <?php echo $emailErr; ?></span><br><br>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="txt_password" placeholder="Password" required>
             <span class="error">* <?php echo $passwordErr; ?></span><br><br>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="txt_confirm_password" placeholder="Reenter Your Password"required>
        </div>

        <button class="submit-btn">Sign Up</button>

        <p style="margin-top: 10px; text-align:center;">
            Already a member? <a href="login.php">Log In</a>
        </p>
        </form>

        <?php
        }
        ?>

    </div>
</div>
</body>
</html>                 WHY NOT WORKING?