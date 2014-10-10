<?php
include 'header.php';
permission_check("", "", "", "", "You do not have permission to view items!");
?>

<div class="fluid-row">
	<h3>Search Results</h3>
</div>

<div class="fluid-row">
<ul class="nav nav-tabs">
	<li class="active"><a href="#">As Table</a></li>
	<li><a href="searchResultsThumb.php">As Thumbnails</a></li>
</ul>

<?php
	if ((isset($_GET['type'])) && (isset($_GET['keywords']))) {
		$SearchType=$_GET['type'];
		$_SESSION['type']=$SearchType;
		$SearchKeywords=$_GET['keywords'];
		$_SESSION['keywords']=$SearchKeywords;
	}

	$type=$_SESSION['type'];
	$keywords=$_SESSION['keywords'];

	$SQLstringType = "SELECT * FROM house WHERE type='$type'";
	
	$DBConnect = server_connect($_SESSION['username'], $_SESSION['password'], "Unable to connect to server");
	database_connect($DBConnect, "Unable to connect to database");

	$QueryResultType = query($DBConnect, $SQLstringType, "Unable to select the database.");
	
	if ($type == "dance")
		$typeName = "are no dance items";
	elseif ($type == "music")
		$typeName = "are no music items";
	elseif ($type == "misc")
		$typeName = "are no miscellaneous items";
	elseif ($type == "drapes")
		$typeName = "are no drapes";
	elseif ($type == "theatricalProp")
		$typeName = "are no theatrical props";
	elseif ($type == "theatricalSet")
		$typeName = "is no theatrical set";
	elseif ($type == "theatricalCostume")
		$typeName = "are no theatrical costumes";

	if (mysqli_num_rows($QueryResultType) == 0)
		die("<p>There $typeName in the database.</p>");
	
	$numRows = mysqli_num_rows($QueryResultType);
	$count = 0;

	echo "<table class='table' border='1'>";
	echo "<tr><th class='tableIDTitle'>ID</th>
		<th class='tableNameTitle'>Name</th>
		<th class='tableDescriptionTitle'>Description</th>
		<th class='tableCheckTitle'>Checked Out?</th>
		<th class='tableAddedTitle'>Added By</th>
		<th class='tableRetiredTitle'>Retired?</th>
		<th class='tableContainerTitle'>Container ID</th>
		<th class='tableAction'></th></tr>";

	$Row = mysqli_fetch_assoc($QueryResultType);
	$type = $Row['type'];
	$description = $Row['description'];
	$id = $Row['id'];
	$keyword = strtok($keywords, ";");
	do {
		do {
			if (strpos($description, $keyword) !== false) {
				$itemID = $Row['id'];
				$name = $Row['name'];
				$description = $Row['description'];
				$checkStatus = $Row['checkStatus'];
				$addedBy = $Row['added_by'];
				$Retired = $Row['Retired'];
				$containerID = $Row['containerID'];		
		
				echo "<tr><td class='tableID'>$itemID</td>";
				echo "<td class='tableName'><a href='http://localhost/House/itemSearch.php?id=$itemID'>$name</a></td>";
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
		
				echo "<td class='tableContainer'>$containerID</td>";
		
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
			}
			$keyword = strtok(";");
		} while ($keyword != NULL);

		$RowType = mysqli_fetch_assoc($QueryResultType);
		$type = $RowType['type'];
		$description = $RowType['description'];
		$id = $RowType['id'];
		++$count;
	} while ($count<$numRows );
		
	mysqli_free_result($QueryResultType);
	mysqli_close($DBConnect);
?>	
</div>

<?php
	include 'footer.php';
?>
