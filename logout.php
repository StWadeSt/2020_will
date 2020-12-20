
<?php
session_start();
unset($_SESSION['cart']);
// Destroying All Sessions
if(session_destroy())
{
// Redirecting To Home Page
header("Location: login.php");
}
$_SESSION['userID'] = "";
?>