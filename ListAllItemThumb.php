<?php
include 'header.php';
permission_check("", "", "", "", "You do not have permission to view items!");
?>

<div class="fluid-row">
	<h3>Items in Database</h3>
</div>

<div class="fluid-row">
<ul class="nav nav-tabs">
	<li><a href="ListAllItem.php">As Table</a></li>
	<li class="active"><a href="#">As Thumbnails</a></li>
</ul>

<?php
	$SQLstring = "SELECT * FROM house";
	
	$DBConnect = server_connect($_SESSION['username'], $_SESSION['password'], "<p>Unable to connect to server.</p>");
	database_connect($DBConnect, "<p>Unable to connect to database.</p>");
	$QueryResult = query($DBConnect, $SQLstring, "Unable to execute query.");

	if (mysqli_num_rows($QueryResult) == 0)
		die("<p>There are no items in the house!</p>"); 

	$numRows = mysqli_num_rows($QueryResult);
	$count = 0;
	$col = 0;
	
	$Row = mysqli_fetch_assoc($QueryResult);
	
	do {
		$id = $Row['id'];
		$name = $Row['name'];
		$description = $Row['description'];
		$checkStatus = $Row['checkStatus'];
		$Retired = $Row['Retired'];
		$addedBy = $Row['added_by'];
		$location = $Row['location'];
		$imageURL = $Row['imageURL'];

		$dir = 'http://localhost/House/';
		$filename = $dir . $imageURL;

		echo '<li class="span3" style="list-style-type: none; border-bottom: dotted; border-width: 1px; margin-bottom: 30px">';
		echo "<p style='display: block; height: 200px; width: 200px; margin-left: auto; margin-right:auto'><img src='".$filename."' width='180' height='180'></p>";
		echo "<h4 style='height: 30px; width: 200px'>$name</h4>";

		if($checkStatus && !$Retired)
    		{
        		echo '<span class="label label-success">In House</span>';
    		}
    		elseif(!$checkStatus && !$Retired)
    		{
        		echo '<span class="label label-warning">Checked Out</span>';
    		}
    		elseif($Retired)
    		{
        		echo '<span class="label label-important">Retired</span>';
    		}

		echo '<div style="font-size:0.85em"><p style="height: 130px; width: 250px; word-wrap: break-word">'.$description.'</p></div>';

		if ($Retired) {
			echo "<td><h5>Action: </h5>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value'>
						<option value=''></option>
						<option value='http://localhost/House/unretireitem.php?id=$id'>Un-Retire Item</option>
 						</select>
				</form></td></tr>";
		}
			elseif ($checkStatus) {
			echo "<td><h5>Action: </h5>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value'>
						<option value=''></option>
 							<option value='http://localhost/House/checkoutitem.php?id=$id'>Check-out Item</option>
 							<option value='http://localhost/House/setcontainer.php?id=$id'>Set Container</option>
						<option value='http://localhost/House/retireitem.php?id=$id'>Retire Item</option>
 						</select>
				</form></td></tr>";
		}
			elseif (!$checkStatus) {
			echo "<td><h5>Action: </h5>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value'>
						<option value=''></option>
 							<option value='http://localhost/House/checkinitem.php?id=$id'>Check-in Item</option>
 							<option value='http://localhost/House/setcontainer.php?id=$id'>Set Container</option>
						<option value='http://localhost/House/retireitem.php?id=$id'>Retire Item</option>
 						</select>
				</form></td></tr>";
		}
			else {
			echo "<td><h5>Action: </h5>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value'>
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
	echo '</div>';
?>

<?php
include 'footer.php';
?>
