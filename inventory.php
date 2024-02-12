<?php
include('db_config.php');

if (isset($_POST['submit'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO items (item_name, item_price, item_quantity) VALUES (?, ?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("sdi", $product_name, $price, $quantity);

    if ($stmt->execute()) {
        echo "<script>alert('Item added successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

if (isset($_POST['delete'])) {
    $deleteItemId = $_POST['delete'];
    $deleteSql = "DELETE FROM items WHERE id = ?";
    $deleteStmt = $connect->prepare($deleteSql);
    $deleteStmt->bind_param("i", $deleteItemId);

    if ($deleteStmt->execute()) {
        echo "<script>alert('Item deleted successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $deleteStmt->error . "');</script>";
    }
    $deleteStmt->close();
}

// if (isset($_POST['add_quantity'])) {
//     $addQuantityItemId = $_POST['add_quantity'];

//     $getQuantitySql = "SELECT item_quantity FROM items WHERE id = ?";
//     $getQuantityStmt = $connect->prepare($getQuantitySql);
//     $getQuantityStmt->bind_param("i", $addQuantityItemId);
//     $getQuantityStmt->execute();
//     $getQuantityResult = $getQuantityStmt->get_result();
//     $currentQuantity = $getQuantityResult->fetch_assoc()['item_quantity'];
//     $getQuantityStmt->close();

//     $newQuantity = $currentQuantity + 1;

//     $updateSql = "UPDATE items SET item_quantity = ? WHERE id = ?";
//     $updateStmt = $connect->prepare($updateSql);
//     $updateStmt->bind_param("ii", $newQuantity, $addQuantityItemId);

//     if ($updateStmt->execute()) {
//         echo "<script>alert('Quantity increased successfully');</script>";
//     } else {
//         echo "<script>alert('Error: " . $updateStmt->error . "');</script>";
//     }
//     $updateStmt->close();
// }

$sql = "SELECT * FROM items";
$result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inventory Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Inventory Management</h2>
    <form method="POST" action="">
        <label for="item_name">Product Name:</label><br>
        <input type="text" name="product_name" required><br>
        <label for="item_price">Price:</label><br>
        <input type="number" step="0.01" name="price" required><br>
        <label for="item_quantity">Quantity:</label><br>
        <input type="number" name="quantity" required><br>
        <input type="submit" name="submit" value="Add Item">
    </form>
    <div style="text-align: center; margin-top: 10px;">
    <a href="billing.php" style="text-decoration: none; padding: 10px 20px; background-color: #28a745; color: #fff; border-radius: 5px; font-weight: bold;">BILLS</a>
</div>


    <h3>Current Inventory</h3>
    <table>
        <tr>
            <th>Item Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                <td><?php echo htmlspecialchars($row['item_price']); ?></td>
                <td>
                    <?php echo htmlspecialchars($row['item_quantity']); ?>
                    <!-- <form method="POST" action="">
                        <input type="hidden" name="add_quantity" value="<?php echo $row['id']; ?>">
                        <button type="submit">Add</button>
                    </form> -->
                </td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="delete" value="<?php echo $row['id']; ?>">
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
x   