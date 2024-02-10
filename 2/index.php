<?php
// Include your configuration or any necessary files here
// ...

// Establish database connection
include 'config.php'; // Make sure your configuration file is correctly included

// Check if the connection is successful
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Assume you have a connection to the database and want to fetch products
$select = mysqli_query($conn, "SELECT * FROM products");

// Check if the query was successful
if (!$select) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Online Store</title>

    <!-- Add your CSS styles or link to external stylesheets here -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- Taskbar -->
    <div class="taskbar">
        <a href="index.php">Home</a>
        <a href="admin_page.php">Products</a> 
        <a href="#">Logout</a><!-- New link for Products -->
    </div>

    <!-- Your main content -->
    <div class="content">
        <h1>Welcome to Your Online Store</h1>

        <!-- Display products here -->
        <?php
        while ($row = mysqli_fetch_assoc($select)) {
            echo "<div class='product'>";
            echo "<img src='uploaded_img/{$row['image']}' alt='{$row['name']}'>";
            echo "<h3>{$row['name']}</h3>";
            echo "<p>Price: {$row['price']} VNĐ</p>";
            echo "<p>{$row['description']}</p>";
            // Add more product details if needed
            echo "</div>";
        }
        ?>
    </div>

    <!-- Add your JavaScript or link to external scripts here -->
  

</body>

</html>
