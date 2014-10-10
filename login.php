<?php
ob_start();
$_SESSION['username'] = "";
$_SESSION['password'] = "";
$_SESSION['loggedin'] = 0;

include 'header.php';
?>

<?php
	if (isset($_POST['username']) && isset($_POST['password'])) {
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
	
		$DBConnect = server_connect($_SESSION['username'], $_SESSION['password'], "Login failed! Please retry by pressing your browser's Back button.");
		database_connect($DBConnect, "Login failed! Please retry by pressing your browser's Back button.");

		$_SESSION['loggedin']=1;
		header('Location: loginSuccess.php');
	}

	elseif (empty($_POST['username']) || empty($_POST['password'])) {
		echo "<p>Please enter both your username and password!</p>";
	}

	//mysqli_close($DBConnect);

?>

<form action="login.php" method="post" enctype="application/x-www-form-urlencoded">
	<p><label>User Name: </label><input type="text" name="username" /><p>
	<p><label>Password: </label><input type="password" name="password" /<p>
	<p><input type="submit" value="Login" /></p>
</form>

<?php
include 'footer.php';
?>
