<?php
@include 'config.php';

if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];

    if (empty($category_name)) {
        $message[] = 'Please fill out the category name';
    } else {
        $insertCategory = "INSERT INTO categories(name) VALUES('$category_name')";
        $addCategory = mysqli_query($conn, $insertCategory);

        if ($addCategory) {
            $message[] = 'New category added successfully';
            header('Location: admin_category_page.php');
            exit();
        } else {
            $message[] = 'Could not add the category';
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
    <title>Admin - Add Category</title>
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
        <h2>Add Category</h2>
        <form method="post" action="">
            <label for="category_name">Category Name:</label>
            <input type="text" name="category_name" required>

            <button type="submit" name="add_category" class="btn">Add Category</button>
        </form>
    </div>

</body>

</html>
