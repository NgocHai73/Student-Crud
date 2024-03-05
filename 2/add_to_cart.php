<?php
session_start();
include 'config.php'; 

$user_id = session_id(); // Use the session ID as the user ID

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
        $query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$user_id' AND product_id = $product_id";
        if ($conn->query($query) === TRUE) {
            echo 'success';
        } else {
            echo 'error updating cart: ' . $conn->error;
        }
    } else {
        $query = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
        if ($query) {
            $row = mysqli_fetch_assoc($query);
            $_SESSION['cart'][$row['id']] = array("name" => $row['name'], "quantity" => 1, "price" => $row['price'], "image" => $row['image']);
            $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', $product_id, 1)";
            if ($conn->query($query) === TRUE) {
                echo 'success';
            } else {
                echo 'error inserting into cart: ' . $conn->error;
            }
        } else {
            echo 'Product not found in products table';
        }
    }
} else {
    echo 'Product ID not provided';
}
?>
