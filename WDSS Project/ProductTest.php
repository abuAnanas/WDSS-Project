<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../Project/classes/Product.php';

class ProductTest extends TestCase {
    public function testProductCreation() {
        // Create a Product object without constructor parameters
        $product = new Product();

        // Set name and price using setters
        $product->setName("iPhone");
        $product->setPrice(999);

        // Assertions
        $this->assertEquals("iPhone", $product->getName());
        $this->assertEquals(999, $product->getPrice());
    }
}
?>
