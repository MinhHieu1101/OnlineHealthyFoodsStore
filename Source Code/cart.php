<?php
	session_start();
	$today = date('l, F j, Y');
	if (isset($_SESSION['user_info']['name']) && $_SESSION['user_info']['name'] !== "Customer") {
        $customer = $_SESSION['user_info']['name'];
    } else {
        $customer = "Customer";
        echo "<script>alert('Please sign up or log in to continue!'); window.location.href='account.php';</script>";
        exit;
    }
	
	require_once 'item.php';
	$item = new Item();
	
	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = [];
	}
	
	$totalValue = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		$page_title = "Shopping Cart";
		include_once('includes/header.inc');
	?>
</head>
<body class="body2">
	<?php include_once('includes/menu.inc'); ?>

	<!-- Banner -->
	<div class="banner">
		<div class="banner-content">
			<div class="banner-text">
				<p><?php echo $today; ?></p> <br><br>
				<p>Howdy there, <em><?php echo $customer; ?></em> &lpar;&#9685;&#8255;&#9685;&rpar;</p>
			</div>
		</div>
	</div>

	<!-- Main Section -->
	<main id="main" class="flexlayout-column">
		<div class="shopping-cart">
			<h2 class="cart-title">Shopping Cart</h2>
			

<?php
foreach ($_SESSION['cart'] as $productId => $quantity) {
    $details = $item->getItemDetails($productId);
    $totalValue += $details['price'] * $quantity;
?>			


<div class="item" data-product-id="<?php echo $productId; ?>">
    <div class="buttons">
        <button class="remove-product">Remove</button>
    </div>

    <div class="image-cart">
        <img src="images/<?php echo $details['product_url']; ?>" alt="" />
    </div>

    <div class="description">
        <span><?php echo htmlspecialchars($details['product_name']); ?></span>
        <span><?php echo htmlspecialchars($details['origin']); ?></span>
        <span>$<?php echo number_format($details['price'], 2); ?></span>
    </div>

    <div class="quantity">
        <button class="minus-button" type="button" name="button">
            <img src="images/minus.png" alt="" />
        </button>
        <input type="text" name="quantity" value="<?php echo $quantity; ?>">
        <button class="plus-button" type="button" name="button">
            <img src="images/plus.png" alt="" />
        </button>
    </div>
</div>

<?php
}
?>	
		
<div class="cart-value">
    <h3 class="label">Grand Total</h3>
    <div class="total-value">$<?php echo number_format($totalValue, 2); ?></div>
    <button class="checkout">Checkout</button>
</div>


		
			
		</div>
	</main>
	
	<?php include_once('includes/footer.inc'); ?>

	<script type="text/javascript" src="scripts/cart.js"></script>
</body>
</html>