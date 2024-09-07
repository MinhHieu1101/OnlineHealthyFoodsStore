<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <?php 
        $page_title = "All Your Healthy Food";
        include_once('includes/header.inc');
        
        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page if not logged in
            header("Location: login.php");
            exit();
        }
        
        require 'databaseconnect.php';

        // Function to check if the user is an owner
        function isOwner($email)
        {
            $allowed_email_tails = array('@ayhf.com');
            $email_tail = substr($email, strpos($email, '@'));
            return in_array($email_tail, $allowed_email_tails);
        }

        $email = $_SESSION['email'];
        if (!isOwner($email)) {
            // Redirect to login page if not an owner
            header("Location: store.php");
            exit();
        }
        
        //Products data
        $products = [];
        $query = "SELECT * FROM Products";
        //WHERE instock > 0";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
    ?>
</head>

<body>
    <?php include_once('includes/menu.inc'); ?>
    <main id="main" class="flexlayout-column">
        <div class="ayhf-body">
            <h2>Stock Management</h2>
            
            <!-- Error and success message display -->
            <?php if(isset($_SESSION['error_message'])): ?>
                <span class="error-message"><?= $_SESSION['error_message'] ?></span>
                <?php unset($_SESSION['error_message']); ?>
            <?php elseif(isset($_SESSION['success_message'])): ?>
                <span class="success-message"><?= $_SESSION['success_message'] ?></span>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            
            <div class="stock-adding">
                <table class="stock-table">
                    <tr>
                        <th class="th-header">Product Name</th>
                        <th class="th-header">Category</th>
                        <th class="th-header">In Stock</th>
                        <th class="th-header">Add Stock</th>
                        <th class="th-header">Last Import Date</th>
                    </tr>
                    <?php foreach ($products as $row): ?>
                        <tr class="filterItem">
                            <td><?= $row['product_name'] ?></td>
                            <td><?= $row['category'] ?></td>
                            <td><?= $row['instock'] ?></td>
                            <td>
                                <form method='POST' action='restock.php'>
                                    <input type='hidden' name='product_id' value='<?= $row['product_id'] ?>'>
                                    <input type='number' name='quantity' placeholder='Quantity'>
                                    <button type='submit' name='add_stock' class="add-button">Add</button>
                                </form>
                            </td>
                            <td><?= $row['import_date'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </main>
    <?php include_once('includes/footer.inc'); ?>
    <script type="text/javascript" src="assets/scripts/script.js"></script>
    <script type="text/javascript" src="assets/scripts/filters.js"></script>
</body>

</html>