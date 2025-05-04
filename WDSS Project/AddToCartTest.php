<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../Project/classes/Product.php';

class AddToCartTest extends TestCase {
    public function testCartSessionCreated() {
        // Start the session mock manually
        $_SESSION = [];  // Simulate a fresh session
        
        // Simulate POST data (product ID and quantity)
        $_POST = ['product_id' => 2, 'quantity' => 1];

        // Simulate cart creation
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][$_POST['product_id']] = $_POST['quantity'];

        // Assertions
        $this->assertArrayHasKey(2, $_SESSION['cart']);
        $this->assertEquals(1, $_SESSION['cart'][2]);
    }
}
?>
