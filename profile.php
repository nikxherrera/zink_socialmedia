<!DOCTYPE html>
<html>

	<head>
		<title>Zink - Profile</title>
		<!-- <link rel="icon" type="image/svg+xml" href="ICONS/shot.svg"> -->
		<link rel="icon" type="image/svg+xml" href="ICONS/logo.png">
		<link rel="stylesheet" type="text/css" href="css/profile.css">
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
	
		<div id="left-nav">
				
				<div class="clip1">
				<a href="updatephoto.php" title="Change Profile Picture"> <img src="<?php $profile = $row['profile_picture']; 
																					if (empty($profile)) $profile = "images/profile.jfif";
																					echo $profile ?>"><button>Update Picture</button>
				</a>
				
				</div>

				<div class="user-details">
					<h2><?php echo $firstname ?>&nbsp;<?php echo $lastname ?></h2>
					<h3>@<?php echo $username ?></h3>
				</div>
		</div>
		
		
		
		<div id="right-nav">
			<h1>Personal Info</h1>
			<hr />
			<br />
			<?php
			include('includes/database.php');

			$result=mysqli_query($con,"SELECT * FROM user where user_id='$id' ");
			
			while($test = mysqli_fetch_array($result))
			{
				$id = $test['user_id'];	
				echo " <div class='info-user'>";
				echo " <div>";
				echo " <label>Firstname</label>&nbsp;&nbsp;&nbsp;<b>".$test['firstname']."</b>";
				echo "</div> ";
				echo "<hr /> ";		
				echo "<br /> ";		
				echo " <div>";
				echo " <label>Lastname</label>&nbsp;&nbsp;&nbsp;&nbsp;<b>".$test['lastname']."</b>";
				echo "</div> ";
				echo "<hr /> ";	
				echo "<br /> ";		
				echo " <div>";
				echo " <label>Username</label>&nbsp;&nbsp;&nbsp;<b>".$test['username']."</b>";
				echo "</div> ";
				echo "<hr /> ";	
				echo "<br /> ";		
				echo " <div>";
				echo " <label>Birthday</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$test['birthday']."</b>";
				echo "</div> ";
				echo "<hr /> ";	
				echo "<br /> ";		
				echo " <div>";
				echo " <label>Sex</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>"       .$test['gender']."</b>";
				echo "</div> ";
				echo "<hr /> ";	
				echo "<br /> ";		
				echo " <div>";
				echo " <label>Number</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$test['number']."</b>";
				echo "</div> ";
				echo "<hr /> ";	
				echo "<br /> ";	
				echo "</div> ";
				echo "<br /> ";		
				echo " <div class='edit-info'>";
				echo " <a href ='edit_profile.php?user_id=$id'><button>Edit Profile</button></a>";
				echo "</div> ";
				echo "<br /> ";	
				echo "<br /> ";	
			}
			?>
			
		</div>

	
		</div>
		

	
		
	</div>

</body>

</html>