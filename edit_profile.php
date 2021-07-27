<?php
require('includes/database.php');
$id =$_REQUEST['user_id'];

$result = mysqli_query($con,"SELECT * FROM user WHERE user_id  = '$id' ");
$test = mysqli_fetch_array($result);
if (!$result) 
		{
		die("Error: Data not found..");
		}
$firstname=$test['firstname'];
$lastname=$test['lastname'];
$username=$test['username'];
$birthday=$test['birthday'];
$gender=$test['gender'];
$number=$test['number'];

if(isset($_POST['save']))
{	
$first_save=$_POST['firstname'];
$last_save=$_POST['lastname'];
$username_save=$_POST['username'];
$birthday_save=$_POST['birthday'];
$gender_save=$_POST['gender'];
$number_save=$_POST['number'];

	mysqli_query($con,"UPDATE user SET firstname ='$first_save', lastname ='$last_save', username ='$username_save', 
	birthday ='$birthday_save' , gender ='$gender_save', number ='$number_save' WHERE user_id = '$id'");
	echo "Saved!";
	
	header("Location: profile.php");			
}

?>

<!DOCTYPE html>
<html>

	<head>
		<title>Zink - Edit Profile</title>
		<!-- <link rel="icon" type="image/svg+xml" href="ICONS/shot.svg"> -->
		<link rel="icon" type="image/svg+xml" href="ICONS/logo.png">
		<link rel="stylesheet" type="text/css" href="css/edit_profilecss.css">
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
																					echo $profile ?>"></a>
				</div>
				
				<div class="user-details">
					<h3><?php echo $firstname ?>&nbsp;<?php echo $lastname ?></h3>
					<h3>@<?php echo $username ?></h3>
				</div>
		</div>
		
		
		
		<div id="right-nav">
			<h1>Edit Info</h1>
	
		<div id="left-nav1">
		
		<fieldset class="-------------">
			<legend><h1>Personal Information</h1></legend>
			<table cellpadding="5" cellspacing="5">

<form method="post">
				<tr>
					<td><label>First name</label></td>
					<td><label>Last name</label></td>
				</tr>
				<tr>
					<td><input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="Enter your firstname....." class="form-1" title="Enter your firstname" required /></td>
					<td><input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="Enter your lastname....." class="form-1" title="Enter your lastname" required /></td>
				</tr>
				<tr>
					<td><label>User name</label></td>
				</tr>
				<tr>
					<td><input type="text" name="username" value="<?php echo $username; ?>" placeholder="Enter your username....." class="form-1" title="Enter your username" required /></td>
				</tr>
			</table>
		</fieldset>
<br />
		<fieldset class="---------------">
			<legend><h1>Additional Information</h1></legend>
			<table cellpadding="5" cellspacing="5">
				<tr>
					<td><label>Birthday</label></td>
					<td><input type="date" name="birthday" value="<?php echo $birthday; ?>" class="form-1" title="Enter your username" required /></td>
				
				</tr>
				<tr>
					<td><label>Sex</label></td>
					<td>
						<select name="gender" class="form-1" value="<?php echo $gender; ?>">
							<option>Select</option>
							<option>male</option>
							<option>female</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label>Mobile number</label></td>
					<td><input type="text" name="number" value="<?php echo $number; ?>" placeholder="09...." maxlength="13" class="form-1" title="Enter your mobile number" required /></td>
				</tr>
			</table>
		</fieldset>
<br />		
		<button type="submit" name="save" onclick='return confirm("Are you sure want to save your profile <?php echo $username ?> ?");' class="">Save</button>

		
		</div>
		
		</div>
		

	
		
	</div>

</body>

</html>