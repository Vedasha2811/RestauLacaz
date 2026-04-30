<?php
session_start();
require_once "includes/db_connect.php";

  /* LOGIN ATTEMPT CONTROL
*/
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

$maxAttempts = 5;
$lockTime = 60;

/* 
   CHECK LOCK STATUS
*/
if (isset($_SESSION['lock_time']) && time() < $_SESSION['lock_time']) {
    $remaining = $_SESSION['lock_time'] - time();
    die("<p style='color:red; text-align:center;'>
        Too many attempts. Try again in $remaining seconds.
    </p>");
}

/* 
   ERROR VARIABLES
*/
$emailErr = $passwordErr = "";
$email = $password = "";

/* 
   LOGIN PROCESS
*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["txt_email"]);
    $password = trim($_POST["txt_password"]);

    if (empty($email)) {
        $emailErr = "Email is required";
    }

    if (empty($password)) {
        $passwordErr = "Password is required";
    }

    if ($emailErr == "" && $passwordErr == "") {

        /* 
           CHANGE TABLE HERE IF NEEDED
           admin OR customer
         */

        // 👉 LOGIN FROM ADMIN TABLE
        $stmt = $conn->prepare("SELECT * FROM admin WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {

            if (password_verify($password, $user['password'])) {

                // SUCCESS LOGIN
                $_SESSION['attempts'] = 0;
                unset($_SESSION['lock_time']);

                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = "admin";

                header("Location: home.php?login=success");
                exit();

            } else {
                $_SESSION['attempts']++;
                handleAttempts();
            }

        } else {
            $_SESSION['attempts']++;
            handleAttempts("Email not found");
        }
    }
}

/*
   LOCK FUNCTION
 */
function handleAttempts($msg = "Wrong credentials")
{
    global $maxAttempts, $lockTime;

    if ($_SESSION['attempts'] >= $maxAttempts) {
        $_SESSION['lock_time'] = time() + $lockTime;
        die("<p style='color:red; text-align:center;'>
            Too many incorrect attempts. Locked for $lockTime seconds.
        </p>");
    } else {
        echo "<p style='color:red; text-align:center;'>
            $msg. Attempts: {$_SESSION['attempts']}/$maxAttempts
        </p>";
    }
}
?>

<!--
     HTML LOGIN FORM
 -->
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <style>
        body { margin: 0; font-family: Arial; }
        .container { display: flex; height: 100vh; }

        .left { width: 50%; }
        .left img { width: 100%; height: 100%; object-fit: cover; }

        .right { width: 50%; padding: 50px; position: relative; }

        .login-btn {
            position: absolute; right: 60px; top: 20px;
            padding: 10px 30px; background: #9b4d37;
            color: white; border: none; border-radius: 30px;
        }

        input {
            width: 100%; padding: 12px; margin-top: 10px;
            border-radius: 25px; border: 1px solid #ccc;
        }

        .submit-btn {
            width: 100%; margin-top: 20px;
            padding: 12px; background: #9b4d37;
            color: white; border: none; border-radius: 25px;
        }

        .input-group { margin-bottom: 15px; }
        .error { color: red; font-size: 12px; }
    </style>
</head>

<body>

<div class="container">

    <div class="left">
        <img src="images/burger.png">
    </div>

    <div class="right">

        <a href="signin.php">
            <button class="login-btn">Sign Up</button>
        </a>

        <?php
        if (isset($_SESSION['email'])) {
            echo "<h3 style='color:green;'>You are already logged in</h3>";
        } else {
        ?>

        <h1>Login</h1>

        <form method="POST">

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="txt_email" required>
                <span class="error"><?php echo $emailErr; ?></span>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="txt_password" required>
                <span class="error"><?php echo $passwordErr; ?></span>
            </div>

            <button class="submit-btn">Log In</button>

        </form>

        <?php } ?>

    </div>
</div>

</body>
</html>
