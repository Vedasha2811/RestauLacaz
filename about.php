
<?php
// index.php
include 'header.php';
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>About Us | RestauLacaz</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #ffffff;
            color: #333;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding: 40px 60px;
        }

        .section {
            width: 48%;
        }

        .section h2 {
            margin-bottom: 10px;
            font-size: 24px;
            font-weight: bold;
        }

    </style>
</head>

<body>

    <div class="header">
        <img src="images/logo.png" class="logo">
        <h1>About Us</h1>
    </div>

    <div class="container">
        <div class="section">
            <h2>Our Mission</h2>
            <p>
                RestauLacaz serves as an online hub connecting clients with a wide variety of restaurants 
                and fast food available in Mauritius. We help busy people and those without transport 
                enjoy their favorite food from the comfort of their homes.
            </p>
        </div>

        <div class="section">
            <h2>Contact Information</h2>
            <p>
                <img src="images/phone.png" class="icon">
                +230 5*** ****
            </p>
            <p>
                <img src="images/email.png" class="icon">
                info@restaulacaz.mu
            </p>
            <p>
                <img src="images/location.png" class="icon">
                Port-Louis, Mauritius</p>
        </div>

    </div>
</body>

<?php include 'footer.php'; ?>

</html>