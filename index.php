<?php  

$message="";

include("dbConn.php");
session_start();
$id = $_SESSION['userID'] ;


if (isset($_POST['submit'])) {

    if ($id != null) {
        $query = "
             SELECT address FROM users 
             WHERE userID = '".$id."' 
             ";
         $result = mysqli_query($conn, $query) or die('error getting data from table'); 
         foreach ($result as $key) 
         {
              $address = $key['address'];
         } 
           if ($_POST['selectedMessage'] ==1) {
               $message = " ***IMPORTANT*****   We are experiencing issues with a burst pipe in my area. Please send assistance!        My address: $address";
           }
           if ($_POST['selectedMessage'] ==2) {
               $message = " ***IMPORTANT*****   We are experiencing issues with low water pressure in my area. Please send assistance!        My address: $address";
           }
           if ($_POST['selectedMessage'] ==3) {
               $message = "***IMPORTANT*****    We are not receiving any water in area. Please send assistance!        My address: $address";
           }
    }
    else{
        if ($_POST['selectedMessage'] ==1) {
           $message = " ***IMPORTANT*****   We are experiencing issues with a burst pipe in -----ENTER YOUR AREA-----. Please send assistance!";
       }
       if ($_POST['selectedMessage'] ==2) {
           $message = " ***IMPORTANT*****   We are experiencing issues with low water pressure in -----ENTER YOUR AREA-----. Please send assistance!";
       }
       if ($_POST['selectedMessage'] ==3) {
           $message = "***IMPORTANT*****    We are not receiving any water in -----ENTER YOUR AREA-----. Please send assistance!";
       }
    }
    
}

if(isset($_POST["name"]))
{
    $damName = $_POST["name"];
    echo $damName;

     //$temp_title = "Avarage Water Levels per Year For "+ $damName;
     $query = "
     SELECT * FROM dams 
     WHERE name = '".$damName."' 
     ORDER BY Year_ ASC
     ";
     $result = mysqli_query($conn, $query) or die('error getting data from table');  
     foreach($result as $row)
     {
      $output[] = array(
       'year'   => $row["Year_"],
       'waterLevel'  => floatval($row["waterLevel"])
      );
     }
     
     drawMonthwiseChart($output);
}

if (isset($_POST['saveReport'])) {

    $date = date("Y-m-d");
    $context = $_POST['reportArea'];
    if ($id!= null) {
        
        $userEmail = $_SESSION['userEmail'];

         $query = "INSERT INTO `reports`(`reportID`, `context`, `userID`, `state`, `dateOfReport`, `userEmail`) VALUES  (null,'$context', '$id','Unresolved', '$date', '$userEmail')";
        $result = mysqli_query($conn,$query)or die('error getting data from table');  
        if($result){
            echo "<script>alert('Thank You For Your Input. Our Query will be looked into !');</script>";
        }
    }
    else{
        echo "<script>alert('Please Sign in first, as we will need your address for more accurate service!');</script>";
    }
  
}


$query = "SELECT name FROM dams";

$result = mysqli_query($conn, $query) or die('error getting data from table');  

?>  
<!DOCTYPE html>  
<html>  
    <head>  
        <title>Your Water, Our Concern</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
    </head>  
    <header>
    	<h1><span> My Water</span></h1>
    	<nav>
    		<ul>
    			<li><a href="login.php">Login</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="maap.html">Map</a></li>
    		</ul>
    	</nav>
    </header>
    <body> 
        <div style="background-color: grey; padding: 20px;">
        <center>
        <h1>Your Water, Our Concern <img src="./image/k37116405.jpg"></h1>
        </center>
        </div>
        <br /><br /><br /><br /><br /><br />
        <br /><br /><br /><br />
        <center>
             <h3 style="text-align: center;  font-style: bold">Experiencing a Problem?</h3>

            
            <form  method="POST" >
                <select name="selectedMessage" style="margin-left:25px; margin-bottom: 10px"> class="form-control">
                <option value="1">Burst pipe</option>
                <option value="2">Low water pressure</option>
                <option value="3">No water flow</option>
            </select>
            <input type="submit" name="submit" value="Select" style="margin-bottom: 10px ">
                    
                    <form method="POST">
                    <div id="report">
                        <textarea name="reportArea" class="form-control" style="width: 400px; height: 120px; position: center; text-align: center; border-color: black; "><?php echo $message?></textarea>
                        <input type="submit" name="saveReport" value="Report">
                    </div>
                    </form>
            </form>
            
        </center> 
        <br><br>

        <div class="container">  
            <h3 align="center">Water Levels For Mayor PE Dams</h3>  
            <br />  
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-9">
                        </div>
                        <div class="col-md-3">
                            <select name="year" class="form-control" id="year">
                                <option value="">Select Dam</option>
                            <?php
                             $count = 0;
                            foreach($result as $row)
                            {
                                if ($count<5) {
                                    echo '<option value="'.$row["name"].'">'.$row["name"].'</option>';
                                }
                                    
                                $count ++;
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="chart_area" style="width: 1000px; height: 320px;"></div>
                </div>
            </div>
        </div>

        <footer>
            <div class="footer-social-icons">
                <ul>
                <li><a href="" target="blank" class="fa fa-facebook"></a></li>
                <li><a href="" target="blank" class="fa fa-twitter"></a></li>
                <li><a href="" target="blank" class="fa fa-instagram"></a></li>
                </ul>
            </div>
            
        </footer>  
    </body>  
</html>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback();

function load_dam_data(year, title)
{
    var temp_title = title + ' '+year+'';
    $.ajax({
        url:"fetch.php",
        method:"POST",
        data:{year:year},
        dataType:"JSON",
        success:function(data)
        {
            drawMonthwiseChart(data, temp_title);
        }
    });
}

function drawMonthwiseChart(chart_data, chart_main_title)
{
    var jsonData = chart_data;
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Years');
    data.addColumn('number', 'Water Level(%)');
    $.each(jsonData, function(i, jsonData){
        var month = jsonData.month;
        var profit = parseFloat($.trim(jsonData.profit));
        data.addRows([[month, profit]]);
    });
    var options = {
        title:chart_main_title,
        hAxis: {
            title: "Years"
        },
        vAxis: {
            title: 'Water Level(%)'
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_area'));
    chart.draw(data, options);
}

</script>

<script>
    
$(document).ready(function(){

    $('#year').change(function(){
        var year = $(this).val();
        if(year != '')
        {
            load_dam_data(year, 'Average Water Level per Year for');
        }
    });

});

</script>