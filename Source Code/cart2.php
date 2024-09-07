<?php
class Cart {
    public function addToCart($product_id, $quantity = 1) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = 0;
        }
        $_SESSION['cart'][$product_id] += $quantity;
    }
}
