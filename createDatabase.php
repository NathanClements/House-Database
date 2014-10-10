<?php
	$DBConnect = @mysqli_connect("localhost", "root", "")
		Or die("<p>Unable to connect to the server.</p>"
		. "<p>Error code " . mysqli_errno($DBConnect)
		. ": " . mysqli_error($DBConnect)) . "</p>";

	$SQLstring = "CREATE DATABASE perform";
	$QueryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die("<p>Unable to create the database.</p>"
		. "<p>Error code " . mysqli_errno($DBConnect)
		. ": " . mysqli_error($DBConnect)) . "</p>";

	$SQLstring = "CREATE TABLE house(id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(40),
			description VARCHAR(250), checkStatus BOOL, Retired BOOL, added_by VARCHAR(40),
			containerID SMALLINT, imageURL VARCHAR(40), type VARCHAR(20))";
	$QueryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die("<p>Unable to create the table.</p>"
		. "<p>Error code " . mysqli_errno($DBConnect)
		. ": " . mysqli_error($DBConnect)) . "</p>";

	$SQLstring = "CREATE TABLE users(userID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, username VARCHAR(40),
			password VARCHAR(40), permissions VARCHAR(40), firstName VARCHAR(40), lastName VARCHAR(40),
			email VARCHAR(50))";
	$QueryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die("<p>Unable to create the table.</p>"
		. "<p>Error code " . mysqli_errno($DBConnect)
		. ": " . mysqli_error($DBConnect)) . "</p>";

	$SQLstring = "CREATE TABLE checkout(checkID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, item ID SMALLINT NOT NULL, 
			username VARCHAR(40), dateOut DATE, dateIn DATE)";
	$QueryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die("<p>Unable to create the table.</p>"
		. "<p>Error code " . mysqli_errno($DBConnect)
		. ": " . mysqli_error($DBConnect)) . "</p>";
	
	echo '<p>Successfully created database and all tables</p>';
?>
