<?php
include('db_config.php');

$sql = "SELECT * FROM items";
$result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Billing Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-image:url(image.jpg)">
    <h2>Billing</h2>
    <form action="process_bill.php" method="POST">
        <label for="item">Select Item:</label><br>
        <select name="item" required>
            <?php while($row = $result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo htmlspecialchars($row['item_name']); ?>
                </option>
            <?php endwhile; ?>
        </select><br>
        <label for="quantity">Quantity:</label><br>
        <input type="number" name="quantity" required><br>
        <input type="submit" value="Generate Bill">
    </form>
</body>
</html>
