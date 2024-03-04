<?php
session_start();
if (isset($_SESSION['success_message'])) {
    echo "<div class='success-message'>" . $_SESSION['success_message'] . "</div>";

    // Xóa thông báo sau khi đã hiển thị
    unset($_SESSION['success_message']);
}
// Xóa toàn bộ sản phẩm khỏi giỏ hàng
$_SESSION['cart'] = array();

// Chuyển hướng người dùng về trang index
header('Location: index.php');
exit;
