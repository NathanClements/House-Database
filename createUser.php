<?php
include 'header.php';
if((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin'] == 1) && ($_SESSION['username'] == "Nathan") && ($_SESSION['password'] == "Warhammer40K")) {
}
else {
	header('Location: http://localhost/House/home.php');
}
?>
<?php
	if((isset($_POST['newusername'])) && (isset($_POST['newpassword'])) && (isset($_POST['permission']))) {
		$newuser = $_POST['newusername'];
		$newpass = $_POST['newpassword'];
		$confirmpass = $_POST['confirmpassword'];
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$email = $_POST['email'];
		$permission = $_POST['permission'];
		$_SESSION['permission'] = $permission;

		$DBConnect = server_connect("root", "password", "Unable to connect to server!");
		database_connect($DBConnect, "Unable to connect to database!");

		$SQLstring = "SELECT * FROM users WHERE username = '$newuser'";
		$QueryResult = query($DBConnect, $SQLstring, "Unable to execute query.")
			Or die("<p>Unable to execute query.</p>"
			. "<p>Error code " . mysqli_errno($DBConnect)
			. ": " . mysqli_error($DBConnect)) . "</p>";
			
		$numRows = mysqli_num_rows($QueryResult);

		if ($numRows > 0) {
			echo "<p>Username already taken</p>";
			$newuser = "";
		} 
		else {
			if(filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
				echo "<p>Invalid email!<p>";
				$email = "";
			}

			else {
				if($newpass != $confirmpass)
					echo "<p>Passwords do not match!</p>";

				else {
					if((strlen($newpass) < 6) || (strlen($newpass) > 16)) {
						echo "<p>Password must be between 6 and 16 characters!</p>";
						$newpass = "";
					}

					else {
						if(strlen($newuser) > 16) {
							echo "<p>Username must be less than 16 characters!</p>";
							$newuser = "";
						}
	
						else {
							$host = "%";
		
							$SQLstring = "CREATE USER '$newuser'@'$host' IDENTIFIED BY '$newpass'";
	
							$QueryResult = @mysqli_query($DBConnect, $SQLstring)
								Or die("<p>Unable to create new user.</p>"
								. "<p>Error code " . mysqli_errno($DBConnect)
								. ": " . mysqli_error($DBConnect)) . "</p>";
			
							if($permission == "admin") {
								$SQLstring = "GRANT ALL ON perform.* TO ";
								$SQLstring .= $newuser;
								$SQLstring .= "@'%' IDENTIFIED BY '". $newpass. "'";
							}
	
							elseif($permission == "PaCommittee") {
								$SQLstring = "GRANT DELETE, INDEX, INSERT, SELECT, UPDATE, USAGE ON perform.* TO ";
								$SQLstring .= $newuser;
								$SQLstring .= "@'%' IDENTIFIED BY '". $newpass. "'";
							}

							elseif($permission == "producer") {
								$SQLstring = "GRANT INSERT, UPDATE, SELECT ON perform.* TO ";
								$SQLstring .= $newuser;
								$SQLstring .= "@'%' IDENTIFIED BY '". $newpass. "'";
							}

							elseif($permission == "PaMember") {
								$SQLstring = "GRANT SELECT ON perform.* TO ";
								$SQLstring .= $newuser;
								$SQLstring .= "@'%' IDENTIFIED BY '". $newpass. "'";
							}

							$QueryResult = @mysqli_query($DBConnect, $SQLstring) 
								Or die("<p>Unable to grant privileges</p>"
								. "<p>Error code " . mysqli_errno($DBConnect)
								. ": " . mysqli_error($DBConnect)) . "</p>";
	
							$SQLstring = "INSERT INTO users VALUES(NULL, '$newuser', '$newpass', '$permission', '$firstName', '$lastName', '$email')";
							$QueryResult = @mysqli_query($DBConnect, $SQLstring)
								Or die("<p>Unable to execute the query.</p>"
								. "<p>Error code " . mysqli_errno($DBConnect)
								. ": " . mysqli_error($DBConnect)) . "</p>";
	
	
							echo '<meta http-equiv="refresh" content="0; URL=http://localhost/House/createUserSuccess.php">';
	
							mysqli_close($DBConnect);
						}
					}
				}
			}
		}
	}
?>

<form method="post" action="createUser.php" enctype="multipart/form-data">
	<fieldset>
	<legend>Create User</legend>
	<p><label>Username</label>
	<input type="text" name="newusername" value="<?php if(isset($newuser)) echo $newuser ?>" class="span5" placeholder="Type username here ..." /></p>
	<p><label>Password (between 6 and 16 characters)</label>
	<input type="password" name="newpassword" value="<?php if(isset($newpass)) echo $newpass ?>" class="span5" placeholder="Type password here ..." /></p>
	<p><label>Confirm Password</label>
	<input type="password" name="confirmpassword" class="span5" placeholder="Type password here ..." /></p>
	<p><label>First Name</label>
	<input type="text" name="firstName" value="<?php if(isset($firstName)) echo $firstName ?>" class="span5" placeholder="Type first name here ..." /></p>
	<p><label>Last Name</label>
	<input type="text" name="lastName" value="<?php if(isset($lastName)) echo $lastName ?>" class="span5" placeholder="Type last name here ..." /></p>
	<p><label>E-mail</label>
	<input type="email" name="email" value="<?php if(isset($email)) echo $email ?>" class="span5" placeholder="Type email here ..." /></p>
	<p><label>Permission</label>
	<input type="radio" id="radio1" name="permission" value="admin" />
		<label for="radio1">Administrator</label>
	<input type="radio" id="radio2" name="permission" value="PaCommittee" />
		<label for="radio2">PA Committee</label>
	<input type="radio" id="radio3" name="permission" value="producer" />
		<label for="radio3">Producer</label>
	<input type="radio" id="radio4" name="permission" value="PaMember" />
		<label for="radio4">PA Member</label></p><br/>
	<p><input type="submit" value="Create" class="btn span5" /></p>
</form>

<?php
include 'footer.php';
?>
