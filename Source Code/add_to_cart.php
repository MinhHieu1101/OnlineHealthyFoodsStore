<?php
session_start();
include_once 'cart2.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $cart = new Cart();
    $product_id = $_POST['product_id'];
    $cart->addToCart($product_id);
    echo "Product added to cart!";
    exit;
}
