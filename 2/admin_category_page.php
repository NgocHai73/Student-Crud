<?php
@include 'config.php';

$selectCategories = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Categories</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <!-- Include your taskbar and container code here -->
    <div class="taskbar">
        <a href="index.php"> Home</a>
        <a href="admin_page.php"> Product</a>
        <a href="admin_category_page.php"> Category</a>
        <a href="cart.php"> Cart</a>
        
    </div>
    <div class="container">
        <!-- Link to add a new category -->
        <a href="admin_add_category.php" class="btn">Add Category</a>

        <!-- Display categories in a table -->
        <div class="category-display">
            <table class="category-display-table">
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php while ($category = mysqli_fetch_assoc($selectCategories)) { ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo $category['name']; ?></td>
                    <td>
                        <!-- Add your category-specific actions here -->
                        <a href="admin_edit_category.php?edit=<?php echo $category['id']; ?>" class="btn">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="javascript:void(0);" onclick="confirmDeleteCategory(<?php echo $category['id']; ?>)"
                            class="btn">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <script>
    function confirmDeleteCategory(categoryId) {
        var confirmDelete = confirm("Are you sure you want to delete this category?");
        if (confirmDelete) {
            window.location.href = 'admin_category_page.php?delete=' + categoryId;
        }
    }
    </script>

</body>

</html>
