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
		$page_title = "Our Store";
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
        <h2>Our Goodies</h2>
        
		
<div class="filters">		
	<div class="dropdown_menu">
		<select id="categoryFilter" onchange="filterItems()">
			<option value="">Select a category</option>
			<option value="Fruit">Fruit</option>
			<option value="Vegetable">Vegetable</option>
			<option value="Healthy Fats">Healthy Fats</option>
			<option value="Lean Proteins">Lean Proteins</option>
			<option value="Nuts and Seeds">Nuts and Seeds</option>
		</select>
	</div>
		
	<div>
		<input type="text" id="searchInput" class="search_input" placeholder="Search products..." oninput="searchItems()">
	</div>
</div>
		
		<ul class="store-list" id="storeItems">
			<!-- Items will be displayed here -->
        </ul>
		

	</main>
	
	<?php include_once('includes/footer.inc'); ?>

	<script type="text/javascript" src="scripts/store.js"></script>
</body>
</html>