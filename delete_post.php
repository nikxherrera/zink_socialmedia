<?php

include('includes/database.php');

$get_id =$_GET['id'];
	
	// sending query
	mysqli_query($con,"DELETE FROM post WHERE post_id = '$get_id'");
	header("Location: timeline.php");

?>
