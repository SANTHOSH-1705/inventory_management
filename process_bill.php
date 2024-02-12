<?php
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemId = $_POST['item'];
    $quantity = $_POST['quantity'];

    $stockCheckSql = "SELECT item_name, item_price, item_quantity FROM items WHERE id = ?";
    $stmt = $connect->prepare($stockCheckSql);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    if ($item['item_quantity'] < $quantity) {
        echo "<p>Not enough stock available for " . htmlspecialchars($item['item_name']) . ".</p>";
    } else {
        $totalPrice = $item['item_price'] * $quantity;

        echo "<h2>Bill Summary</h2>";
        echo "Item: " . htmlspecialchars($item['item_name']) . "<br>";
        echo "Quantity: " . htmlspecialchars($quantity) . "<br>";
        echo "Total Price: $" . htmlspecialchars($totalPrice);

        $newQuantity = $item['item_quantity'] - $quantity;
        $updateSql = "UPDATE items SET item_quantity = ? WHERE id = ?";
        $updateStmt = $connect->prepare($updateSql);
        $updateStmt->bind_param("ii", $newQuantity, $itemId);
        $updateStmt->execute();
        $updateStmt->close();

        // echo "<p>Inventory updated successfully.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Error: Invalid input.</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div style="text-align: center; margin-top: 10px;">
    <a href="inventory.php" style="text-decoration: none; padding: 10px 20px; background-color: #28a745; color: #fff; border-radius: 5px; font-weight: bold;">INVENTORY</a>
</div>
</body>
</html>

