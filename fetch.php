<?php


include('DBConn.php'); 
session_start();

if(isset($_POST["year"]))
{
 $query = "
 SELECT * FROM dams 
 WHERE name = '".$_POST["year"]."' 
 ORDER BY Year_ ASC
 ";
$result = mysqli_query($conn, $query) or die('error getting data from table');  

 foreach($result as $row)
 {
  $output[] = array(
   'month'   => $row["Year_"],
   'profit'  => floatval($row["waterLevel"])
  );
 }
 echo json_encode($output);
}

?>

