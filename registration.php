
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registration</title>
<link rel="stylesheet" href="loginStyling.css" />
</head>
<body>
<?php
include('DBConn.php');//including database connection


session_start();//starts new session
// If form submitted, insert values into the database.
if (isset($_REQUEST['username'])){
        // removes backslashes
 $username = stripslashes($_REQUEST['username']);
 $Lname = stripslashes($_REQUEST['LName']);
        //escapes special characters in a string
 $username = mysqli_real_escape_string($conn,$username); 
 $Lname = mysqli_real_escape_string($conn,$Lname); 

 $address = stripslashes($_REQUEST['address']);
            //escapes special characters in a string
 $address = mysqli_real_escape_string($conn,$address);
 
 $email = stripslashes($_REQUEST['email']);
 $email = mysqli_real_escape_string($conn,$email);
 
 $password = stripslashes($_REQUEST['password']);
 $password = mysqli_real_escape_string($conn,$password);
 
        //this inserts the new user's information from the registration form into the database
        $query = "INSERT INTO `users`(`userID`, `email`, `password_`, `fname`, `lname`, `address`) VALUES (null,'$email', '".md5($password)."','$username', '$Lname', '$address' )";
        $result = mysqli_query($conn,$query);
        if($result){
            //if the insert statement is successful the user is prompted with a success message
            echo "<div class='form'>
					<h3>Registration Successful.</h3>
						<br/>Return to <a href='login.php'>Login</a></div>";

		}
    }else{
?>
<div class="form">
<h1>Registration</h1>
<form name="registration" action="" method="post">
<input type="text" name="username" placeholder="First Name" required /><br>
<input type="text" name="LName" placeholder="Last Name" required /><br>
<input type="text" value="<?php if(isset($_POST['username'])){echo $_POST['address'];} ?>"  name="address" placeholder="Address" required /><br>
<input type="email" name="email" placeholder="Email" required /><br>
<input type="password" name="password" placeholder="Password" required /><br>
<input type="submit" name="submit" value="Register" />
</form>
</div>
<?php } ?>
</body>
</html>
