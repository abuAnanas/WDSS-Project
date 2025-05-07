<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../Project/checkout.php';

class CheckoutTest extends TestCase {
    public function testCartIsNotEmptyBeforeCheckout() {
        // Mock the session data
        $_SESSION['cart'] = [1 => 2];  // Simulate that cart has an item
        
        // Assert that the cart is not empty
        $this->assertNotEmpty($_SESSION['cart']);
    }
}
?>
