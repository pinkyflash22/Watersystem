<?php
session_start();

if(!isset($_SESSION['id'])){

    header("location: dashboard.php");
}
include('connection.php');

if(isset($_POST['newmember'])){

    header("location:newmember.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
 
<?php  //name ng user dito
    $id = $_SESSION['id'];
    $user = mysqli_query($accountcon, "SELECT * FROM accounts WHERE id ='".$id."'");
    $row = mysqli_fetch_object($user);
    ?>
<?=$row -> empfirst?> 

<form action="" method="post" style = "width: 100%; height: auto; display: flex; justify-content: space-around; ">


<?php 

// if(isset($_POST['find'])){

//     $text = $_POST['searchbtn'];

//     $member = mysqli_query($customercon, "SELECT * FROM customerinfo WHERE lastname LIKE '%$text%' ORDER BY lastname ASC");
//     //    $details = mysqli_fetch_object($member); paymentrecord

    
// }
// else{

    $member = mysqli_query($customercon, "SELECT * FROM customerinfo ORDER BY lastname  ASC");
// }

if(isset($_GET['id'])){

    $id = $_GET['id'];
    $query = mysqli_query($customercon, "SELECT * FROM customerinfo WHERE MeterNumber ='$id'");
}


 //  $details = mysqli_fetch_object($member);

   while($details = mysqli_fetch_object($member)){

   
?>
<tr>

<td>
<?= $details -> LastName ?>, <?= $details -> FirstName ?>  <?= $details -> MiddleName ?>.
   </td>
   <td>
   <?= $details -> Barangay ?>
   </td>
   <td>
   <?= $details -> MeterNumber ?>
   </td>
  
<td>
    <!-- <a href="finaladd.php?id=<?=$details -> MeterNumber?>">Add Payment</a> |  <a href="view.php?id=<?=$details->MeterNumber?>">View Record</a> -->
</td>
</tr>


<?php } ?>


</table>


<div class ="content-table" style= "width: 20%; height: ">
<!-- <input type="submit" value="ADD MEMBER" name="newmember" formtarget="_blank"> -->
 

</div>

</form>



</body>
</html>