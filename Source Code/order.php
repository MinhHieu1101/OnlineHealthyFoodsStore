<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $page_title = "All Your Healthy Food";
    include_once('includes/header.inc');
    // Include database connection
    require 'databaseconnect.php';

    // Retrieve user ID from session
    $user_id = $_SESSION['user_id'];

    // Retrieve payment details for the current user
    $sql = "SELECT * FROM Payment WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any payment details
    if ($result->num_rows > 0) {
        $payment_details = $result->fetch_all(MYSQLI_ASSOC);
    } else {
    }

    $stmt->close();

    // Close database connection
    $conn->close();
    ?>
</head>

<body>
    <?php include_once('includes/menu.inc'); ?>
    <main id="main" class="flexlayout-column">
        <div class="ayhf-body">
            <!-- Main Content Section -->
            <section class="content">
                <!-- User Information Section -->
                <div class="info">
                    <div class="cover-image">
                        <img src="images/cover-image.jpg" alt="Cover Image">
                    </div>

                    <div class="profile">
                        <!-- Profile Image and Information -->
                        <div class="profile-image">
                            <img src="images/profile-image.png" alt="Profile Image">
                        </div>
                        <div class="profile-info">
                            <h2 class = "username-page">A Random User</h2>
                            <p class = "userid-page">ID: 123456</p>
                        </div>
                    </div>

                    <hr class="line">

                    <!-- Profile Menu Links -->
                    <div class="profile-menu">
                        <a href="user.php" class="menu-item">Personal Details</a>
                        <a href="order.php" class="menu-item">Transactions</a>
                        <a href="account.php" class="menu-item">Log Out</a>
                    </div>
                </div>

                <!-- Transaction History Table Section -->
                <div class="transaction-title">
                    <h2 class="title_effect">TRANSACTION HISTORY</h2>
                </div>

                <div class="res-table">
                    <table class="transaction-table">
                        <thead>
                            <!-- Table Header Row -->
                            <tr>
                                <th>Payment ID</th>
                                <th>Purchased Date</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Delivery Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($transactions)) : ?>
                                <?php foreach ($transactions as $transaction) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($payment['payment_id']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['purchased_date']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['payment_method']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['payment_status']); ?></td>
                                        <td>Delivering</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5">You have not made any order.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
    <?php include_once('includes/footer.inc'); ?>
    <!-- JavaScript Script Link -->
    <script type="text/javascript" src="assets/scripts/script.js"></script>
</body>

</html>