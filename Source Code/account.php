<?php 
	session_start();
	include('account_process.php');
	include('settings.php');
	$today = date('l, F j, Y');
	if (isset($_SESSION['user_info']['name']) && $_SESSION['user_info']['name'] !== "Customer") {
        $customer = $_SESSION['user_info']['name'];
		echo "<script>window.location.href='user.php';</script>";
        exit;
    } else {
        $customer = "Customer";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		$page_title = "Account";
		include_once('includes/header.inc');
	?>
</head>
<body class="body2">
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
		<section class="account">
			<div class="account-container" id="account-container">

				<div class="form-container sign-up-container">
					<form class="account-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
						<h2>Sign Up</h2>
						<input type="text" placeholder="Name" name="name"/>
						<input type="email" placeholder="Email" name="email"/>
						<input type="text" placeholder="Phone Number" name="phoneNumber"/>
						<input type="password" placeholder="Password" name="password"/>
						<button type="submit" name="register" class="submit-btn">Sign Up</button>
					</form>
				</div>

				<div class="form-container sign-in-container">
					<form class="account-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
						<h2>Sign In</h2>
						<input type="email" placeholder="Email" name="email"/>
						<input type="password" placeholder="Password" name="password"/>
						<button type="submit" name="login" class="submit-btn">Sign In</button>
					</form>
				</div>

				<div class="panel-container">
					<div class="panel">

						<div class="panel-frame panel-left">
							<h2>Here You Are</h2>
							<p>Let's Go Shopping!</p>
							<a class="button hidden" id="sign-in">Sign In</a>
						</div>

						<div class="panel-frame panel-right">
							<h2>How Are You?</h2>
							<p>Join Us Now!</p>
							<a class="button hidden" id="sign-up">Sign Up</a>
						</div>
					</div>
				</div>
			</div>
		</section>

<?php		
// Registration handling
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $userAccount = new UserAccount("mysql:dbname=$sql_db;host=$host", $user, $pwd);
    $userAccount->register($_POST['name'], $_POST['email'], $_POST['phoneNumber'], $_POST['password']);
}

// Login handling
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $userAccount = new UserAccount("mysql:dbname=$sql_db;host=$host", $user, $pwd);
    $userAccount->login($_POST['email'], $_POST['password']);
}
?>

<?php if (isset($_SESSION['message']) && !empty($_SESSION['message'])): ?>
<script>
  // Display the message
	alert('<?php echo $_SESSION['message']; ?>');
	<?php unset($_SESSION['message']); ?>

  /*setTimeout(function() {
    window.location.href = 'user.php';
  }, 3000);*/
</script>
<?php endif; ?>

	</main>
	
	<?php include_once('includes/footer.inc'); ?>

	<script type="text/javascript" src="scripts/account.js"></script>
</body>
</html>