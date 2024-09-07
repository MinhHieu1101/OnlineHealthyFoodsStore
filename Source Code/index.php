<?php
	session_start();
	$today = date('l, F j, Y'); 
	if (isset($_SESSION['user_info']['name']) && $_SESSION['user_info']['name'] !== "Customer") {
        $customer = $_SESSION['user_info']['name'];
    } else {
        $customer = "Customer";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		$page_title = "Online Healthy Food Store";
		include_once('includes/header.inc');
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
		<h2>All Your Healthy Foods</h2>
		<img class="effect" src="images/banner.jpg" >
		<p>Welcome to All Your Healthy Foods - your go-to corner for all things fresh and nutritious.</p>
		<p>We're super excited to roll out our online store where you can click, browse, and chuck your favorite goodies into your virtual basket! Get your fresh picks wrapped up and delivered straight to your doorstep.</p>
		<p>It's time to nourish, flourish, and click your way to health with All Your Healthy Foods online!</p>
	</main>
	
	<?php include_once('includes/footer.inc'); ?>

</body>
</html>