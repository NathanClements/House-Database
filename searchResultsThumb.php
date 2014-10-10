<?php
include 'header.php';
permission_check("", "", "", "", "You do not have permission to view items!");
?>

<div class="fluid-row">
	<h3>Items Checked Out</h3>
</div>

<div class="fluid-row">
<ul class="nav nav-tabs">
	<li><a href="searchResults.php">As Table</a></li>
	<li class="active"><a href="#">As Thumbnails</a></li>
</ul>

<?php
	$type=$_SESSION['type'];
	$keywords=$_SESSION['keywords'];
	$SQLstringType = "SELECT * FROM house WHERE type='$type'";
	
	$DBConnect = server_connect($_SESSION['username'], $_SESSION['password'], "<p>Unable to connect to server.</p>");
	database_connect($DBConnect, "<p>Unable to connect to database.</p>");
	$QueryResultType = query($DBConnect, $SQLstringType, "Unable to execute query.");

	if ($type == "dance")
		$typeName = "are no dance items";
	elseif ($type == "music")
		$typeName = "are no music items";
	if ($type == "misc")
		$typeName = "are no miscellaneous items";
	if ($type == "drapes")
		$typeName = "are no drapes";
	if ($type == "theatricalProp")
		$typeName = "are no theatrical props";
	if ($type == "theatricalSet")
		$typeName = "is no theatrical set";
	if ($type == "theatricalCostume")
		$typeName = "are no theatrical costumes";

	if (mysqli_num_rows($QueryResultType) == 0)
		die("<p>There $typeName in the database!</p>"); 

	$numRows = mysqli_num_rows($QueryResultType);
	$count = 0;
	$col = 0;
	
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
				$Retired = $Row['Retired'];
				$addedBy = $Row['added_by'];
				$containerID = $Row['containerID'];
				$imageURL = $Row['imageURL'];

				$dir = 'http://localhost/House/';
				$filename = $dir . $imageURL;
		
				echo '<li class="span3" style="list-style-type: none">';
				echo "<p style='display: block; height: 200px; width: 200px; margin-left: auto; margin-right:auto'><img src='".$filename."' width='180' height='180'></p>";
				echo "<h4 style='height: 30px width: 200px'>$name</h4>";

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
					echo "<td><strong>Action: </strong>
					<form>
					<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value'>
						<option value=''></option>
						<option value='http://localhost/House/unretireitem.php?id=$id'>Un-Retire Item</option>
 					</select>
					</form></td></tr>";
				}
				elseif ($checkStatus) {
					echo "<td><strong>Action: </strong>
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
					echo "<td><strong>Action: </strong>
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
					echo "<td><strong>Action: </strong>
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
			}
			$keyword = strtok(";");
		} while ($keyword != NULL);

		$RowType = mysqli_fetch_assoc($QueryResultType);
		$type = $RowType['type'];
		$description = $RowType['description'];
		$id = $RowType['id'];
		++$count;
		
	} while ($count<$numRows);

	mysqli_free_result($QueryResultType);
	mysqli_close($DBConnect);
?>

</div>

<?php
	include 'footer.php';
?>
