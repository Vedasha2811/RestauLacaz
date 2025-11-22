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

        /* LEFT IMAGE SECTION */
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

<div class="container">

    <div class="left">
        <img src="images/burger.png" alt="Side Image">
    </div>

    <div class="right">
        <a href="login.php"><button class="login-btn">Log in</button></a>

        <h1>Create An Account</h1>

        <form method="post">

        <div class="row">
            <div class="input-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" placeholder="First Name" required>
            </div>

            <div class="input-group">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" placeholder="Last Name" required>
            </div>
        </div>

        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="confirm" name="Reenter Your Password" placeholder="Reenter Your Password"required>         
        </div>

        <button class="submit-btn">Sign Up</button>

        <p style="margin-top: 10px; text-align:center;">
            Already a member? <a href="login.php">Log In</a>
        </p>
        </form>
    </div>
</div>

</body>
</html>
