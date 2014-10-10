<?php
include 'header.php';

permission_check("", "", "", "", "You do not have permission to view items!");
?>

<div class="fluid-row">
	<h3>Items Checked Out</h3>
</div>

<div class="fluid-row">
<ul class="nav nav-tabs">
	<li class="active"><a href="#">As Table</a></li>
	<li><a href="ListCheckItemThumb.php">As Thumbnails</a></li>
</ul>

<?php
	$SQLstring = "SELECT * FROM house WHERE checkStatus='0'";
	
	$DBConnect = server_connect($_SESSION['username'], $_SESSION['password'], "Unable to connect to server");
	database_connect($DBConnect, "Unable to connect to database");

	$QueryResult = query($DBConnect, $SQLstring, "Unable to select the database.");
	
	if (mysqli_num_rows($QueryResult) == 0)
		die("<p>There are no checked out items in the database!</p>");
	
	$numRows = mysqli_num_rows($QueryResult);
	$count = 0;

	echo "<table class='table' border='1'>";
	echo "<tr><th class='tableIDTitle'>ID</th>
		<th class='tableNameTitle'>Name</th>
		<th class='tableDescriptionTitle'>Description</th>
		<th class='tableCheckTitle'>Checked Out?</th>
		<th class='tableAddedTitle'>Checked Out By</th>
		<th class='tableRetiredTitle'>Retired?</th>
		<th class='tableContainerTitle'>Location</th>
		<th class='tableAction'></th></tr>";

	$Row = mysqli_fetch_assoc($QueryResult);
	$itemID = $Row['id'];
	do {
		$SQLstring2 = "SELECT * FROM checkout WHERE itemid=$itemID";
		$QueryResult2 = query($DBConnect, $SQLstring2, "Unable to execute query!");

		$RowUser = mysqli_fetch_assoc($QueryResult2);
		
		$itemID = $Row['id'];
		$name = $Row['name'];
		$description = $Row['description'];
		$checkStatus = $Row['checkStatus'];
		$Retired = $Row['Retired'];
		$Checkedby = $RowUser['userName'];
		$location = $Row['location'];		

		echo "<tr><td class='tableID'>$itemID</td>";
		echo "<td class='tableName'><a href='http://localhost/House/itemCheck.php?id=$itemID'>$name</a></td>";
		echo "<td class='tableDescription'>$description<a HREF=</td>";
		if(!$checkStatus)
			echo "<td class='tableCheck'>Yes</td>";
		else
			echo "<td class='tableCheck'>No</td>";
		echo "<td class='tableAdded'>$Checkedby</td>";
		if($Retired)
			echo "<td class='tableRetired'>Yes</td>";
		else
			echo "<td class='tableRetired'>No</td>";

		echo "<td class='tableContainer'>$location</td>";

		if ($Retired) {
			echo "<td class='tableAction'><strong>Action: </strong>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' style='width:100%'>
						<option value=''></option>
						<option value='http://localhost/House/unretireitem.php?id=$itemID' style='font-size:1vw'>Un-Retire Item</option>
 					</select>
				</form></td></tr>";
		}
			elseif ($checkStatus) {
			echo "<td class='tableAction'><strong>Action: </strong>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' style='width:100%'>
						<option value=''></option>
 						<option value='http://localhost/House/checkout.php?id=$itemID' style='font-size:1vw'>Check-out Item</option>
 						<option value='http://localhost/House/setcontainer.php?id=$itemID' style='font-size:1vw'>Set Container</option>
						<option value='http://localhost/House/retireitem.php?id=$itemID' style='font-size:1vw'>Retire Item</option>
 					</select>
				</form></td></tr>";
		}
			elseif (!$checkStatus) {
			echo "<td class='tableAction'><strong>Action: </strong>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' style='width:100%'>
						<option value=''></option>
 						<option value='http://localhost/House/checkin.php?id=$itemID' style='font-size:1vw'>Check-in Item</option>
 						<option value='http://localhost/House/setcontainer.php?id=$itemID' style='font-size:1vw'>Set Container</option>
						<option value='http://localhost/House/retireitem.php?id=$itemID' style='font-size:1vw'>Retire Item</option>
 					</select>
				</form></td></tr>";
		}
			else {
			echo "<td class='tableAction'><strong>Action: </strong>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' style='width:100%'>
						<option value=''></option>
 						<option value='http://localhost/House/checkout.php?id=$itemID' style='font-size:1vw'>Check-out Item</option>
 						<option value='http://localhost/House/checkin.php?id=$itemID' style='font-size:1vw'>Check-in Item</option>
 						<option value='http://localhost/House/setcontainer.php?id=$itemID' style='font-size:1vw'>Set Container</option>
						<option value='http://localhost/House/retireitem.php?id=$itemID' style='font-size:1vw'>Retire Item</option>
 					</select>
				</form></td></tr>";
		}

		$Row = mysqli_fetch_assoc($QueryResult);
		$itemID = $Row['id'];
		++$count;
	} while ($count<$numRows);
	
	mysqli_free_result($QueryResult);
	mysqli_close($DBConnect);
?>	
</div>

<?php
	include 'footer.php';
?>
