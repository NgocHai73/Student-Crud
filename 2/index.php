<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Online Store</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        // Bắt sự kiện click vào nút "Thêm vào giỏ hàng"
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    var productId = this.dataset.productId; 
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'add_to_cart.php?id=' + productId, true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            alert('Sản phẩm đã được thêm vào giỏ hàng thành công!');
                        }
                    };
                    xhr.send();
                });
            });
        });
    </script>
</head>
<body>
    <div class="taskbar">
        <a href="index.php">Home</a>
        <a href="admin_page.php">Products</a>
        <a href="cart.php">Cart</a>
    </div>
    <div class="content">
        <h1>Welcome to Your Online Store</h1>

        <!-- Hiển thị danh sách sản phẩm -->
        <?php
            include 'config.php'; 
            $select = mysqli_query($conn, "SELECT * FROM products");
            if ($select) {
                while ($row = mysqli_fetch_assoc($select)) {
                    echo "<div class='product'>";
                    echo "<img src='uploaded_img/{$row['image']}' alt='{$row['name']}'>";
                    echo "<h3>{$row['name']}</h3>";
                    echo "<p>Price: {$row['price']} VNĐ</p>";
                    echo "<p>{$row['description']}</p>";
                    echo "<a href='#' class='add-to-cart' data-product-id='{$row['id']}'>Thêm vào giỏ hàng</a>";
                    echo "</div>";
                }
            } else {
                echo "Không thể lấy dữ liệu sản phẩm từ cơ sở dữ liệu.";
            }
        ?>
    </div>
</body>
</html>
