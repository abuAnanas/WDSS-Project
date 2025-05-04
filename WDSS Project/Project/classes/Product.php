<?php
// The Product class is responsible for managing product details and interacting with the database.
class Product {
    private $productID; // Product ID
    private $name; // Product name
    private $description; // Product description
    private $price; // Product price
    private $stockQuantity; // Quantity of the product available in stock
    private $image; // Product image file name

    // Getters
    // Retrieve the product unique ID
    public function getProductID() {
        return $this->productID; // Return productID
    }

    // Retrieve the product name
    public function getName() {
        return $this->name; // Return name
    }

    // Retrieve the product description
    public function getDescription() {
        return $this->description; // Return description
    }

    // Retrieve the product price
    public function getPrice() {
        return $this->price; // Return price
    }

    // Retrieve the product stock quantity
    public function getStockQuantity() {
        return $this->stockQuantity; // Return stock quantity
    }

    // Retrieve the product image file name
    public function getImage() {
        return $this->image; // Return image filename
    }

    // Setters
    // Set the product unique ID
    public function setProductID($id) {
        $this->productID = $id; // Assign value to productID
    }

    // Set the product name
    public function setName($name) {
        $this->name = $name; // Assign value to name
    }

    // Set the product description
    public function setDescription($desc) {
        $this->description = $desc; // Assign value to description
    }

    // Set the product price
    public function setPrice($price) {
        $this->price = $price; // Assign value to price
    }

    // Set the product stock quantity
    public function setStockQuantity($qty) {
        $this->stockQuantity = $qty; // Assign value to stockQuantity
    }

    // Set the product image
    public function setImage($image) {
        $this->image = $image; // Assign value to image
    }

    // Load product data from the database
    public static function loadFromDB($conn, $productID) {

        // Prepare SQL query to fetch product data based on productID
        $sql = "SELECT * FROM product WHERE product_id = ?"; 
        $stmt = mysqli_prepare($conn, $sql); // Prepare the SQL statement
        mysqli_stmt_bind_param($stmt, "i", $productID); // Bind the productID to the query
        mysqli_stmt_execute($stmt); // Execute the query
        $result = mysqli_stmt_get_result($stmt); // Get the result from the query execution

        // Check if the product exists in the database
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch product data as an associative array
            $productData = mysqli_fetch_assoc($result);
            $product = new Product(); // Create a new Product object

            // Set the product properties from the database result
            $product->setProductID($productData['product_id']);
            $product->setName($productData['name']);
            $product->setDescription($productData['description']);
            $product->setPrice($productData['price']);
            $product->setStockQuantity($productData['quantity']);
            $product->setImage($productData['image']);
            return $product; // Return the populated Product object
        } else {
            return null; // Return null if no product is found
        }
    }

    // Retrieve a formatted string of product details for displaying
    public function getProductDetails() {
        return $this->name . " - €" . number_format($this->price, 2); // Return product name and formatted price
    }

    // A placeholder function to update the product's stock (currently empty)
    public function updateStock() {
    }
}
?>
