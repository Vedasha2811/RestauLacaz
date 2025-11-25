<?php
session_start ();

&useremailErr
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

<div class="container">

    <div class="left">
        <img src="images/burger.png">
    </div>

    <div class="right">
    <a href="signin.php"><button class="login-btn">Sign Up</button></a>
    <h1>Log In</h1>

        <form metod=" post">
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
        </div>

        <button class="submit-btn">Log In</button>

        <p style="text-align:center; margin-top:10px;">
             Don't have an account? <a href="signin.php">Create One</a>
        </p>

        </form>
    </div>
</div>
</body>
</html>
