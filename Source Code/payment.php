<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $page_title = "All Your Healthy Food";
    include_once('includes/header.inc');
    ?>
    <script src="scripts/payment.js"></script>
    <style>
        .error {
            color: red;
        }
    </style>

    <?php
    require 'databaseconnect.php';

    // Initialize error messages
    $visa_number_error = $cvc_error = $due_date_error = '';
    $visa_info_error = false;

    // Process form submission when user clicks "Purchase Now"
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['purchase_now'])) {
        // Handle payment processing based on selected payment method
        $payment_method = $_POST['payment_method'];

        if ($payment_method == 'COD') {
            if(isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $purchased_date = date("Y-m-d");
                $payment_status = 'Pending';

                // Prepare and execute SQL statement to insert payment record for COD
                $stmt = $conn->prepare("INSERT INTO Payment (user_id, purchased_date, payment_method, payment_status) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("isss", $user_id, $purchased_date, $payment_method, $payment_status);

                if ($stmt->execute()) {
                    // Retrieve the payment_id of the newly inserted record
                    $payment_id = $conn->insert_id;
                
                    // Redirect to payment page with success message
                    header("Location: payment.php?success=Payment%20processed%20successfully!");
                    exit();
                } else {
                    echo "Error processing payment. Please try again.";
                }

                $stmt->close();
            } else {
                echo "User not logged in. Please log in first.";
            }
        } elseif ($payment_method == 'VISA') {
            // Initialize error variables
            $visa_info_error = false;

            // Validate VISA information
            $visa_number = $_POST['visa_number'];
            $cvc = $_POST['cvc'];
            $due_date = $_POST['due_date'];

            // Check if all fields are filled
            if (!empty($visa_number) && !empty($cvc) && !empty($due_date)) {
                // Check if VISA number is exactly 16 digits
                if (strlen($visa_number) === 16 && ctype_digit($visa_number)) {
                    // Check if CVC is exactly 3 or 4 digits
                    if ((strlen($cvc) === 3 || strlen($cvc) === 4) && ctype_digit($cvc)) {
                        // Check if due_date is in MM/YY format
                        $date_parts = explode('/', $due_date);
                        if (count($date_parts) === 2 && strlen($date_parts[0]) === 2 && strlen($date_parts[1]) === 2 && ctype_digit($date_parts[0]) && ctype_digit($date_parts[1])) {
                            // Check if due_date is not expired
                            $current_month = date('m');
                            $current_year = date('y');
                            $expiry_month = intval($date_parts[0]);
                            $expiry_year = intval($date_parts[1]);
                            if ($expiry_year > $current_year || ($expiry_year == $current_year && $expiry_month >= $current_month)) {
                                $user_id = $_SESSION['user_id'];
                                $purchased_date = date("Y-m-d"); // Current date
                                $payment_status = 'Completed';

                                // Prepare and execute SQL statement to update payment table
                                $stmt = $conn->prepare("INSERT INTO Payment (user_id, purchased_date, payment_method, payment_status) VALUES (?, ?, ?, ?)");
                                $stmt->bind_param("ssss", $user_id, $purchased_date, $payment_method, $payment_status);

                                // Redirect to invoice page
                                if ($stmt->execute()) {
                                    // Retrieve the payment_id of the newly inserted record
                                    $payment_id = $conn->insert_id;

                                    $hashed_visa_number = hash('sha256', $visa_number);
                                    $hashed_cvc = hash('sha256', $cvc);

                                    // Insert Visa information into the database
                                    $stmt = $conn->prepare("INSERT INTO visainfo (user_id, visa_number, cvc, due_date) VALUES (?, ?, ?, ?)");
                                    $stmt->bind_param("isss", $user_id, $hashed_visa_number, $hashed_cvc, $due_date);

                                    if ($stmt->execute()) {
                                        // Retrieve the payment_id of the newly inserted record
                                        $payment_id = $conn->insert_id;
                                    
                                        // Redirect to payment page with success message
                                        header("Location: payment.php?success=Payment%20processed%20successfully!");
                                        exit();
                                    } else {
                                        echo "Error processing payment. Please try again.";
                                    }
                                } else {
                                    echo "Error processing payment. Please try again.";
                                }
                                exit();
                            } else {
                                $due_date_error = "The VISA is expired.";
                            }
                        } else {
                            $due_date_error = "Invalid due date format (MM/YY).";
                        }
                    } else {
                        $cvc_error = "CVC/CVV must be exactly 3 or 4 digits.";
                    }
                } else {
                    $visa_number_error = "VISA number must be exactly 16 digits.";
                }
            } else {
                $visa_info_error = true;
                $visa_info_error_message = "Please fill in all VISA information fields.";
            }
        }
    }

    // Close database connection
    $conn->close();
    ?>
</head>

<body>
    <?php include_once('includes/menu.inc'); ?>
    <main id="main" class="flexlayout-column">
        <div class="ayhf-body">
            <h2>Payment</h1>
                <?php if(isset($_GET['success'])): ?>
                    <div class="success-message"><?php echo $_GET['success']; ?></div>
                <?php endif; ?>
                <h3>Total Price: 500$</h3><br>
                <div>
                    <h3>Choose Payment Method</h3>
                    <form class="payment-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="radio" name="payment_method" value="COD" id="payment_method_COD" <?php if (!$visa_info_error && (!isset($_POST['payment_method']) || $_POST['payment_method'] == 'COD')) echo "checked"; ?>>
                        <label for="payment_method_COD">Cash-on-Delivery (COD)</label><br>
                        <input type="radio" name="payment_method" value="VISA" id="payment_method_VISA" <?php if ($visa_info_error || (isset($_POST['payment_method']) && $_POST['payment_method'] == 'VISA')) echo "checked"; ?>>
                        <label for="payment_method_VISA">VISA</label><br>

                        <div id="visa_info" class="visa_info" style="display: <?php echo ($visa_info_error || (isset($_POST['payment_method']) && $_POST['payment_method'] == 'VISA')) ? 'block' : 'none'; ?>;">
                            <label for="visa_number">VISA Number:</label>
                            <input type="text" id="visa_number" name="visa_number" placeholder="Enter VISA Number" value="<?php echo isset($_POST['visa_number']) ? $_POST['visa_number'] : ''; ?>">
                            <span class="error"><?php echo $visa_number_error; ?></span><br>

                            <label for="cvc">CVC:</label>
                            <input type="password" id="cvc" name="cvc" placeholder="Enter CVC" value="<?php echo isset($_POST['cvc']) ? $_POST['cvc'] : ''; ?>">
                            <span class="error"><?php echo $cvc_error; ?></span><br>

                            <label for="due_date">Due Date (MM/YY):</label>
                            <input type="text" id="due_date" name="due_date" placeholder="Enter Due Date" value="<?php echo isset($_POST['due_date']) ? $_POST['due_date'] : ''; ?>">
                            <span class="error"><?php echo $due_date_error; ?></span><br>
                        </div>

                        <?php if ($visa_info_error) : ?>
                            <span class="error"><?php echo $visa_info_error_message; ?></span><br>
                        <?php endif; ?>

                        <br>
                        <button type="submit" name="purchase_now" class="purchase-now">Purchase Now</button>
                    </form>
                </div>
        </div>
    </main>
    <?php include_once('includes/footer.inc'); ?>
</body>

</html>