<?php
session_start();
$_SESSION['username'] = "";
$_SESSION['password'] = "";
?>
<?php
include 'header.php';
?>

<?php
	if (isset($_POST['username']) && isset($_POST['password'])) {
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
	

		$DBConnect = @mysqli_connect("localhost", $_SESSION['username'], $_SESSION['password'])
				Or die("<p>Login failed! Please retry by pressing your browser's Back button.</p>");
			@mysqli_select_db($DBConnect, "perform")
				Or die("<p>Login failed! Please retry by pressing your browser's Back button.</p>");
			echo "<p><strong>Login Successful!</strong></p>";

		header("Location: http://localhost/House/addItem.php");
	}

	elseif (empty($_POST['username']) || empty($_POST['password'])) {
		echo "<p>Please enter both your username and password!</p>";
	}

	//mysqli_close($DBConnect);

?>

<form action="addItemLogin.php" method="post" enctype="application/x-www-form-urlencoded">
	<p><label>User Name: </label><input type="text" name="username" /><p>
	<p><label>Password: </label><input type="password" name="password" /<p>
	<p><input type="submit" value="Login" /></p>
</form>

<?php
include 'footer.php';
?>
