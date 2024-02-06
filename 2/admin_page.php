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
        $message[] = 'please fill out all';
    } else {
        $insert = "INSERT INTO products(name, price, description, image) VALUES('$product_name', '$product_price', '$product_disceiption' ,'$product_image')";

        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'new product added successfully';
        } else {
            $message[] = 'could not add the product';
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header('location:admin_page.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>

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

    <div class="container">

        <div class="admin-product-form-container">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h3>add a new product</h3>
                <input type="text" placeholder="enter product name" name="product_name" class="box">
                <input type="number" placeholder="enter product price" name="product_price" class="box">
                <textarea name="product_disceiption" placeholder="enter product disceiption" class="box"></textarea>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                <input type="submit" class="btn" name="add_product" value="add product">
            </form>
        </div>

        <?php

    $select = mysqli_query($conn, "SELECT * FROM products");

    ?>
        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>product image</th>
                        <th>product name</th>
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
                    <td><?php echo $row['price']; ?> VNĐ</td>
                    <td>
                        <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i
                                class="fas fa-edit"></i> edit </a>
                        <a href="admin_page.php?delete=<?php echo $row['id']; ?>" class="btn"> <i
                                class="fas fa-trash"></i> delete </a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <!-- Modal for product details -->
    <div id="productDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="productDetailsContent"></div>
        </div>
    </div>

    <script>
    function showProductDetails(id, name, price, description, image) {
        var modal = document.getElementById('productDetailsModal');
        var modalContent = document.getElementById('productDetailsContent');

        // Set the desired height for the image (e.g., 100px)
        var imageHeight = '100px';

        var detailsHTML = `
        <span class="close" onclick="closeModal()">&times;</span>
        <div>
            
            <img src="uploaded_img/${image}" alt="${name} Image" class="product-image" style="height: ${imageHeight}">
            <p><strong>ID:</strong> ${id}</p>
            <h2>${name}</h2>
        </div>
        <div>
            <p><strong>Price:</strong> ${price} VNĐ</p>
            <p><strong>Description:</strong> ${description}</p>
            <p><strong>Created at:</strong> ${new Date().toLocaleString()}</p>
            
        </div>
        `;

        modalContent.innerHTML = detailsHTML;
        modal.style.display = 'block';
    }

    function closeModal() {
        var modal = document.getElementById('productDetailsModal');
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        var modal = document.getElementById('productDetailsModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
    </script>



</body>

</html>