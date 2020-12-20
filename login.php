<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="loginStyling.css" />
</head>
<body>
<?php
include('DBconn.php');
session_start();
$_SESSION['userID'] = "";

// when form submitted it inserts the values into the database.
if (isset($_POST['username']))
{


        // removes backslashes
	 $username = stripslashes($_REQUEST['username']);
	        //escapes special characters in a string
	 $username = mysqli_real_escape_string($conn,$username);
	 
	 $lastName = stripslashes($_REQUEST['lastName']);
	        //escapes special characters in a string
	 $lastName = mysqli_real_escape_string($conn,$lastName);
	 
	 $email = stripslashes($_REQUEST['email']);
	 $email = mysqli_real_escape_string($conn,$email);
	 
	 $password = stripslashes($_REQUEST['password']);
	 $password = mysqli_real_escape_string($conn,$password);

 			//Checking if user exists in the database by comparing the username and hashed password
	        $query = "SELECT * FROM `users` WHERE fname ='".$username."'
			and password_='".md5($password)."'";

	 		$result = mysqli_query($conn,$query) or die (mysql_error());//executing the sql statement
	 		$rows = mysqli_num_rows($result);//checking whether there are any users with matching information and how many there are

	        if($rows>0)// if theres one record found with mathing information 
	        {
	        	foreach ($result as $key) {
	        		$_SESSION['userID']  = $key['userID'];
	    			$_SESSION['userEmail']  = $key['email'];
	        	}
	        	$id = $_SESSION['userID'];
				header("Location: index.php");// Redirect user to index.php
	        }

	        else//if no mastches are found in the table 
	        {
	        	//notifies user that the information entered is incorrect and prompts them to go back to login page where they can register if needed
				echo "<div class='form'>
				<h3>Username/password is incorrect.</h3>
				<br/>Click here to <a href='login.php'>Login</a></div>";
		 	}

    }
    else
    {
		?>
		<div class="form">
		<h1>Log In</h1>
		<form action="" method="post" name="login">
		<input   type="text"  value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>"  name="username" placeholder="First Name" required /><br>
		<input type="text" value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>"  name="lastName" placeholder="Last Name" required /><br>
		<input type="text" value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>"  name="email" placeholder="Email" required /><br>
		<input type="password" name="password" placeholder="Password" required /><br>
		<input name="submit" type="submit" value="Login" />
		</form>
		<p>Not registered yet? <a href='registration.php'>Register Here</a></p>
		</div>
		<?php 		
	} 
		?>
		</body>
		</html>