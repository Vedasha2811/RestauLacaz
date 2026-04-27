<?php
include 'includes/db_connect.php';

if (isset($_POST['item_id']) && isset($_POST['new_price'])) {

    $itemID = $_POST['item_id'];
    $newPrice = $_POST['new_price'];

    // validation
    if ($newPrice > 0) {

        $sql = "UPDATE Item SET Item_Price = ? WHERE Item_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$newPrice, $itemID]);

        // redirect back
        header("Location: admin_seafood.php");
        exit();

    } else {
        echo "Invalid price!";
    }
}
?>