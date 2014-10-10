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
		<li><a href="ListAllItemThumb.php">As Thumbnails</a></li>
	</ul>
</div>

<?php
	$SQLstring = "SELECT * FROM house";
	
	$DBConnect = server_connect($_SESSION['username'], $_SESSION['password'], "Unable to connect to server");
	database_connect($DBConnect, "Unable to connect to database");

	$QueryResult = query($DBConnect, $SQLstring, "Unable to select the database.");
	
	if (mysqli_num_rows($QueryResult) == 0)
		die("<p>There are no items in the database!</p>");
	
	$numRows = mysqli_num_rows($QueryResult);
	$count = 0;
?>
	<section class='table-wrapper'>
		<table class='table table-bordered table-condensed cf' border='1'>
			<thead class="cf">	
				<tr><th>ID</th>
				<th>Name</th>
				<th>Description</th>
				<th>Checked Out?</th>
				<th>Retired?</th>
				<th>Added By</th>
				<th>Location</th>
				<th></th></tr>
			</thead>
			<tbody>
				<?php
					$Row = mysqli_fetch_assoc($QueryResult);
					do {
						$id = $Row['id'];
						$name = $Row['name'];
						$description = $Row['description'];
						$checkStatus = $Row['checkStatus'];
						$Retired = $Row['Retired'];
						$addedBy = $Row['added_by'];
						$location = $Row['location'];		

						echo "<tr><td>$id</td>";
						echo "<td><a href='http://localhost/House/itemAll.php?id=$id'>$name</a></td>";
						echo "<td>$description<a HREF=</td>";
						if(!$checkStatus)
							echo "<td>Yes</td>";
						else
							echo "<td>No</td>";
						if($Retired)
							echo "<td>Yes</td>";
						else
							echo "<td>No</td>";
						echo "<td>$addedBy</td>";
						echo "<td>$location</td>";
						if ($Retired) {
							echo "<td><strong>Action: </strong>
							<form>
								<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' style='width:100%'>
									<option value=''></option>
									<option value='http://localhost/House/unretireitem.php?id=$id'>Un-Retire Item</option>
 								</select>
							</form></td></tr>";
						}
						elseif ($checkStatus) {
							echo "<td><strong>Action: </strong>
							<form>
								<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' style='width:100%'>
									<option value=''></option>
 									<option value='http://localhost/House/checkout.php?id=$id'>Check-out Item</option>
 									<option value='http://localhost/House/setcontainer.php?id=$id'>Set Container</option>
									<option value='http://localhost/House/retireitem.php?id=$id'>Retire Item</option>
 								</select>
							</form></td></tr>";
						}
						elseif (!$checkStatus) {
							echo "<td><strong>Action: </strong>
							<form>
								<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' style='width:100%'>
									<option value=''></option>
 									<option value='http://localhost/House/checkin.php?id=$id'>Check-in Item</option>
 									<option value='http://localhost/House/setcontainer.php?id=$id'>Set Container</option>
									<option value='http://localhost/House/retireitem.php?id=$id'>Retire Item</option>
 								</select>
							</form></td></tr>";
						}
						else {
							echo "<td><strong>Action: </strong>
							<form>
								<select name='URL' onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' style='width:100%'>
									<option value=''></option>
 									<option value='http://localhost/House/checkout.php?id=$id'>Check-out Item</option>
 									<option value='http://localhost/House/checkin.php?id=$id'>Check-in Item</option>
 									<option value='http://localhost/House/setcontainer.php?id=$id'>Set Container</option>
									<option value='http://localhost/House/retireitem.php?id=$id'>Retire Item</option>
 								</select>
							</form></td></tr>";
						}
		
						$Row = mysqli_fetch_assoc($QueryResult);
						++$count;
					} while ($count<$numRows);
				?>
			</tr>
			</tbody>
		</table>
	</section>

<?php	
	mysqli_free_result($QueryResult);
	mysqli_close($DBConnect);	
?>	


<?php
	include 'footer.php';
?>
