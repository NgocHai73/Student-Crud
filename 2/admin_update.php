<?php

@include 'config.php';

$id = $_GET['edit'];

if (isset($_POST['update_product'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_disceiption = $_POST['product_disceiption'];
    $product_category = $_POST['product_category'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image;

    if (empty($product_name) || empty($product_price) || empty($product_disceiption) || empty($product_image)) {
        $message[] = 'Please fill out all fields';
    } else {

        // Check if the selected category exists
        $category_check = mysqli_query($conn, "SELECT id FROM categories WHERE id = '$product_category'");
        if (mysqli_num_rows($category_check) == 0) {
            $message[] = 'Invalid category selected';
        } else {

            $update_data = "UPDATE products SET name='$product_name', price='$product_price', description='$product_disceiption', image='$product_image', category='$product_category' WHERE id = '$id'";

            $upload = mysqli_query($conn, $update_data);

            if ($upload) {
                move_uploaded_file($product_image_tmp_name, $product_image_folder);
                header('location:admin_page.php');
            } else {
                $message[] = 'Could not update the product';
            }
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

        <div class="admin-product-form-container centered">

            <?php

            $select = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
            while ($row = mysqli_fetch_assoc($select)) {

            ?>

                <form action="" method="post" enctype="multipart/form-data">
                    <h3 class="title">Update the product</h3>
                    <input type="text" class="box" name="product_name" value="<?php echo $row['name']; ?>" placeholder="Enter the product name">
                    
                    <!-- Add a dropdown menu for product category -->
                    <select name="product_category" class="box">
                        <?php
                        $categories_query = mysqli_query($conn, "SELECT id, name FROM categories");
                        while ($category = mysqli_fetch_assoc($categories_query)) {
                            $selected = ($category['id'] == $row['category']) ? 'selected' : '';
                            echo '<option value="' . $category['id'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                        }
                        ?>
                    </select>

                    <input type="number" min="0" class="box" name="product_price" value="<?php echo $row['price']; ?>" placeholder="Enter the product price">
                    <textarea name="product_disceiption" class="box" placeholder="enter the product disceiption"><?php echo $row['description']; ?></textarea>


                    <input type="file" class="box" name="product_image" accept="image/png, image/jpeg, image/jpg">
                    <input type="submit" value="Update product" name="update_product" class="btn">
                    <a href="admin_page.php" class="btn">Go back!</a>
                </form>

            <?php }; ?>

        </div>

    </div>

</body>

</html>
