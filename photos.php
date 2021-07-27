<!DOCTYPE html>
<html>

	<head>
		<title>Zink - Your Zink</title>
		<!-- <link rel="icon" type="image/svg+xml" href="ICONS/shot.svg"> -->
		<link rel="icon" type="image/svg+xml" href="ICONS/logo.png">
		<link rel="stylesheet" type="text/css" href="css/photoscss.css">
	</head>

<body>
<?php include ('session.php');?>

	<div id="header">
		<div class="head-view">
			<ul>
				<li ><img src="ICONS/logo2.png" alt="logo" style=" height: 45px; left: 3px; top: 6px; position: relative; border: 1px solid #555; border-radius: 5px;"></li>
				<li ><a href="home.php" title="Home" ><b id='zinkfont'>Zink</b></a></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li><a href="timeline.php" title="<?php echo $username ?>"><label><?php echo $username ?></label></a></li>
				<li><a href="home.php" title="Home"><img src="ICONS/home.png"></a></li>
				<li><a href="profile.php" title="Profile"><img src="ICONS/profile.png"></a></li>
				<li><a href="photos.php" title="Zink"><img src="ICONS/shots.png"></a></li>
				<li><a href="index1.php" title="Chitchat"><img src="ICONS/chats.png"></a></li>
				<li><a href="logout.php" onclick='return confirm("Are you sure want to Zink Out <?php echo $username ?> ?");'><button class="btn-sign-in" value="Log out">Zink out!</button></a></li>
			</ul>
		</div>
	</div>

	<div id="container">
		
		<div id="right-nav">
			<h1><?php echo $username ?>  Shots</h1>
	<div>
			<form method="post" action="add_photo.php" enctype="multipart/form-data">
				<input type="file" name="image">
				<button class="btn-submit-photo" name="Submit" value="Log out">Add Photos</button>
			</form>
	<hr />
	</div>
	

<?php
	include("includes/database.php");
			$query=mySQLi_query($con,"SELECT * from photos where user_id='$id' ");
			while($row=mySQLi_fetch_array($query)){
				$id = $row['photo_id'];
?>

		<div class="photo-select">
			<center>
				<img src="<?php echo $row['location']; ?>">
				<hr>
				<a href="delete_photos.php<?php echo '?id='.$id; ?>" onclick='return confirm("Are you sure want to delete photo?");'  class="btn-delete-photos">Delete</a>
			</center>
		</div>
		
<?php
}
?>
		</div>

		
	</div>

</body>

</html>