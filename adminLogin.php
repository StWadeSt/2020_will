
<?php
session_start();
	include('DBConn.php');
	


	if(isset($_POST['submit']))
	{

		$username = stripslashes($_REQUEST['username']);


		$password = stripslashes($_REQUEST['password']);

		if ($username =="admin" && $password == "admin") {
			 $_SESSION['username'] = $username;
		  	header("Location: adminpage.php");

		}

		else
		{
		 echo "<h3>adminName/password is incorrect.</h3>";
	 	}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Admin Login</title>
		<link rel="stylesheet" href="loginStyling.css" />
	</head>

	<body>
			<div class= "form"><br><br><br><br><br><br><br><br>
				<h1>Admin Login</h1>
					<form action="" method="post" name ="login">
						<input type= "text" value= "<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>" name="username" placeholder="First Name" required /><br>
						<input type="password" name ="password" placeholder="Password" required/><br>
						<input name="submit" type="submit" value="Login"/>
					</form>
				</div>
			</body>
		</html>
