<?php
session_start();

require 'databaseconnect.php';

// Function to update stock
function updateStock($conn, $product_id, $quantity) {
    // Check if quantity is 0 or empty
    if ($quantity == 0) {
        return "Quantity cannot be 0";
    }

    // Prepare SQL statement to update stock
    $stmt = $conn->prepare("UPDATE Products SET instock = instock + ?, import_date = CURDATE() WHERE product_id = ?");
    $stmt->bind_param("ii", $quantity, $product_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Close the statement
        $stmt->close();
        return true; // Stock updated successfully
    } else {
        // Close the statement
        $stmt->close();
        return false; // Failed to update stock
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_stock'])) {
    // Get product ID and quantity from form
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if quantity is empty
    if (empty($quantity)) {
        $_SESSION['error_message'] = "Quantity cannot be empty!";
    } else {
        // Call the function to update stock
        $updateResult = updateStock($conn, $product_id, $quantity);

        // Check if stock update was successful
        if ($updateResult === true) {
            // Set success message
            $_SESSION['success_message'] = "Stock updated successfully!";
        } elseif ($updateResult === false) {
            // Set error message
            $_SESSION['error_message'] = "Error updating stock!";
        }
    }

    // Redirect to the same page to display the message
    header("Location: addstock.php");
    exit();
}