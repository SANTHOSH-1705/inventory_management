<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "sales_inventory_db";

$connect = new mysqli($servername, $username, $password, $dbname);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
?>
