<?php
session_start();
include('connection.php');
// if(!isset($_SESSION['user'])){
//     header("location:interface.php");
// }

if(isset($_POST['logout'])){

    header("location:logout.php");
}
if(!isset($_SESSION['id'])){
    header("location:interface.php");
}

if(isset($_POST['billing'])){

    header("location: billing.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <link rel="stylesheet" href="style.css">
 <style>
    img{
        height: 100px;
        width: 100px;
    }
 </style>
</head>
<body>
    

    <?php 
    $id = $_SESSION['id'];
    $user = mysqli_query($accountcon, "SELECT * FROM accounts WHERE id ='".$id."'");
    $row = mysqli_fetch_object($user);
    ?>
 <!-- <h1><?= $row -> empfirst?> </h1> -->

    <form action="" method="post">

    <div class="HERO">
    <nav>
    <img src="b4.jpg" alt="">
        <ul>
            <li><a href="http://">Home</a></li>
            <li><a href="billing.php">Billing</a></li>
            <li><a href="http://">Dashboard</a></li>
            <li><a href="http://">Service</a></li>
        </ul>
    <img class ="user-pic"src="b4.jpg" alt="" >
    <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
            <div class="user-info">
                <img src="b4.jpg" alt="">
                <h2>Aaron Aquino</h2>
            </div>
            <hr>
            <a href="http://" class = "sub-menu-link">
                <img src="b4.jpg" alt="">
                <p>Edit Profile</p>
                <span>></span>
            </a>
            <a href="http://" class = "sub-menu-link">
                <img src="b4.jpg" alt="">
                <p>Settings & Privacy</p>
                <span>></span>
            </a>
            <a href="http://" class = "sub-menu-link">
                <img src="b4.jpg" alt="">
                <p>Logout</p>
                <span>></span>
            </a>
        </div>

    </div>
</nav>
    </div>


    

<!-- <div class="hero">
    <nav class ="s">
        <img src="b4.jpg" alt="">
        <ul style = "list-style: none;">
            <li >
        <a href="http://" style = "text-decoration: none;" >Account Setting</a>
            </li>
            <li>
            <a href="http://" style = "text-decoration: none;" >a</a> 
            </li>
            <li>
            <a href="http://" style = "text-decoration: none;" >d</a> 
            </li>
            <li>
            <a href="http://" style = "text-decoration: none;" >Log Out</a>
            </li>
        </ul>
    </nav>
</div> -->
<!-- <ul >
    <li>
        <select name="settings" id="">
        <img src="b4.jpg" alt="">
            <option value="0"></option>

        </select>  
    </li>
</ul> -->

<!-- </nav>     -->

    </form>
  
<center>
<div class="name">
 <h2>Urbiztondo Water Services</h2>
 </div>
</center>


   <form action="" method="post">

   <table class = "content-table"> <!--table for info of customers -->
    <tr class="tablehead">
        <td>
            No.
        </td>
        <td>
            Meter Number
        </td>
        <td>
           Name of Member
        </td>
        <td>
            Bill No.
        </td>
        <td>
Current Consumption (Cubic Meter)
        </td>
        <td>
Previous Consumption (Cubic Meter)
        </td>
        <td>
            Consumption in Cubic Meter
        </td>
        <td>
            Amount of Consumption
        </td>
        <td>
            Past Due
        </td>
        <td>
            Total Amount Due
        </td>
    </tr>

<?php 
   $member = mysqli_query($customercon, "SELECT * FROM paymentrecord ORDER BY transact DESC");
//    $details = mysqli_fetch_object($member);

   while($details = mysqli_fetch_object($member)){

?>


    <tr class="tablehead1">
    <td>
   
        </td>
        <td>
        <?= $details -> MeterNumber?>
        </td>
        <td class="namesizze">
        <?= $details -> firstname?> <?= $details -> middlename?>. <?= $details -> lastname?>
        </td>
        <td>
          12
        </td>
        <td>
        <?= $details -> CurrentReading?>
        </td>
        <td>
        <?= $details -> PreviousReading?>
        </td>
        <td>
        <?= $details -> Consumption?>
        </td>
        <td>
        <?= $details -> AmountofBilling?>
        </td>
        <td>
        <?= $details ->Penalty?>
        </td>
        <td>
        <?= $details -> TotalAmount?>
        </td>
    </tr>

    <?php 
        }
    ?>
   </table>






   <input type="submit" value="LOGOUT" name="logout">
   <input type="submit" value="ADD BILLING" name = "billing">
   </form>



</body>
</html>