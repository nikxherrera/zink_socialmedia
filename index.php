<!DOCTYPE html>
<html>
	<head>
		<title>Welcome To Zink - Log in, Sign up</title>
		<!-- <link rel="icon" type="image/svg+xml" href="ICONS/logo.png"> -->
		<link rel="icon" type="image/svg+xml" href="ICONS/logo.png">
		<link rel="stylesheet" type="text/css" href="css/signincss.css">
		<link rel="stylesheet" type="text/css" href="css/signupcss.css">
	</head>

<body>
	<center>
	<h1><b id='zinkfont'> Welcome to Zink </b></h1>	
	</center>
<div class="form">
	<div id="sign-in-container">
		<div class="sign-in-form">
			<table>
			
			<h2>Log in</h2>
	<form method="post" action="signin_form.php" enctype="multipart/form-data">
				<tr>
					<td><label>Email</label></td>
					<td><input type="email" id="input" name="email" placeholder="example@razor.com" class="form-1" title="Enter your email" required /></td>
				</tr>
				<tr>
					<td><label>Password</label></td>
					<td><input type="password" id="input" name="password" placeholder="~~~~~~~~~~" class="form-1" title="Enter your password" required /></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2">
					<input type="submit" id="input" name="submit" value="Log in" class="btn-sign-in" title="Log in" />
					</td>
				</tr>
	</form>
			</table>
		
		</div>
	</div>

	<div id="sign-up-container">
		<div class="sign-up-form">

			<h2>Sign up</h2>
			<b>All fields are required.</b>
		<br/>
		
		<fieldset class="sign-up-form-1">
		<legend>Personal Information*</legend>
		<form method="post" action="signup_form.php" enctype="multipart/form-data">
			<table cellpadding="5" cellspacing="5">
				<tr>
					<td><label>First name*</label></td>
					<td><label>Last name *</label></td>
				</tr>
				<tr>
					<td><input type="text" id="input" name="firstname" placeholder="Enter your firstname here" class="form-1" title="Enter your firstname" required /></td>
					<td><input type="text" id="input" name="lastname" placeholder="Enter your lastnamehere" class="form-1" title="Enter your lastname" required /></td>
				</tr>
				<tr>
					<td><label>User name*</label></td>
				</tr>
				<tr>
					<td><input type="text" id="input" name="username" placeholder="Enter your username here" class="form-1" title="Enter your username" required /></td>
				</tr>
				<tr>
					<td colspan="2">Note: No one can follow your username.</td>
				</tr>
			</table>
		</fieldset>
		
		<br />		
		
		<fieldset class="sign-up-form-1">
			<legend>Profile Information*</legend>
			<table cellpadding="5" cellspacing="5">
				<tr>
					<td><label>Birthday</label></td>
					
					
					<td><input type="date" name="birthday" value="<?php echo $birthday; ?>" class="form-1" title="Enter your username" required /></td>
					
				</tr>
				<tr>
					<td><label>Gender</label></td>
					<td>
					<label>Male</label><input type="radio" name="gender" value="male" required />
					<label>Female</label><input type="radio" name="gender" value="female" required />
					</td>
				</tr>
				<tr>
					<td><label>Mobile number*</label></td>
					<td><input type="text" id="input" name="number" placeholder="+639" maxlength="13" class="form-1" title="Enter your mobile number" required /></td>
				</tr>
			</table>
		</fieldset>
		
		<br />
		
		<fieldset class="sign-up-form-1">
			<legend>Log in Information*</legend>
			<table cellpadding="5" cellspacing="5">
				<tr>
					<td><label>Your Email Address*</label></td>
					<!-- <td><label>Repeat Email *</label></td> -->
				</tr>
				<tr>
					<td><input type="text" id="input" name="email" placeholder="Enter your Email Address here" class="form-1" title="Enter your firstname" required /></td>
					<!-- <td><input type="text" id="input" name="email2" class="form-1" title="Enter your Lastname" required /></td> -->
				</tr>
				<tr>
					<td colspan="2">Note: No-one can see your email address.</td>
				</tr>
				<tr>
					<td><label>Password*</label></td>
					<td><label>Repeat password*</label></td>
				</tr>
				<tr>
					<td><input type="password" id="input" name="password" placeholder="Enter your Password here" class="form-1" title="Enter your username" required /></td>
					<td><input type="password" id="input" name="password2" class="form-1" title="Enter your Username here" required /></td>
				</tr>
				<tr>
					<td colspan="2">Note: No-one else can see your password.</td>
				</tr>
			</table>
		</fieldset>
		
		<br />
		
			<strong>Yes, I have read and I accept the <a href="#">Zink Terms of Use</a> and the <a href="#">Zink Privacy Statement</a></strong>
			
		<br />
		<br />
					<input type="submit" name="submit" value="I Agree - Continue" class="btn-sign-in" title="Log in" />
		</form>
		
		</div>
	</div>
</div>
</body>

</html>