<?php
session_start();

$firstnameErr = $lastnameErr = $emailErr = $passwordErr = "";
$firstname = $lastname = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Validate First Name
    if (empty($_POST["txt_firstname"])) {
        $firstnameErr = "First name is required";
    } else {
        $firstname = $_POST["txt_firstname"];
    }

    // 2. Validate Last Name
    if (empty($_POST["txt_lastname"])) {
        $lastnameErr = "Last name is required";
    } else {
        $lastname = $_POST["txt_lastname"];
    }

    // 3. Validate Email
    if (empty($_POST["txt_email"])) {
        $emailErr = "Email is required";
    } else {
        $email = trim($_POST["txt_email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // 4. Validate Password & Confirmation
    if (empty($_POST["txt_password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = trim($_POST["txt_password"]);
        $confirm_password = trim($_POST["txt_confirm_password"]);
        
        if ($password !== $confirm_password) {
            $passwordErr = "Passwords do not match!";
        }
    }

    // 5. If no errors, save to database
    if ($firstnameErr == "" && $lastnameErr == "" && $emailErr == "" && $passwordErr == "") {
        try {
            // Use PDO to match your other files and fix the "SQL Syntax" error
            $conn = new PDO("mysql:host=localhost;dbname=restaulakaz_database", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO customer (First_Name, Last_Name, email, password) 
                                    VALUES (:firstname, :lastname, :email, :password)");

            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);

            if ($stmt->execute()) {
                // Success! Redirect to login page
                header("Location: login.php?signup=success");
                exit();
            }
        } catch (PDOException $e) {
            $emailErr = "Error: Email might already be registered.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - RestauLakaz</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f9f9f9; }
        .container { display: flex; height: 100vh; }
        .left { width: 50%; }
        .left img { width: 100%; height: 100%; object-fit: cover; }
        .right { width: 50%; padding: 40px 80px; position: relative; overflow-y: auto; }
        
        .login-btn-top {
            position: absolute; right: 60px; top: 20px;
            padding: 10px 30px; background: #9b4d37; color: white;
            border: none; border-radius: 30px; text-decoration: none; font-size: 14px;
        }

        .input-group { width: 100%; margin-bottom: 15px; }
        .input-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        input {
            width: 100%; padding: 12px 15px; border: 1px solid #e0e0e0;
            border-radius: 25px; font-size: 16px; box-sizing: border-box;
        }

        .row { display: flex; gap: 15px; }
        .submit-btn {
            width: 100%; padding: 12px; margin-top: 20px;
            background: #9b4d37; color: white; border: none;
            border-radius: 25px; font-size: 18px; cursor: pointer;
        }
        .error { color: red; font-size: 12px; margin-left: 10px; }
    </style>
</head>
<body>

<div class="container">
    <div class="left">
        <img src="images/burger.png" alt="Side Image">
    </div>

    <div class="right">
        <a href="login.php" class="login-btn-top">Log In</a>
        
        <?php if(isset($_SESSION['email'])): ?>
            <h3 style="color:red">You are already logged in</h3>
            <p><a href="home.php">Go to Home</a></p>
        <?php else: ?>
            <h1>Create An Account</h1>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                
                <div class="row">
                    <div class="input-group">
                        <label>First Name</label>
                        <input type="text" name="txt_firstname" value="<?php echo $firstname; ?>" required>
                        <span class="error"><?php echo $firstnameErr; ?></span>
                    </div>

                    <div class="input-group">
                        <label>Last Name</label>
                        <input type="text" name="txt_lastname" value="<?php echo $lastname; ?>" required>
                        <span class="error"><?php echo $lastnameErr; ?></span>
                    </div>
                </div>
            
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="txt_email" value="<?php echo $email; ?>" required>
                    <span class="error"><?php echo $emailErr; ?></span>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="txt_password" required>
                    <span class="error"><?php echo $passwordErr; ?></span>
                </div>

                <div class="input-group">
                    <label>Confirm Password</label>
                    <input type="password" name="txt_confirm_password" required>
                </div>

                <button type="submit" class="submit-btn">Sign Up</button>

                <p style="text-align:center; margin-top:15px;">
                    Already a member? <a href="login.php">Log In</a>
                </p>
            </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>