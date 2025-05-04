<?php
session_start(); // Start the session to store cart data
include("DBconfig.php"); // Include the database configuration file
require_once("classes/Cart.php"); // Include the Cart class
require_once("classes/Product.php"); // Include the Product class

// Check if product ID and quantity are provided via POST request
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productID = (int)$_POST['product_id']; // Get the product ID from POST request
    $quantity = (int)$_POST['quantity']; // Get the quantity from POST request

    // Load the product details from the database
    $product = Product::loadFromDB($conn, $productID);

    // Check if the product exists
    if ($product !== null) {
        // If cart does not exist in session, create a new cart
        if (!isset($_SESSION['cart']) || !($_SESSION['cart'] instanceof Cart)) {
            $_SESSION['cart'] = new Cart();
        }

        // Add the product to the cart
        $_SESSION['cart']->addProduct($product, $quantity);

        // Insert or update the cart in the database
        $userID = 1; // Hardcoding user ID (ideally it should come from the session)

        // SQL query to insert or update the product in the cart
        $sql = "INSERT INTO cart (user_id, product_id, quantity) 
                VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
        $stmt = mysqli_prepare($conn, $sql); // Prepare the SQL statement
        mysqli_stmt_bind_param($stmt, "iii", $userID, $productID, $quantity); // Bind parameters

        // Execute the query and handle success or failure
        if (mysqli_stmt_execute($stmt)) {
            echo "Product added to your cart!"; // Success message
        } else {
            echo "Database error: " . mysqli_error($conn); // Error message
        }
    } else {
        echo "Product not found."; // If product doesn't exist in database
    }
} else {
    echo "Please select a product and quantity."; // If product or quantity is not provided
}
?>
