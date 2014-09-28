<?php
	include 'header.php';
	permission_check("", "PaMember", "", "", "You do not have permission to add items!");
?>

<form method="post" action="uploadItem.php" enctype="multipart/form-data">
	<fieldset style="width:100%">
	<legend>Add Item to Database</legend>

	<p><label>Name of Item</label>
	<input type="text" name="name" class="span5" placeholder="Type name of item ..." /></p>

	<p><label>Description</label>
	<textarea name="description" class="span5" rows="5" cols="5" maxlength="250" wrap="hard"></textarea></p>

	<p><label>Select Your File: </label>
	<input type="file" name="image" /></p>

	<p><label>Your Name</label>
	<input type="text" name="added_by" class="span5" placeholder="Type your name here ..." /></p>

	<div class="span5">
	<p style='line-height: 30px'><label>Type</label>
	<input type="radio" id="type1" name="type" value="theatricalCostume"  style="display: none"/>
		<label for="type1"  >Costume</label>
	<input type="radio" id="type2" name="type" value="theatricalProp" style="display: none"/>
		<label for="type2"  >Prop</label>
	<input type="radio" id="type3" name="type" value="theatricalSet" style="display: none"/>
		<label for="type3"  >Set</label>
	<input type="radio" id="type4" name="type" value="drapes" style="display: none"/>
		<label for="type4"  >Drapes</label>
	<input type="radio" id="type5" name="type" value="music" style="display: none"/>
		<label for="type5"  >Music</label>
	<input type="radio" id="type6" name="type" value="dance" style="display: none"/>
		<label for="type6"  >Dance</label>
	<input type="radio" id="type7" name="type" value="misc" style="display: none"/>
		<label for="type7"  >Misc</label></p><br/>
	
	<p><label>Location</label>
	<input type="text" name="room" class="span2" placeholder="Enter room number" /><br />

	<input type="radio" id="type8" name="containertype" value="container" style="display: none"/>
		<label for="type8" >Container</label>
	<input type="radio" id="type9" name="containertype" value="rail" style="display: none"/>
		<label for="type9" >Rail</label>
	<input type="radio" id="type10" name="containertype" value="cupboard" style="display: none"/>
		<label for="type10" >Cupboard</label>
	<input type="radio" id="type11" name="containertype" value="shelf" style="display: none"/>
		<label for="type11" >Shelf</label>
	<input type="radio" id="type12" name="containertype" value="other" style="display: none"/>
		<label for="type12"  >Other</label><br /><br />
	<input type="text" name="container" class="span4" placeholder="Container, shelf, cupboard, rail number etc." /></p>
	<p	><input type="submit" value="Add Item" /></p>
	</fieldset>
</form>
</div>


<?php 
	include 'footer.php'; 
?>
