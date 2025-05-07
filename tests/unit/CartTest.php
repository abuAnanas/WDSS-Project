<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../Project/classes/Cart.php';

class CartTest extends TestCase {
    public function testAddProduct() {
        $cart = new Cart();

        // Create a dummy product
        $product = new class {
            public function getProductID() {
                return 1;
            }
            public function getPrice() {
                return 10;
            }
        };

        $cart->addProduct($product, 3);

        $this->assertEquals(3, $cart->getProductQuantity(1));
    }

    public function testRemoveProduct() {
        $cart = new Cart();

        $product = new class {
            public function getProductID() {
                return 1;
            }
            public function getPrice() {
                return 10;
            }
        };

        $cart->addProduct($product, 3);
        $cart->removeProduct(1);

        $this->assertEquals(0, $cart->getProductQuantity(1));
    }
}
?>
