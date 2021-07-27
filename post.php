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
			echo "<script>alert('No Photo Attached!'); window.location='home.php'</script>";
		}else{
			if($size > 10000000) //conditions for the file
			{
				echo "<script>alert('Invalid Photo Format!'); window.location='home.php'</script>";
			}
			
			else{

				move_uploaded_file($_FILES["image"]["tmp_name"],"upload/" . $_FILES["image"]["name"]);			
				$location="upload/" . $_FILES["image"]["name"];
				$user=$_SESSION['id'];
				$content=$_POST['content'];
				$time=time();
				
				$update=mysqli_query($con," INSERT INTO post (user_id,post_image,content,created)
				VALUES ('$id','$location','$content','$time') ");

			}
				header('location:home.php');
			
			
		}
	}
?>