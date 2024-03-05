<?php
@include 'config.php';

if (isset($_GET['edit'])) {
    $edit_category_id = $_GET['edit'];

    // Fetch category details from the database
    $selectCategory = mysqli_query($conn, "SELECT * FROM categories WHERE id = '$edit_category_id'");
    $category = mysqli_fetch_assoc($selectCategory);

    if (!$category) {
        // Handle the case where the category with the provided ID is not found
        header('Location: admin_category_page.php');
        exit();
    }

    if (isset($_POST['update_category'])) {
        $new_category_name = $_POST['category_name'];

        if (empty($new_category_name)) {
            $message[] = 'Please fill out the category name';
        } else {
            // Update category in the database
            $updateCategory = "UPDATE categories SET name = '$new_category_name' WHERE id = '$edit_category_id'";
            $result = mysqli_query($conn, $updateCategory);

            if ($result) {
                header('Location: admin_category_page.php');
                exit();
            } else {
                $message[] = 'Could not update the category';
            }
        }
    }
} else {
    // Redirect to the category page if no category ID is provided
    header('Location: admin_category_page.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Category</title>
    <link rel="stylesheet" href="css/style.css">

    <!-- Include your CSS and font awesome links here -->

</head>

<body>
    <!-- Include your taskbar and container code here -->

    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<span class="message">' . $msg . '</span>';
        }
    }
    ?>

    <div class="container">
        <h2>Edit Category</h2>
        <form method="post" action="">
            <label for="category_name">Category Name:</label>
            <input type="text" name="category_name" value="<?php echo $category['name']; ?>" required>

            <button type="submit" name="update_category" class="btn">Update Category</button>
        </form>
    </div>

</body>

</html>
