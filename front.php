<?php 

session_start();
if(isset($_POST['btnsign'])){

    header("location:interface.php");
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
    <form action="" method="post">
    <input type="submit" value="Sign In" name="btnsign">
    <input type="submit" value="Admin" name="btnadmin">

    </form>
    
</body>
</html>