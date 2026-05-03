<?php
session_start();

/* ADMIN PROTECTION
*/
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

/* FETCH SEAFOOD ITEMS
*/
// Direct PDO connection
$conn = new PDO("mysql:host=localhost;dbname=restaulakaz_database", "root", "");

$sql = "SELECT * FROM item WHERE Item_Type = 'seafood'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Seafood Panel</title>

<style>
body { font-family: Arial; background: #f4f4f4; margin: 0; }

.header {
    background: #a05b3d;
    color: white;
    padding: 20px;
    text-align: center;
    font-size: 26px;
    font-weight: bold;
}

.container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}

.card {
    background: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.item-img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 5px;
}

.price-form {
    margin-top: 15px;
    display: flex;
    gap: 10px;
}

input[type="number"] {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

button {
    background: #a05b3d;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #864a30;
}
</style>

</head>

<body>

<div class="header">
    Admin Seafood Panel
</div>

<div class="container">

<?php foreach ($items as $row): ?>

    <div class="card">
        <img src="images/<?= htmlspecialchars($row['Item_Image']) ?>" class="item-img">

        <h3><?= htmlspecialchars($row['Item_Name']) ?></h3>
        <p>Current Price: <strong>Rs <?= htmlspecialchars($row['Item_Price']) ?></strong></p>

        <form action="update_price.php" method="POST" class="price-form">
            <input type="hidden" name="item_id" value="<?= $row['Item_ID'] ?>">

            <input type="number" name="new_price" placeholder="New Price" step="0.01" required>

            <button type="submit">Update</button>
        </form>
    </div>

<?php endforeach; ?>

</div>

</body>
</html>