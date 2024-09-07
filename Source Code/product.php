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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		$page_title = "Product";
		include_once('includes/header.inc');
		
		include_once 'item.php';
		$item = new Item();
		$itemId = isset($_GET['product_id']) ? $_GET['product_id'] : die('There is something wrong with the products!');
		$details = $item->getItemDetails($itemId);
	?>
</head>
<body>
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
		<section class="product">
			<section class="left_section">
				<img src="images/<?php echo htmlspecialchars($details['product_url']); ?>" alt="<?php echo htmlspecialchars($details['product_url']); ?>" class="product-img" >
			</section>

			<section class="right_section">
					 <h2><?php echo htmlspecialchars($details['product_name']); ?></h2>
				<br>
				<div class="buy-now">
					<div>
						<h3><?php echo htmlspecialchars($details['price']); ?> &#36;</h3>
						<p>Unit Price</p>
					</div>
					<button class="add_cart">Add To Cart</button>
				</div>
				<br>

				<h3>Item Details</h3>
					<div class="item-container">
						<div class="left_details">
							<p>Category:</p>
							<p>Description:</p>
							<p>Origin:</p>
							<p>In Stock:</p>
							<p>Calories:</p>
							<p>Import Date:</p>
						</div>
						<div class="right_details">
							<p><?php echo htmlspecialchars($details['category']); ?></p>
							<p><?php echo htmlspecialchars($details['description']); ?></p>
							<p><?php echo htmlspecialchars($details['origin']); ?></p>
							<p><?php echo htmlspecialchars($details['instock']); ?></p>
							<p><?php echo htmlspecialchars($details['calories']); ?></p>
							<p><?php echo htmlspecialchars($details['import_date']); ?></p>
						</div>
					</div>
		</section>
	</main>
	
	<?php include_once('includes/footer.inc'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addToCartButton = document.querySelector('.add_cart');
    addToCartButton.addEventListener('click', function() {
        const productId = '<?php echo $itemId; ?>';
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'product_id=' + productId
        })
        .then(response => response.text())
        .then(data => {
            alert('Product added to cart!');
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>
</body>
</html>