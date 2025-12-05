<?php
session_start ();

 
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;  
}

$maxAttempts = 5;      // number of tries allowed
$lockTime = 60;        // seconds (1 minute)

if (isset($_SESSION['lock_time']) && time() < $_SESSION['lock_time']) {
    $remaining = $_SESSION['lock_time'] - time();
    die("<p style='color:red;'>Too many attempts. Try again in $remaining seconds.</p>");
}

$emailErr = $passwordErr = "";
$email = $password =  "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["txt_email"])) {
    $emailErr = "Email is required";
  } else {
    $email = $_POST["txt_email"];
  }
  if (empty($_POST["txt_password"])) {
    $passwordErr = "Password is required";
  } else {
    $password= $_POST["txt_password"];
  }

  if($emailErr == "" && $passwordErr == "" )
  {
    //We hashed passwords using   
    //$hashed_password = password_hash($password,PASSWORD_DEFAULT);
  	//References http://php.net/manual/en/function.password-verify.php
  	require_once "includes/db_connect.php";
  	$sQuery = "SELECT * FROM account WHERE email = '$email'  ";
  	
  	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $Result = $conn->query($sQuery) ;
    $userResults = $Result->fetch(PDO::FETCH_ASSOC);

    if ($userResults['email']) // user found
    {
        $hashed_password = $userResults['password'];

        if (password_verify($password, $hashed_password))
        {
            // ✔ Reset attempts after successful login
            $_SESSION['attempts'] = 0;
            unset($_SESSION['lock_time']);

            $_SESSION['email'] = $email;
            header("Location: home.php?referer=login");
        }
        else
        {
            // Wrong password → increase attempt counter
            $_SESSION['attempts']++;

            if ($_SESSION['attempts'] >= $maxAttempts) {
                $_SESSION['lock_time'] = time() + $lockTime; // lock for 1 minute
                echo "<p style='color:red;'>Too many incorrect attempts. Locked for $lockTime seconds.</p>";
            } else {
                echo "<p style='color:red;'>Wrong password. Attempts: {$_SESSION['attempts']}/$maxAttempts</p>";
            }
        }
    }
    else {
      //EMAIL NOT FOUND → count attempt
      $_SESSION['attempts']++;
      if ($_SESSION['attempts'] >= $maxAttempts) {
        $_SESSION['lock_time'] = time() + $lockTime;
        echo "<p style='color:red;'>Too many incorrect attempts. Locked for $lockTime seconds.</p>";
        } else {
          echo "<p style='color:red;'>Email not found. Attempts: {$_SESSION['attempts']}/$maxAttempts</p>";
          }
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
    include('includes/menu.php');
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
