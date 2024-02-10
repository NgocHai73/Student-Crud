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
            // Redirect to admin_page.php after adding the product
            header('Location: admin_page.php');
            exit();
        } else {
            $message[] = 'Could not add the product';
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
    <title>Add Product</title>

    <!-- Include necessary CSS and JS files here -->
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

    <div class="container">
        <div class="admin-product-form-container">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h3>Add a new product</h3>
                <input type="text" placeholder="Enter product name" name="product_name" class="box">
                <input type="number" placeholder="Enter product price" name="product_price" class="box">
                <textarea name="product_disceiption" placeholder="Enter product description" class="box"></textarea>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                <input type="submit" class="btn" name="add_product" value="Add Product">
                <a href="admin_page.php" class="btn">Back to Admin Page</a>
            </form>
            <!-- Back button -->
        </div>
    </div>

</body>

</html>
