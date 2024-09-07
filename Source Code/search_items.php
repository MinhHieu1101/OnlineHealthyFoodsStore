<?php
include_once 'item.php';

$item = new Item();
$searchTerm = isset($_GET['search']) ? $_GET['search'] : "";
$items = $item->searchItems($searchTerm);

foreach ($items as $row) {
	echo '<li>';
	echo '<div class="store-item">';
	echo '<div class="img-frame">';
	echo '<img src="images/' . htmlspecialchars($row['product_url']) . '" alt="' . htmlspecialchars($row['product_url']) . '" class="img-item">';
	echo '<a href="product.php?product_id=' . htmlspecialchars($row['product_id']) . '" class="add-button">View More</a>';
	echo '</div>';
	echo '<div class="item-info">';
	echo '<h3>' . htmlspecialchars($row['product_name']) . '</h3>';
	echo '<h4 class="item-price">' . htmlspecialchars($row['instock']) . ' In Stock</h4>';
	echo '<h4 class="item-price2">' . htmlspecialchars($row['price']) . ' &#36;</h4>';
	echo '</div>';
	echo '</div>';
	echo '</li>';
}
?>
