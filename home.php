<?php
	include 'header.php';
	if(isset($_SESSION['username']))
		echo "<p>You are logged in as ".$_SESSION['username']." on ".$_SESSION['browsertype'].", ".$_SESSION['mobile']."</p>";
?>

<div class="row-fluid">
	<div class="span2">
		<h3>Items:</h3>
	</div>
        <div class="span3">
		<p><a href="addItem.php" class="btn btn-large btn-block btn-primary" type="button">Add Item</a>
	</div>
	<div class="span3">
		<p><a href="searchForm.php" class="btn btn-large btn-block btn-primary" type="button">Search for Items</a>
	</div>
</div>
<hr>
<div class="row-fluid">
	<div class="span25">
		<h3>Lists:</h3>
	</div>
	<div class="span3">
		<?php
			if($_SESSION['mobile'] == "true")
				echo '<p><a href="listAllItemThumb.php" class="btn btn-large btn-block btn-warning" type="button">List All Items</a></p>';
			else
				echo '<p><a href="listAllItem.php" class="btn btn-large btn-block btn-warning" type="button">List All Items</a></p>';
		?>
	</div>
	<div class="span3">
		<?php
			if($_SESSION['mobile'] == "true")
				echo '<p><a href="listHouseItemThumb.php" class="btn btn-large btn-block btn-warning" type="button">List Items in House</a></p>';
			else
				echo '<p><a href="listHouseItem.php" class="btn btn-large btn-block btn-warning" type="button">List Items in House</a></p>';
		?>
	</div>
	<div class="span3">
		<?php
			if($_SESSION['mobile'] == "true")
				echo '<p><a href="listCheckItemThumb.php" class="btn btn-large btn-block btn-warning" type="button">List Items Checked Out</a></p>';
			else
				echo '<p><a href="listCheckItem.php" class="btn btn-large btn-block btn-warning" type="button">List Items Checked Out</a></p>';
		?>
	</div>
	<div class="span3">
		<?php
			if($_SESSION['mobile'] == "true")
				echo '<p><a href="listTheatricalSetItemThumb.php" class="btn btn-large btn-block btn-inverse" type="button">List Theatrical Set</a></p>';
			else
				echo '<p><a href="listTheatricalSetItem.php" class="btn btn-large btn-block btn-inverse" type="button">List Theatrical Set</a></p>';
		?>
	</div>
	<div class="span3">
		<?php
			if($_SESSION['mobile'] == "true")
				echo '<p><a href="listTheatricalPropItemThumb.php" class="btn btn-large btn-block btn-inverse" type="button">List Theatrical Props</a></p>';
			else
				echo '<p><a href="listTheatricalPropItem.php" class="btn btn-large btn-block btn-inverse" type="button">List Theatrical Props</a></p>';
		?>
	</div>
	<div class="span3">
		<?php
			if($_SESSION['mobile'] == "true")
				echo '<p><a href="listTheatricalCostumeItemThumb.php" class="btn btn-large btn-block btn-inverse" type="button">List Theatrical Costumes</a></p>';
			else
				echo '<p><a href="listTheatricalCostumeItem.php" class="btn btn-large btn-block btn-inverse" type="button">List Theatrical Costumes</a></p>';
		?>
	</div>
	<div class="span3">
		<?php
			if($_SESSION['mobile'] == "true")
				echo '<p><a href="listDrapesItemThumb.php" class="btn btn-large btn-block btn-inverse" type="button">List Drapes</a></p>';
			else
				echo '<p><a href="listDrapesItem.php" class="btn btn-large btn-block btn-inverse" type="button">List Drapes</a></p>';
		?>
	</div>
	<div class="span3">
		<?php
			if($_SESSION['mobile'] == "true")
				echo '<p><a href="listDanceItemThumb.php" class="btn btn-large btn-block btn-inverse" type="button">List Dance Items</a></p>';
			else
				echo '<p><a href="listDanceItem.php" class="btn btn-large btn-block btn-inverse" type="button">List Dance Items</a></p>';
		?>
	</div>
	<div class="span3">
		<?php
			if($_SESSION['mobile'] == "true")
				echo '<p><a href="listMusicItemThumb.php" class="btn btn-large btn-block btn-inverse" type="button">List Music Items</a></p>';
			else
				echo '<p><a href="listMusicItem.php" class="btn btn-large btn-block btn-inverse" type="button">List Music Items</a></p>';
		?>
	</div>
	<div class="span3">
		<?php
			if($_SESSION['mobile'] == "true")
				echo '<p><a href="listMiscItemThumb.php" class="btn btn-large btn-block btn-inverse" type="button">List Miscellaneous Items</a></p>';
			else
				echo '<p><a href="listMiscItem.php" class="btn btn-large btn-block btn-inverse" type="button">List Miscellaneous Items</a></p>';
		?>
	</div>
</div>
<hr>
<div class="row-fluid">
	<div class="span2">
		<h3>Checkin:</h3>
	</div>
	<div class="span3">
		<p><a href="checkin.php" class="btn btn-large btn-block btn-success" type="button">Check in</a></p>
	</div>
</div>

<hr>
<div class="row-fluid">
	<div class="span2">
		<h3></h3>
	</div>
	<div class="span3">
		<p><a href="Login.php" class="btn btn-large btn-block btn-success" type="button">Login</a></p>
	</div>
	<div class="span3">
		<p><a href="Logout.php" class="btn btn-large btn-block btn-danger" type="button">Logout</a></p>
	</div>
	<div class="span3">
		<?php
			if((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin'] == 1) && ($_SESSION['username'] == "Nathan") && ($_SESSION['password'] == "Warhammer40K")) {
				echo '<p><a href="createUser.php" class="btn btn-large btn-block btn-primary" type="button">Create a New User</a></p>';
			}
		?>
	</div>
</div>

<?php
include 'footer.php';
?>
