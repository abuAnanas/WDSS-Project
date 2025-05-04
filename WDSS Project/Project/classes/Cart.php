<?php

class Cart {
    private $products = array(); // Set up an array to store products in the cart
    private $quantities = array(); // Set up an array to store quantities of each product

    // Adds a product to the cart with stock validation
    public function addProduct($product, $quantity) {
        $productID = $product->getProductID(); // Get the product ID from the product object
        $stockQuantity = $product->getStockQuantity(); // Get the stock quantity from the product

        // Check if the requested quantity exceeds the available stock
        if ($quantity > $stockQuantity) {
            echo "Sorry, we only have " . $stockQuantity . " of this product in stock."; // If stock is insufficient, notify the user
            return; // Exit the function if there isn't enough stock
        }

        // If the product is already in the cart, increase the quantity
        if (isset($this->products[$productID])) {
            $this->quantities[$productID] += $quantity; // Add the new quantity to the existing quantity
        } else {
            // If the product is not in the cart, add it with the specified quantity
            $this->products[$productID] = $product; // Add the product to the cart
            $this->quantities[$productID] = $quantity; // Set the quantity for this product
        }
    }

    // Removes a product from the cart
    public function removeProduct($productID) {
        // Check if the product exists in the cart before trying to remove it
        if (isset($this->products[$productID])) {
            unset($this->products[$productID]); // Remove the product from the cart
            unset($this->quantities[$productID]); // Remove the quantity of that product
        }
    }

    // Gets all products currently in the cart
    public function getProducts() {
        return $this->products; // Return the products array
    }

    // Gets the quantity of a specific product in the cart
    public function getProductQuantity($productID) {
        // If the product is in the cart, return its quantity
        if (isset($this->quantities[$productID])) {
            return $this->quantities[$productID];
        } else {
            return 0; // If the product is not in the cart, return 0
        }
    }

    // Calculates the total price of the cart
    public function getTotalPrice() {
        $total = 0; // Set up total price
        // Loop through each product in the cart and add the total price
        foreach ($this->products as $product) {
            $productID = $product->getProductID(); // Get the product ID
            // Multiply the price by the quantity to get the total for this product
            $total += $product->getPrice() * $this->quantities[$productID];
        }
        return $total; // Return the total price of the cart
    }

    // Clears all products from the cart
    public function clearCart() {
        $this->products = array(); // Clear the products array
        $this->quantities = array(); // Clear the quantities array
    }

    // Saves the cart data to the database (syncs cart with database)
    public function saveCartToDB($conn, $userID) {
        // Loop through each product in the cart and save it to the database
        foreach ($this->products as $product) {
            $productID = $product->getProductID(); // Get the product ID
            $quantity = $this->quantities[$productID]; // Get the quantity of the product

            // SQL query to insert or update cart item in the database
            $sql = "INSERT INTO cart (user_id, product_id, quantity) 
                    VALUES (?, ?, ?) 
                    ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
            $stmt = mysqli_prepare($conn, $sql); // Prepare the SQL statement
            mysqli_stmt_bind_param($stmt, "iii", $userID, $productID, $quantity); // Bind the user ID, product ID, and quantity to the query

            // Execute the SQL statement, if it fails show the error
            if (!mysqli_stmt_execute($stmt)) {
                echo "Error saving cart item: " . mysqli_error($conn); // Output the error if saving fails
            }
        }
    }
}
?>
