<?php
	include 'header.php';
?>

<?php
	$name=str_replace("'", "\'", $_POST['name']);
	$description=str_replace("'", "\'", $_POST['description']);
	$added_by=$_POST['added_by'];
	$itemType = $_POST['type'];
	$room = $_POST['room'];
	$containertype = $_POST['containertype'];
	$container = $_POST['container'];
	$location = 'In room '.$room.', container '.$container;
	
	$dir = "uploaded/";
	$type = ".jpg";
	$rand = rand(100,20000);
	$filename = $_FILES['image']['name'];
	if($_FILES['image']['error'] == 0) {
		move_uploaded_file ($_FILES['image'] ['tmp_name'], $dir.$name.$rand.$type);
		echo "<p>Photo upload was successful.</p>";
	}
	else 
		echo "<p>Photo upload was unsuccessful.</p>";
?>

<?php
	$DBConnect = server_connect($_SESSION['username'], $_SESSION['password'], "<p>Unable to connect to server</p>");
	database_connect($DBConnect, "<p>Unable to connect to database.</p>");

	$SQLstring = "INSERT INTO house VALUES(NULL, '$name', '$description', 1, 0, '$added_by', '$location', '$dir$name$rand$type', '$itemType')";
	$QueryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die("<p>Unable to execute the query.</p>"
		. "<p>Error code " . mysqli_errno($DBConnect)
		. ": " . mysqli_error($DBConnect)) . "</p>";
	echo "<p>Your item has been added.</p>";
?>


<?php
	include 'footer.php';
?>
