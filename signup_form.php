<?php include ('session.php');?>
<?php
	include ('includes/database.php');
//calling the function generate_id pero di nagana
	
	

	if (isset($_POST['submit']))
	{
		//also add $post heree for generate uid
		$generate_uid=$_POST['generate_uid'];
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$username=$_POST['username'];
		$birthday=$_POST['birthday'];
		$gender=$_POST['gender'];
		$number=$_POST['number'];
		$email=$_POST['email'];
		$password=$_POST['password'];
		$password2=$_POST['password2'];
		
		
			$sql=mySQLi_query($con,"select * from user WHERE email='$email'");
			$row=mySQLi_num_rows($sql);
			if ($row > 0)
			{
			echo "<script>alert('E-mail already taken!'); window.location='index.php'</script>";
			}
			elseif($password != $password2)
			{
			echo "<script>alert('Password do not match!'); window.location='index.php'</script>";
			}else
		{

			$generate_uid .=generate_id(20);

			mySQLi_query($con,"INSERT INTO user ( generate_uid, firstname,lastname,username,birthday,gender,number,email,password,password2)
			VALUES ('$generate_uid','$firstname','$lastname','$username','$birthday','$gender','$number','$email','$password','$password2')");
			
			echo "<script>alert('Account Succesfully Created!'); window.location='index.php'</script>";



		}

	
		
			
	}

//just inserted a function that can create random user_id (generate_uid)
	function generate_id($max)
	{
		$rand ="";
		$rand_count =rand(1,$max);
		for($i=0; $i < $rand_count; $i++)
		{
			#code...
			$r = rand(0,9);
			$rand .= $r;
		}
		return $rand;
	}
	
?>