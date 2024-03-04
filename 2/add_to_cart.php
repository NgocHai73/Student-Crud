<?php
session_start();
include 'config.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
        if ($query) {
            $row = mysqli_fetch_assoc($query);
            $_SESSION['cart'][$row['id']] = array("name" => $row['name'], "quantity" => 1, "price" => $row['price'], "image" => $row['image']);
            echo 'success';
        } else {
            echo 'error';
        }
    }
} else {
    echo 'error';
}
?>
    