<?php
	include('includes/database.php');
	include('session.php');
							
		if (!isset($_FILES['image']['tmp_name'])) {
		echo "";
		}else{
		$file=$_FILES['image']['tmp_name'];
		$image = $_FILES["image"] ["name"];
		$image_name= addslashes($_FILES['image']['name']);
		$size = $_FILES["image"] ["size"];
		$error = $_FILES["image"] ["error"];

		if ($error > 0){
					echo "<script>alert('No Photo Attached!'); window.location='photos.php'</script>";
				}else{
					if($size > 10000000) //conditions for the file
					{
					echo "<script>alert('Invalid Photo Format!'); window.location='photos.php'</script>";
					}
					
				else
					{

				move_uploaded_file($_FILES["image"]["tmp_name"],"upload/" . $_FILES["image"]["name"]);			
				$location="upload/" . $_FILES["image"]["name"];
				$user=$_SESSION['id'];
				
				$update=mysqli_query($con," INSERT INTO photos (location,user_id,date_added)
				VALUES ('$location','$id',NOW()) ");

				}
					header('location:photos.php');
				
				
				}
		}
?>