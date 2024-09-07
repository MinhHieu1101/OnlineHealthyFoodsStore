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

        // Fetch user information from the database
        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
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
                            <h2 class = "username-page"><?php echo htmlspecialchars($user['username']); ?></h2>
                            <p class = "userid-page"><?php echo 'ID: ' . htmlspecialchars($user['user_id']); ?></p>
                        </div>
                    </div>

                    <hr class="line">

                    <!-- Profile Menu Links -->
                    <div class="profile-menu">
                        <a href="user.php" class="menu-item">Personal Details</a>
                        <a href="order.php" class="menu-item">Transactions</a>
                        <a href="logout.php" class="menu-item">Log Out</a>
                    </div>
                </div>

                <!-- User Details Section -->
                <div class="user-details">
                    <h2 class="title_effect">USER PROFILE</h2>
                    <!-- User Card Details -->
                    <div class="card">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td>:</td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                </tr>
                                <tr>
                                    <td>Date Joined</td>
                                    <td>:</td>
                                    <td><?php echo htmlspecialchars($user['phoneno']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php include_once('includes/footer.inc'); ?>
    <!-- JavaScript Script Link -->
    <script type="text/javascript" src="assets/scripts/script.js"></script>
    <script type="text/javascript" src="assets/scripts/filters.js"></script>
</body>

</html>