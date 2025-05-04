<?php
require_once("classes/Cart.php"); // Include the Cart class
require_once("classes/Product.php"); // Include the Product class
include("DBconfig.php"); // Include the database config file

session_start(); // Start the session to manage cart data

// Handle the request to remove a product from the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_product_id'])) {
    $productID = (int)$_POST['remove_product_id']; // Get the product ID from the POST data
    $userID = 1; // Hardcoded user ID, should be replaced with session data in a real project

    // Remove the product from the cart in the database
    $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?"; // SQL query to delete product from cart
    $stmt = mysqli_prepare($conn, $sql); // Prepare the statement
    mysqli_stmt_bind_param($stmt, "ii", $userID, $productID); // Bind the user ID and product ID to the query
    mysqli_stmt_execute($stmt); // Execute the query
}

// Get all items in the cart for the current user
$userID = 1; // Hardcoded user ID
$sql = "SELECT * FROM cart WHERE user_id = ?"; // SQL to get cart items for the user
$stmt = mysqli_prepare($conn, $sql); // Prepare the statement
mysqli_stmt_bind_param($stmt, "i", $userID); // Bind the user ID to the query
mysqli_stmt_execute($stmt); // Execute the query
$result = mysqli_stmt_get_result($stmt); // Get the result of the query

$cartItems = []; // Initialize an array to hold cart items
$totalPrice = 0; // Initialize total price to 0

// Loop through the cart items and calculate total price
while ($row = mysqli_fetch_assoc($result)) {
    $product = Product::loadFromDB($conn, $row['product_id']); // Load product data from DB
    if ($product) {
        $quantity = $row['quantity']; // Get the quantity of the product
        $cartItems[] = [ // Add product and quantity to the cartItems array
            'product' => $product,
            'quantity' => $quantity
        ];
        $totalPrice += $product->getPrice() * $quantity; // Add the total price of this product to total
    }
}

require 'layout/header.php'; // Include the page header
require 'layout/navbar.php'; // Include the navigation bar
?>

<div class="container">
    <h1>Your Cart</h1>

    <?php if (count($cartItems) > 0): // If there are items in the cart ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): // Loop through each cart item ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product']->getName()); ?></td> <!-- Product name -->
                        <td>€<?php echo number_format($item['product']->getPrice(), 2); ?></td> <!-- Product price -->
                        <td><?php echo $item['quantity']; ?></td> <!-- Quantity of the product -->
                        <td>€<?php echo number_format($item['product']->getPrice() * $item['quantity'], 2); ?></td> <!-- Total price for this item -->
                        <td>
                            <!-- Form to remove item from the cart -->
                            <form method="post" action="cart.php">
                                <input type="hidden" name="remove_product_id" value="<?php echo $item['product']->getProductID(); ?>"> <!-- Hidden input with product ID -->
                                <button type="submit" class="btn btn-danger">Remove</button> <!-- Remove button -->
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total Price</strong></td> <!-- Total price label -->
                    <td colspan="2"><strong>€<?php echo number_format($totalPrice, 2); ?></strong></td> <!-- Total price -->
                </tr>
            </tbody>
        </table>
        <!-- Button to proceed to checkout -->
        <form method="post" action="checkout.php">
            <button type="submit" class="btn btn-success">Proceed to Checkout</button>
        </form>
    <?php else: // If the cart is empty ?>
        <p>Your cart is empty.</p> <!-- Show empty cart message -->
    <?php endif; ?>
</div>

<?php require 'layout/footer.php'; // Include the page footer ?>
