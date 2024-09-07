<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $page_title = "All Your Healthy Food";
    include_once('includes/header.inc');
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
            <h2>Transaction History</h2>
            <?php if (isset($payment_details) && !empty($payment_details)) : ?>
                <table border="1">
                    <tr>
                        <th>Payment ID</th>
                        <th>Purchased Date</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Delivery Status</th>
                    </tr>
                    <?php foreach ($payment_details as $payment) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($payment['payment_id']); ?></td>
                            <td><?php echo htmlspecialchars($payment['purchased_date']); ?></td>
                            <td><?php echo htmlspecialchars($payment['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($payment['payment_status']); ?></td>
                            <td>Delivering</td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <p>No payment details found.</p>
            <?php endif; ?>
        </div>
    </main>
    <?php include_once('includes/footer.inc'); ?>
</body>

</html>