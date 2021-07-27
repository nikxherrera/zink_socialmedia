<?php

include('includes/database.php');

$get_id =$_GET['id'];
	
	// sending query
	mysqli_query($con,"DELETE FROM photos WHERE photo_id = '$get_id'");
	header("Location: photos.php");

?>
