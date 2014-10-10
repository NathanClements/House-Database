<?php
include 'header.php';
permission_check("", "", "", "", "You do not have permission to view items!");
?>

<div class="fluid-row">
	<h3>Items in Database</h3>
</div>

<div class="fluid-row">
<ul class="nav nav-tabs">
	<li class="active"><a href="#">As Table</a></li>
	<li><a href="ListHouseItemThumb.php">As Thumbnails</a></li>
</ul>

<?php
	$SQLstring = "SELECT * FROM house WHERE checkStatus = '1'";
	
	$DBConnect = server_connect($_SESSION['username'], $_SESSION['password'], "Unable to connect to server");
	database_connect($DBConnect, "Unable to connect to database");

	$QueryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die("<p>Unable to select the database.</p>"
		. "<p>Error code " . mysqli_errno($DBConnect)
		. ": " . mysqli_error($DBConnect)) . "</p>";
	
	if (mysqli_num_rows($QueryResult) == 0)
		die("<p>There are no items in the house!</p>");
	
	$numRows = mysqli_num_rows($QueryResult);
	$count = 0;	
	echo "<table class='table' border='1'>";
	echo "<tr><th class='tableIDTitle'>ID</th>
		<th class='tableNameTitle'>Name</th>
		<th class='tableDescriptionTitle'>Description</th>
		<th class='tableCheckTitle'>Checked Out?</th>
		<th class='tableRetiredTitle'>Retired?</th>
		<th class='tableAddedTitle'>Added By</th>
		<th class='tableContainerTitle'>Location</th>
		<th class='tableAction'></th></tr>";
	$Row = mysqli_fetch_assoc($QueryResult);
	do {
		$id = $Row['id'];
		$name = $Row['name'];
		$description = $Row['description'];
		$checkStatus = $Row['checkStatus'];
		$Retired = $Row['Retired'];
		$addedBy = $Row['added_by'];
		$location = $Row['location'];		

		echo "<tr><td class='tableID'>$id</td>";
		echo "<td class='tableName'><a href='http://localhost/House/itemHouse.php?id=$id'>$name</a></td>";
		echo "<td class='tableDescription'>$description<a HREF=</td>";
		if(!$checkStatus)
			echo "<td class='tableCheck'>Yes</td>";
		else
			echo "<td class='tableCheck'>No</td>";
		if($Retired)
			echo "<td class='tableRetired'>Yes</td>";
		else
			echo "<td class='tableRetired'>No</td>";
		echo "<td class='tableAdded'>$addedBy</td>";
		echo "<td class='tableContainer'>$location</td>";

		if ($Retired) {
			echo "<td class='dropAction'><strong>Action: </strong>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' style='width: 100%'>
						<option value=''></option>
						<option value='http://localhost/House/unretireitem.php?id=$id'>Un-Retire Item</option>
 						</select>
				</form></td></tr>";
		}
			elseif ($checkStatus) {
			echo "<td class='Action'><strong>Action: </strong>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' style='width: 100%'>
						<option value=''></option>
 							<option value='http://localhost/House/checkoutitem.php?id=$id'>Check-out Item</option>
 							<option value='http://localhost/House/setcontainer.php?id=$id'>Set Container</option>
						<option value='http://localhost/House/retireitem.php?id=$id'>Retire Item</option>
 						</select>
				</form></td></tr>";
		}
			elseif (!$checkStatus) {
			echo "<td class='Action'><strong>Action: </strong>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' style='width: 100%'>
						<option value=''></option>
 							<option value='http://localhost/House/checkinitem.php?id=$id'>Check-in Item</option>
 							<option value='http://localhost/House/setcontainer.php?id=$id'>Set Container</option>
						<option value='http://localhost/House/retireitem.php?id=$id'>Retire Item</option>
 						</select>
				</form></td></tr>";
		}
			else {
			echo "<td class='Action'><strong>Action: </strong>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' style='width: 100%'>
						<option value=''></option>
 							<option value='http://localhost/House/checkoutitem.php?id=$id'>Check-out Item</option>
 							<option value='http://localhost/House/checkinitem.php?id=$id'>Check-in Item</option>
 							<option value='http://localhost/House/setcontainer.php?id=$id'>Set Container</option>
						<option value='http://localhost/House/retireitem.php?id=$id'>Retire Item</option>
 						</select>
				</form></td></tr>";
		}


		$Row = mysqli_fetch_assoc($QueryResult);
		++$count;
	} while ($count<$numRows);
	
	mysqli_free_result($QueryResult);
	mysqli_close($DBConnect);
?>	
</div>

<?php
	include 'footer.php';
?>
