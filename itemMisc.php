<?php
include 'header.php';
?>

<?php
$id=$_GET['id'];

$SQLstring = "SELECT * FROM house WHERE id=$id";
$DBConnect = server_connect($_SESSION['username'], $_SESSION['password'], "Unable to connect to server!");
database_connect($DBConnect, "Unable to connect to database!");
$QueryResult = query($DBConnect, $SQLstring, "Unable to execute query!");


$Row = mysqli_fetch_assoc($QueryResult);
$name = $Row['name'];
$description = $Row['description'];
$imageURL = $Row['imageURL'];
$dir = 'http://localhost/House/';
$filename = $dir . $imageURL;


echo "<h3 style='display: block; text-align: center'>$name</h3>";
echo "<p><img src='".$filename."' width='380' height='380' style='display: block; margin-left: auto; margin-right:auto'></p>";
echo "<h3 style='display: block; text-align: center'>$description</h3>";
?>

<form action="ListMiscItem.php">
	<input type="submit" value="Back">
</form>

<?php
include 'footer.php';
?>
