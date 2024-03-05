<?php
@include 'config.php';

if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_disceiption = $_POST['product_disceiption'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image;

    if (empty($product_name) || empty($product_price) || empty($product_disceiption) || empty($product_image)) {
        $message[] = 'please fill out all fields';
    } else {
        $insert = "INSERT INTO products(name, price, description, image) VALUES('$product_name', '$product_price', '$product_disceiption' ,'$product_image')";

        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'New product added successfully';
        } else {
            $message[] = 'Could not add the product';
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = '$id'");

    header('location:admin_page.php');
}

$select = mysqli_query($conn, "SELECT * FROM products");
$select = mysqli_query($conn, "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category = c.id");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<span class="message">' . $message . '</span>';
        }
    }
    ?>

    <!-- Taskbar -->
    <div class="taskbar">
        <a href="index.php"> Home</a>
        <a href="admin_page.php"> Product</a>
        <a href="admin_category_page.php"> Category</a>
        <a href="cart.php"> Cart</a>
        
    </div>
    <div class="container">
        <a href="admin_add_page.php" class="btn">Add Product</a>
    </div>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<span class="message">' . $message . '</span>';
        }
    }
    ?>

    <div class="container">

        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>product image</th>
                        <th>product name</th>
                        <th>product categories</th>
                        <th>product price</th>
                        <th>action</th>
                    </tr>
                </thead>
                <?php while ($row = mysqli_fetch_assoc($select)) { ?>
                <tr>
                    <td>
                        <img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""
                            onclick="showProductDetails(<?php echo $row['id']; ?>, '<?php echo addslashes($row['name']); ?>', '<?php echo $row['price']; ?>', '<?php echo addslashes($row['description']); ?>', '<?php echo $row['image']; ?>')">
                    </td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td><?php echo $row['price']; ?> VNĐ</td>
                    <td>
                        <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i
                                class="fas fa-edit"></i> edit </a>
                        <!-- ... inside your while loop ... -->
                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)" class="btn">
                            <i class="fas fa-trash"></i> delete
                        </a>



                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <script>
    function confirmDelete(productId) {
        var confirmDelete = confirm("Are you sure you want to delete this product?");
        if (confirmDelete) {
            // User confirmed deletion
            window.location.href = 'admin_page.php?delete=' + productId;
        }
        // When the function returns nothing or false, the default link action will not trigger
    }
    </script>





</body>

</html>