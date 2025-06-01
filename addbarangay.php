<?php 
session_start();
include('connection.php');

if(isset($_POST['sub'])){
    // $bara = $_POST['bar'];
    $bara =  strtoupper($_POST['bar']);

$bar = mysqli_query($customercon, "INSERT INTO coveredareas VALUES (null,'$bara','101')");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="ROW">

                        <form action="" method="post">
                        <input type="text" name="bar" id="">
                        <input type="submit" value="sub" name="sub">
                        </form>
                      
                        </div>
    
</body>
</html>