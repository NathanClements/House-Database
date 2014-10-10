<?php
function server_connect($user, $pass, $errmsg) {
	$DBConnect = @mysqli_connect("localhost",$user,$pass) 
		Or die("<p>$errmsg</p>");
	return $DBConnect;
}

function database_connect($DBConnect, $errmsg) {
	@mysqli_select_db($DBConnect, perform)
		Or die("<p>$errmsg</p>");
}

function permission_check($permission1, $permission2, $permission3, $permission4, $errmsg) {
	$DBConnect = server_connect("root", "password", "Unable to connect to server");
	database_connect($DBConnect, "Unable to connect to database");
	if(isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$SQLstring = "SELECT * FROM users WHERE username='$username'";
		$QueryResult = @mysqli_query($DBConnect, $SQLstring)
			Or die("<p>Unable to execute the query.</p>"
			. "<p>Error code " . mysqli_errno($DBConnect)
			. ": " . mysqli_error($DBConnect)) . "</p>";
	
		$Row = mysqli_fetch_assoc($QueryResult);
	
		if(($Row['permissions'] == $permission1) || ($Row['permissions'] == $permission2) || ($Row['permissions'] == $permission3) ||($Row['permissions'] == $permission4)) {
			echo "<h3>$errmsg</h3>";
			echo '<meta http-equiv="refresh" content="3; URL=http://localhost/House/home.php">';
		}
	}
	else {
		echo "<h3>You are not logged in! Please login to view or add items.</h3>";
		echo '<meta http-equiv="refresh" content="3; URL=http://localhost/House/home.php">';
	}
}

function query($DBConnect, $SQLstring, $errmsg) {
	$QueryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die("<p>$errmsg</p>"
		. "<p>Error code " . mysqli_errno($DBConnect)
		. ": " . mysqli_error($DBConnect)) . "</p>";
	return $QueryResult;
}

function displayTable ($type, $errmsg) {
	$SQLstring = "SELECT * FROM house WHERE type='$type'";
	
	$DBConnect = server_connect($_SESSION['username'], $_SESSION['password'], "Unable to connect to server");
	database_connect($DBConnect, "Unable to connect to database");

	$QueryResult = query($DBConnect, $SQLstring, "Unable to select the database.");
	
	if (mysqli_num_rows($QueryResult) == 0)
		die("<p>There $errmsg in the database!</p>");
	
	$numRows = mysqli_num_rows($QueryResult);
	$count = 0;

	echo "<table class='table' border='1'>";
	echo "<tr><th class='tableIDTitle'>ID</th>
		<th class='tableNameTitle'>Name</th>
		<th class='tableDescriptionTitle'>Description</th>
		<th class='tableCheckTitle'>Checked Out?</th>
		<th class='tableAddedTitle'>Added By</th>
		<th class='tableRetiredTitle'>Retired?</th>
		<th class='tableContainerTitle'>Location</th>
		<th class='tableAction'></th></tr>";

	$Row = mysqli_fetch_assoc($QueryResult);
	$itemID = $Row['id'];
	do {		
		$itemID = $Row['id'];
		$name = $Row['name'];
		$description = $Row['description'];
		$checkStatus = $Row['checkStatus'];
		$Retired = $Row['Retired'];
		$addedBy = $Row['added_by'];
		$location = $Row['location'];		

		echo "<tr><td class='tableID'>$itemID</td>";
		echo "<td class='tableName'><a href='http://localhost/House/item.php?id=$itemID&type=$type'>$name</a></td>";
		echo "<td class='tableDescription'>$description<a HREF=</td>";
		if(!$checkStatus)
			echo "<td class='tableCheck'>Yes</td>";
		else
			echo "<td class='tableCheck'>No</td>";
		echo "<td class='tableAdded'>$addedBy</td>";
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
}

function displayThumb($type, $errmsg) {
	$SQLstring = "SELECT * FROM house WHERE type='$type'";
	
	$DBConnect = server_connect($_SESSION['username'], $_SESSION['password'], "Unable to connect to server. Check you are still logged in.");
	database_connect($DBConnect, "Unable to connect to database. Check connection.");
	$QueryResult = query($DBConnect, $SQLstring, "Unable to execute query.");

	if (mysqli_num_rows($QueryResult) == 0)
		die("<p>There are no items in the database!</p>"); 

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
		
		echo '<li style="list-style-type: none; border-bottom: dotted; border-width: 1px; margin-bottom: 30px">';
		echo "<p style='display: block; height: 200px; width: 200px; margin-left: auto; margin-right:auto'><img src='".$filename."' width='180' height='180'></p>";
		echo "<h4 style='height: 30px width: 100%'>$name</h4>";

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

		echo "<p style='height: 30px width: 100%'><strong>$location</strong></p>";

		echo '<div class="center"><p style="height: 130px; width: 250px; word-wrap: break-word">'.$description.'</p></div>';
		echo '<div>';
		if ($Retired) {
			echo "<strong>Action: </strong>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value'>
						<option value=''></option>
						<option value='http://localhost/House/item.php?id=$id&type=$type'>Un-Retire Item</option>
 					</select>
				</form>";
		}
			elseif ($checkStatus) {
			echo "<strong>Action: </strong>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value'>
						<option value=''></option>
 						<option value='http://localhost/House/checkoutitem.php?id=$id'>Check-out Item</option>
 						<option value='http://localhost/House/setcontainer.php?id=$id'>Set Container</option>
						<option value='http://localhost/House/retireitem.php?id=$id'>Retire Item</option>
 					</select>
				</form>";
		}
			elseif (!$checkStatus) {
			echo "<strong>Action: </strong>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value'>
						<option value=''></option>
 						<option value='http://localhost/House/checkinitem.php?id=$id'>Check-in Item</option>
 						<option value='http://localhost/House/setcontainer.php?id=$id'>Set Container</option>
						<option value='http://localhost/House/retireitem.php?id=$id'>Retire Item</option>
 					</select>
				</form>";
		}
			else {
			echo "<strong>Action: </strong>
				<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value'>
						<option value=''></option>
 						<option value='http://localhost/House/checkoutitem.php?id=$id'>Check-out Item</option>
 						<option value='http://localhost/House/checkinitem.php?id=$id'>Check-in Item</option>
 						<option value='http://localhost/House/setcontainer.php?id=$id'>Set Container</option>
						<option value='http://localhost/House/retireitem.php?id=$id'>Retire Item</option>
 					</select>
				</form>";
		}
		echo '<br /></div></li>';
		$Row = mysqli_fetch_assoc($QueryResult);
		++$count;
		
	} while ($count<$numRows);

	mysqli_free_result($QueryResult);
	mysqli_close($DBConnect);
	echo '</div>';
}
?>
