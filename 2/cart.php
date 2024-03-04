<?php
session_start();
require 'config.php';

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        // Kiểm tra xem 'id' có tồn tại trong $_GET không
        if (isset($_GET['id']) && isset($_SESSION['cart'])) {
            $id = $_GET['id'];
            // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng không
            if (isset($_SESSION['cart'][$id])) {
                unset($_SESSION['cart'][$id]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            } else {
                echo "Sản phẩm không tồn tại trong giỏ hàng";
            }
        } else {
            echo "Không tìm thấy ID sản phẩm hoặc giỏ hàng không tồn tại";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/style.css">
  
</head>

<body>
    <!-- Taskbar -->
    <div class="taskbar">
        <a href="index.php">Home</a>
        <a href="admin_page.php">Products</a>
        <a href="cart.php">Cart</a>
       
    </div>
    <div class="container">
        <h3>Cart</h3>
        <?php
// Trên trang cart.php, xử lý thêm sản phẩm vào giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $id = $_GET['id'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
        if (mysqli_num_rows($query) != 0) {
            $row = mysqli_fetch_array($query);
            $_SESSION['cart'][$row['id']] = array("name" => $row['name'], "quantity" => 1, "price" => $row['price'], "image" => $row['image']);
        } else {
            $message = "Product ID is invalid";
        }
    }
    header('Location: cart.php'); // Chuyển hướng người dùng đến trang giỏ hàng
}

if (!empty($_SESSION['cart'])) {
    $total = 0; // Biến để tính tổng tiền
    foreach ($_SESSION['cart'] as $id => $details) {
        echo "<div class='product'>";
        echo "<img src='uploaded_img/{$details['image']}' alt='{$details['name']}'>";
        echo "<h3>{$details['name']}</h3>";
        echo "<p>Price: {$details['price']} VNĐ</p>";
        echo "<p>Quantity: {$details['quantity']}</p>";
        $total_price = $details['price'] * $details['quantity']; // Tính tổng tiền của mỗi sản phẩm
        echo "<p>Total: " . number_format($total_price) . " VNĐ</p>";
        echo "<a href='cart.php?action=delete&id={$id}'>delete</a>";
        echo "</div>";
        $total += $total_price; // Cộng dồn tổng tiền vào biến total
    }
    // Hiển thị tổng tiền của tất cả sản phẩm
    
}

?>
<div class="total-price">
    <?php if (empty($_SESSION['cart'])): ?>
        <h4>Your shopping cart is empty</h4>
        <h4>Total amount of all products: 0 VNĐ</h4>
    <?php else: ?>
        <h4>Total amount of all products: <?php echo number_format($total); ?> VNĐ</h4>
        <a href="checkout.php" class="btn-pay">Check Out</a>
    <?php endif; ?>
</div>







    </div>
</body>

</html>
