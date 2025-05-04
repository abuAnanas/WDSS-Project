<?php
include("DBconfig.php"); // Includes the database connection file
require_once("classes/Product.php"); // Includes the Product class

$productID = 1; // Set product ID to 1 for this page

// Load product details from the database using the product ID
$product = Product::loadFromDB($conn, $productID);

// Check if the product was found
if ($product === null) {
    echo "Product not found."; // show error if product is not found
    exit; // Stop the script
}
?>

<h1><?php echo "Pre-Built PC's"?></h1> <!-- Page title -->

<div class="container"> <!-- Main container for layout -->
    <div class="row"> <!-- Row for product layout -->
        <div class="col-xs-3 pet-list-item"> <!-- Image section -->
            <img src="/Project/images/<?php echo htmlspecialchars($product->getImage()); ?>" class="pull-left img-rounded" width="300" alt="Product Image" /> <!-- Display product image -->
        </div>
        <div class="col-xs-6"> <!-- Product details section -->
            <p><?php echo htmlspecialchars($product->getName()); ?></p> <!-- Display product name -->

            <table class="table"> <!-- Table for product details -->
                <tbody>
                    <tr>
                        <th>Product Name</th>
                        <td><?php echo htmlspecialchars($product->getName()); ?></td> <!-- Display product name -->
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><?php echo nl2br(htmlspecialchars($product->getDescription())); ?></td> <!-- Display product description -->
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>€<?php echo number_format($product->getPrice(), 2); ?></td> <!-- Display product price -->
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td><?php 
                        // Check stock availability and display status
                        if($product->getStockQuantity() >= 10){
                            echo "In Stock";
                        }
                        else if($product->getStockQuantity() < 5){
                            echo "Low Stock - Less than 5 remaining";
                        }
                        else if($product->getStockQuantity() == 0){
                            echo "Out Of Stock";
                        }
                        ?></td> <!-- Display stock status -->
                    </tr>

                    <form method="post" action="add_to_cart.php"> <!-- Form to add product to cart -->
                        <input type="hidden" name="product_id" value="<?php echo $product->getProductID(); ?>"> <!-- Pass product ID -->
                        <input type="number" name="quantity" value="1" min="1" style="width: 60px;"> <!-- Quantity input -->
                        <input type="submit" value="Add to Cart" class="btn btn-success"> <!-- Submit button -->
                    </form>
                </tbody>
            </table>
        </div>
    </div>
</div>
