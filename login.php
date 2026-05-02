<?php
// Start the session
//The session_start() function must be the very first thing in your document. Before any HTML tags.
session_start();

require_once "includes/db_connect.php";


// define variables and set to empty string values

$emailErr = $passwordErr = "";
$email = $password =  "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["txt_email"])) {
    $emailErr = "email is required";
  } else {
    $email= $_POST["txt_email"];
  }//end else
  if (empty($_POST["txt_password"])) {
    $passwordErr = "Password is required";
  } else {
    $password= $_POST["txt_password"];
   
  }//end else
  
 if ($emailErr == "" && $passwordErr == "") {

        try {
            // Prepare statement (secure)
            $stmt = $conn->prepare("
                SELECT Customer_ID, First_Name, Last_Name, email, password
                FROM customer
                WHERE email = :email
                LIMIT 1
            ");

            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {

                $hashed_password = $user['password'];

                // DEBUG (remove after testing)
                // var_dump($password);
                // var_dump($hashed_password);

                if (password_verify($password, $hashed_password)) {

                    // Regenerate session ID (security)
                    session_regenerate_id(true);

                    // Store session data
                    $_SESSION['customerId'] = $user['Customer_ID'];
                    $_SESSION['firstName']  = $user['First_Name'];
                    $_SESSION['lastName']   = $user['Last_Name'];
                    $_SESSION['email']      = $user['email'];

                    //MERGE GUEST CART INTO USER CART
                    $session_id = session_id();
                    $customer_id = $_SESSION['customerId'];

                    $update = $conn->prepare("
                        UPDATE cart 
                        SET Customer_ID = ?
                        WHERE session_id = ? AND Customer_ID IS NULL
                    ");
                    $update->execute([$customer_id, $session_id]);

                    header("Location: home.php?referer=login");
                    exit();

                } else {
                    echo "Invalid email or password";
                }

            } else {
                echo "Invalid email or password";
            }

        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>

    <style>
        body { margin: 0; font-family: Arial, sans-serif; }
        .container { display: flex; height: 100vh; }

        .left { width: 50%; }
        .left img { width: 100%; height: 100%; object-fit: cover; }

        .right { width: 50%; padding: 50px 80px; position: relative; }
        .login-btn {
            position: absolute; right: 60px; top: 20px;
            padding: 10px 30px; background: #9b4d37; color: white;
            border: none; border-radius: 30px; font-size: 16px;
        }

        input {
            width: 100%; padding: 12px 15px; margin-top: 15px;
            border: 1px solid #e0e0e0; border-radius: 25px; font-size: 16px;
        }

        .submit-btn {
            width: 100%; padding: 12px; margin-top: 30px;
            background: #9b4d37; color: white; border: none;
            border-radius: 25px; font-size: 18px; cursor: pointer;
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
    $activemenu ="login";
    
?>

<div class="container">

    <div class="left">
        <img src="images/burger.png">
    </div>

    <div class="right">
    <a href="signin.php"><button class="login-btn">Sign Up</button></a>
    
    <?php
    if(isset($_SESSION['email']))
    { 
        echo "<h3 style=\"color:red\">You are already logged in</h3>";
        
    }//end if
    else
    {	  
    ?>    

    <h1>Log In</h1>

        <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>"  >
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="txt_email" placeholder="Email" required>
            <span class="error">* <?php echo $emailErr;?></span><br/><br/> 
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="txt_password" placeholder="Password" required>
            <span class="error">* <?php echo $passwordErr;?></span><br/><br/> 
        </div>

        <button class="submit-btn">Log In</button>

        <p style="text-align:center; margin-top:10px;">
             Don't have an account? <a href="signin.php">Create One</a>
        </p>

        </form>
    <?php
    }
    ?>

    </div>
</div>
</body>
</html>

