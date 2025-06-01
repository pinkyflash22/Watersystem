<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include('connection.php');
// if(!isset($_SESSION['user'])){
//     header("location:interface.php");
// }

if(!isset($_SESSION['id'])){
    header("location:interface.php");
}
if(isset($_GET['meternumber'])){
    $meternumber = $_GET['meternumber'];
    
}
if(isset($_GET['searchbutton'])){
    $datasearch = $_GET['search'];
    header("location: maintransaction.php?search=$datasearch");
}
if(isset($_GET['customerid'])){
    $customid = $_GET['customerid'];
    $billnum = $_GET['billnum'];

}
if(isset($_POST['submission'])){
    $dateedit = $_POST['dateedited'];
    $cured = $_POST['currentedited'];
    
    // $mysql = mysqli_query($customercon,"UPDATE bills SET readingdate = '$dateedit' AND current ='$cured'");
    header("Location:save_edit.php?status=success");
 
}

if(isset($_GET['search'])){
 $datasearch = $_GET['search'];
    $searchquery = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE LastName LIKE '$datasearch%'
    OR LastName LIKE '$datasearch%'
     OR FirstName LIKE '$datasearch%'
      OR MiddleName LIKE '$datasearch%'
       OR MeterNumber LIKE '$datasearch%'
    ");
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UWS-Transaction-Edit-Bill</title>
    <link rel="icon" type="image/png" href="icons/urbiztondo-seal-1040x1040.png">

    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="interface.css">  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <style>
        body{
            margin: 0;
            padding:0;
            overflow-y: scroll;
            background-color: rgb(225, 242, 246);
        }
        .cont{
            background-color: darkblue;
        }
       a{
        color: darkblue;
        text-decoration: none;
        padding: .25rem;
      
       }
       .link{
        color: darkblue;
        text-decoration: none;
        padding: .25rem;
        padding-left: 1rem;
       }
       .link:hover, .link.active{
       color:white;
        /* background-color: rgb(225, 242, 246); */
        background-color: #17b79c;
        width: 140%;
        border-left: 5px solid orange;
        transition: background-color 0.3s ease, color 0.3s ease;
        
      
       }
      
      
       aside{
        /* background-color: darkblue;
         */
         /* box-shadow: 20px 20px 5px solid darkslategray; */
         background-color: rgb(225, 242, 246);
        width: 15rem; 
        margin-left: 0; 
        position: fixed; 
        height: 100vh;
   

       }
    
       .items{
        text-align: left; 
        height: 100vh; 
        position: fixed;
       }
       .mainbox{
        margin-left:16rem;
      
       }
       .imgs{
        height: 3rem;
        width: 3rem;
        margin-right: 2rem;
       }
       li{
        list-style: none;
        padding: 0.25rem;
       }
       .fade-in{
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;

       }
       @keyframes fadeIn{
        to{
            opacity: 1;
        }
       }
       .card{
        /* transition */
       }
       /* Initial fade-in + slide-up */
.fade-in-up {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 0.7s ease forwards;
  animation-delay: 0.3s; /* delay so it looks smooth */
}

@keyframes fadeInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Scroll reveal animation */
.reveal {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

.reveal.active {
  opacity: 1;
  transform: translateY(0);
}
  .shadow-table{
    box-shadow: 0 4px 10px rgba(20, 5, 115, 0.5);

  }
  .image{
    border-radius: 50%;
    
  }
   .modify{
        box-shadow: none !important;
       }
       table thead tr .thead{
         background-color:  #009a9c;
        color: white;
        padding: 1rem;
        
       }
       table tbody .spaceinside{
        padding: 1rem;
       }
     table tr:hover{
        
        cursor: pointer;
        box-shadow: 1 1 25px black; 
        &>td{
            /* background-color: green; */
            transform: scale(1.1);
            transition: ease-in-out;
            
            border-radius: 0 1rem 1rem 0;
        }
        &> .om{
            /* background-color: lightblue; */
            transform: scale(1.1);
            transition: ease-in-out;
            border-radius: 1rem 0 0 1rem;

        }
       }
    table .cc:hover{
        &>td{
            /* background-color: green; */
            transform: scale(1);
            transition: ease-in-out;
            
            border-radius: 0 1rem 1rem 0;
        }
    }
    </style>  
  
</head>
<body>
<header class="d-flex w-100 mb-4 p-1" style="position: fixed; z-index: 1;">
<div class="container-fluid w-100 p-1" style="position: fixed;">
    <div class="row">
        <div class="col-sm-2 p-2" style="position: fixed; z-index: 1; display: flex; align-items: center;">
            <div class="ms-2 col-sm-3">
                            <img src="icons/urbiztondo-seal-1040x1040.png" class="shadow-table image img-fluid" alt="Urbiztondo Seal">

                    </div>                
                    <div class="ms-4 col d-flex align-items-center text-nowrap" style="color: black; display: flex; align-items: center;">
                                        <div class="row" style="color: darkslategray;">
                                <h6 class="mb-0" >Urbiztondo</h6>
                                        <h6 class="fs-6 mt-0 mb-0">Water </h6>
                                        <h6 class="fs-6">Services</h6>
                    </div>
                </div>
            </div>
        <div class="col">

        </div>
    </div>
</div>
</header>

<main class="d-flex">
<aside class="sidebar text-white mt-4">
<div class="container mt-4 mb-4 d-flex align-items-center ">

</div>
<br>
<hr style="outline: 2px solid;">
    <nav class="d-flex flex-column p-3 mt-1 items">
       <?php 
       $currentpage = basename($_SERVER['PHP_SELF']);

       ?>
      <li>
        <a href="maindashboard.php" class="  link fs-6 <?=($currentpage == 'maindashboard.php')?'active' : '' ?>" style="display: flex; align-items:center;" >
            <i class="bi bi-speedometer img-fluid fs-3 me-3"></i>
            Dashboard
        </a>
      </li>
      <li>
       <a href="maintransaction.php" class=" link fs-6 <?=($currentpage == 'maintransaction.php')?'active' : '' ?>" style="display: flex; align-items:center;">
            <i class="bi bi-bank img-fluid fs-3 me-3"></i>
            Transaction</a>
       
      </li>
       
       <li>
<a href="mainrecord.php" class=" link fs-6 <?=($currentpage == 'mainrecord.php')?'active' : '' ?>" style="display: flex; align-items:center;">
            <i class="bi bi-file-earmark-bar-graph img-fluid fs-3 me-3"></i>

            Records</a>
       </li>
        <li>
   <a href="mainmember.php" class=" link fs-6 <?=($currentpage == 'mainmember.php')?'active' : '' ?>" style="display: flex; align-items:center;">
            <i class="bi bi-person-rolodex img-fluid fs-3 me-3"></i>

            Members</a>
        </li>
        
        <li>
        <a href="mainprofile.php" class=" link fs-6 <?=($currentpage == 'mainprofile.php')?'active' : '' ?>" style="display: flex; align-items:center;">
            <i class="bi bi-person-circle img-fluid fs-3 me-3"></i>

            Profile Board</a>
        </li>
     <br>
     <br>
     <br>
     <br>
     <br>
     <!-- <li>
         <a href="#" id="" class=" link fs-6" style="display: flex; align-items:center;">
            <i class="bi bi-gear-fill img-fluid fs-3 me-3"></i>

            Settings</a>
       </li> -->
       <li>
         <a href="#" id="logoutLink" class=" link fs-6" style="display: flex; align-items:center;">
            <i class="bi bi-box-arrow-right img-fluid fs-3 me-3"></i>

            Logout</a>
       </li>
    </nav>


</aside>
    </div>
</div>
        </div>
   

      <?php 
                    $user = $_SESSION['id'];

                    $quest = mysqli_query($customercon,"SELECT * FROM accounts WHERE accountid ='$user'");
                    $getuse = mysqli_fetch_object($quest);
                    $position =$getuse -> type;
                    if($position !=="ADMIN"){
                        $getdata = mysqli_query($customercon,"SELECT * FROM employeeaccount WHERE accountid ='$user'");
                        $fetchingdata = mysqli_fetch_object($getdata);
                        $position = $fetchingdata -> emp_firstname;
                    }
                    ?>            
                    <!-- fetch account to display -->
    <div class="container mainbox fade-in-up">
        <div class="container-fluid p-2 ps-2 mt-2 mb-2">
<div class="row">
    <div class="col" style="display: flex; align-items:center; color: darkslategray;">
      <i class="bi bi-receipt img-fluid fs-1 me-3" ></i> EDIT BILL
          

</div>
<!-- <div class="col d-flex  justify-content-center" style="display: flex; align-items:center; color: orange;">
   <nav class="p-3">
  <ul class=" " style="list-style: none; display: flex; align-items: center; gap: 20px; ">
    <li>MESSAGES</li>
    <li>NOTIFICATION</li>
    <li><?= $position ?></li>
    
</nav>
</div> -->
</div>
        </div>
         <div class="container-fluid mb-0">
         <div class="row mb-2"style="background-color:#007c92;" >
                        <div class="col-sm-2">
                            <button onclick="window.history.back()" class="btn text-white"> <i class="bi bi-arrow-left img-fluid fs-6 me-3"></i>Back</button>
                        </div>
                     
                        </div>
       </div>
            <form action="" method="get" id="sortform">      

    
           <div class="card p-4" style="background-color:#007c92;">
            <div class="card-title fs-3 fade-in" style="display: flex; align-items:center; color: white;">
                <div class="row  w-100" style=" display:flex; align-items: center;">
                    
                    <div class="col text-whire" style=" display:flex;  flex-direction: column;">
                 
                                     <?php 
                       
                    $flagquery = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE customerid ='$customid'");
                    $fetchflag = mysqli_fetch_object($flagquery);
                       ?>
                       <div class="row">
                         <div class="col-sm-2 pe-0  text-center">
                    <img src="images\WIN_20241219_23_09_23_Pro.jpg" alt="" class="  img-fluid" style="border-radius: 50%; height: 4rem; width: 4rem;">

                        </div>
                        <div class="col " style="display:flex;align-content: center; flex-direction: column;">
                            <h5><?=$fetchflag -> LastName.", ".$fetchflag -> FirstName." ".$fetchflag -> MiddleName?></h5>
                        <h6><?=$fetchflag -> MeterNumber?></h6>
                        </div>
                   
                
                
                    </div>
                    
                    </div>
            <div class="col-sm-4" style=" display:flex; align-items: center;">

                   
                     <!-- <input type="text" id="searchInput" class="form-control w-75" placeholder="Search..." onkeyup="searchTable()"> -->

                </div>
            </div>
  </div>


        <div class="row mt-4">
            <div class="container-fluid ">
                 <?php 
                        // $billquery = mysqli_query($customercon,"SELECT customerid FROM customerinfo WHERE MeterNumber ='$meternumber'");
                        // $getb = mysqli_fetch_object($billquery);
                        // $customid = $getb -> customerid;

                        $displayquery = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid = '$customid' AND remarks ='NO' AND billno ='$billnum'");
                        $display = mysqli_fetch_object($displayquery);
                        if($display){
                            $amounto = $display -> amount;
                        $readdate = $display -> readingdate;
                        $duedate = $display -> duedate;
                        $testmonth = substr($duedate, 5, 2); //for month
                        $day = substr($duedate, 8, 2); //for day of duedate
                        $theyear = substr($duedate, 0, 4); //for yeAR date of the reading

                       //date today
                        $months = array("JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", 
                            "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER") ;                   //gawa tayo ng aarray for months
                            for($i = 0; $i <12 ; $i++){
                            if($testmonth -1 == $i){ //subrtract ng isa kasi naka aaray hays
                                $themonth = $months[$i]; //textvalue na to
                            
                            }
                            }
                     $themonth; //month for the duedate in word
                    date_default_timezone_set('Asia/Manila'); //time sa pinas
                        $date = date("Y-m-d"); //date today sa pinas , check na if may penalty
                    //  $date =date("2026-03-13");
                        $monthtoday = substr($date, 5, 2);
                        $yeartoday = substr($date, 0, 4);
                        $daytoday = substr($date, 8, 2); //for day of duedate

                        for($i = 0; $i <12 ; $i++){
                            if($monthtoday -1 == $i){ //subrtract ng isa kasi naka aaray hays
                                $thismonth = $months[$i]; //textvalue na to
                            
                            }
                            }
                         $thismonth; //month ngayon in word
                    
                            if($yeartoday >$theyear){
                                $penalty = 0.10 * $amounto;
                            }else if($yeartoday < $theyear){
                                $penalty = 0;

                            }else if($yeartoday == $theyear){
                                if($monthtoday > $testmonth){
                                    // if($daytoday > $day){
                                    //     $penalty = 0.10 * $amounto;
                                    // }else{
                                    // $penalty = 0;
                                    // }
                                        $penalty = 0.10 * $amounto;

                                }else if($monthtoday == $testmonth){
                                         if($daytoday > $day){
                                            $penalty = 0.10 * $amounto;
                                        }else{
                                        $penalty = 0;
                                        }
                                }else if($monthtoday < $testmonth){
                                    $penalty = 0;
                                }
                            }

                         $penalty;
                        }else{

                        }       
                        
                       ?>
                            <div class="row mb-2 ">
                               <div class="col " style="height: 150px;">
                                    <div class="card text-center hove" style="background-color: #f3ff82; color: darkslategray;height: 100%; box-shadow: 1px 1px 5px lightgray;">
                                        <div class="card-title">

                                        </div>
                                        <div class="card-body">
                                        <?php 
                                            if($display){

                                            
                                            ?>
                                            <div class="row">
                                                <div class="col"><i class="bi-clipboard-data fs-1"></i></div>
                                                <div class="col-md-6"> <h2 class="h2"><?=$display -> billno?></h2> <p>Bill No.</p> <sub>Available Bill</sub></div>
                                                <div class="col"></div>
                                            </div>
 
                                        <?php 
                                            }else{

                                            
                                        ?>
                                        <h5 class="h5">No Found</h5>

                                        <?php 
                                            }
                                        ?>
                                        </div>
                                
                                    </div>
                               </div>
                               <div class="col " style="height: 150px;">
                    <div class="card text-center hove" style="background-color: #abeb88;  height: 100%; box-shadow: 1px 1px 5px lightgray;">

                                        <div class="card-title">

                                        </div>
                                        <div class="card-body">
                                            
                                        <?php 
                                            if($display){

                                            
                                            ?>
                                            <div class="row">
                                                <div class="col"><i class="bi-bar-chart-line fs-1"></i></div>
                                                <div class="col-md-6"> <h2 class="h2"><?=$display -> consumption?></h2>
                                                <p>Consumption</p> 
                                                 <sub>Cubic Meter</sub>
                                                </div>
                                                <div class="col"></div>
                                            </div>
                                        <?php 
                                            }else{

                                            
                                        ?>
                                        <h5 class="h5">No Found</h5>

                                        <?php 
                                            }
                                        ?>
                                        </div>
                                    </div>
                               </div>
                               <div class="col " style="height: 150px;">
                                                              <div class="card text-center hove" style="background-color: #67d294; color:white; height: 100%; box-shadow: 1px 1px 5px lightgray;"> 
 
                                        <div class="card-title">
                                               
                                        </div>
                                        <div class="card-body">
                                        <?php 
                                            if($display){

                                                
                                            ?>
                                        <div class="row">
                                                <div class="col"><i class="bi-cash-stack fs-1"></i></div>
                                                <div class="col-md-6">  <h2 class="h2">₱ <?=$amounto + $penalty?></h2>
                                                <p>Total Amount</p> 
                                                   <sub>With Penalty</sub>
                                                </div>
                                                <div class="col"></div>
                                            </div>    
                                       
                                    
                                      

                                        <?php 
                                            }else{

                                            
                                        ?>
                                        <h5 class="h5">No Found</h5>

                                        <?php 
                                            }
                                        ?>
                                        </div>
                                       
                                    </div>
                               </div>
                               <div class="col " style="height: 150px;">
                                                             <div class="card text-center hove" style="background-color: #17b79c; color:white; height: 100%; box-shadow: 1px 1px 5px lightgray;">

                                        <div class="card-title">

                                        </div>
                                        <div class="card-body">
                                            <?php 
                                            if($display){

                                            
                                            ?>

                                            
                                        <div class="row">
                                           
                                            <div class="col"><h3 class="h3"><?=$display -> period?></h3></div>
                                        </div>
                                        <h5 class="h5">PERIOD</h5>
                                        <sub>Consumption Month</sub>

                                        <?php 
                                            }else{

                                            
                                        ?>
                                        <h5 class="h5">No Found</h5>

                                        <?php 
                                            }
                                        ?>
                                      
                                        </div>
                                    </div>
                               </div>
                            </div>
                       </div>
            <div class="col">



            </form>
                
            <div class="card text-center">
                    <div class="card-title mt-2 mb-0">
                                    
                    </div>
                    <div class="card-body" style="text-align: left;">
                 
                       <div class="row">
                        <div class="col">
                            <div class="col">
                       <div class="list-group shadow-table mb-2">
                        <li class="list-group-item"style="  background-color:  #009a9c;">
                            <div class="row" >
                                    <div class="col text-center text-white " >
                                            <b>BILL INFORMATION DETAILS</b>

                                    </div>
                                    
                                </div>
                            </li>
                        <li class="list-group-item">
                            <div class="row">
                                    <div class="col">
                                    <b>Due Date</b>
                                    </div>
                                   <div class="col text-end">
                                        :
                                    </div>
                                    <div class="col text-end pe-4">
                                    <b><?= $duedate?></b>

                                    </div>
                                    <div class="col text-start">
                                        <?php 
                                        for($i = 0; $i <12 ; $i++){
                            if($testmonth -1 == $i){ //subrtract ng isa kasi naka aaray hays
                                $themonth = $months[$i]; //textvalue na to
                            
                            }
                            }
                            echo "<b>$themonth</b>";
                                        ?>

                                    </div>
                                </div>
                            </li>
                       <li class="list-group-item">
                            <div class="row">
                                    <div class="col">
                                    Reading Date
                                    </div>
                                    <div class="col text-end">
                                        :
                                    </div>
                                    <div class="col text-end pe-4">
                                    <b><?= $readdate?></b>
                                    </div>
                                    <div class="col">

                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col">
                                    Current Consumption
                                    </div>
                                    <div class="col text-end">
                                        :
                                    </div>
                                   <div class="col text-end pe-4">
                                    <b><?= $display -> current?>m<sup>3</sup></b>
                                    </div>
                                    <div class="col text-end">
                                        
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                            <div class="row">
                                    <div class="col">
                                    Previous Consumption
                                    </div>
                                    <div class="col text-end">
                                        :
                                    </div>
                                  <div class="col text-end pe-4">
                                    <b><?= $display -> previous?>m<sup>3</sup></b>
                                    </div>
                                    <div class="col text-end">
                                        
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                            <div class="row">
                                    <div class="col">
                                  <b>  Consumption</b>
                                    </div>
                                    <div class="col text-end">
                                        :
                                    </div>
                                    <div class="col text-end pe-4">
                                    <b><?= $display -> consumption?>m<sup>3</sup></b>
                                    </div>
                                    <div class="col text-end">
                                        
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                            <div class="row">
                                    <div class="col">
                                    Penalty (10%)
                                    </div>
                                    <div class="col text-end">
                                        :
                                    </div>
                                   <div class="col text-end pe-4">
                                    <b>$<?= $penalty?></b>
                                    </div>
                                    <div class="col text-end">
                                        
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                            <div class="row">
                                    <div class="col">
                                    Sub-Total
                                    </div>
                                    <div class="col text-end">
                                        :
                                    </div>
                                   <div class="col text-end pe-4">
                                    <b>$<?= $display -> amount?></b>
                                    </div>
                                    <div class="col text-end">
                                        
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-primary">
                            <div class="row">
                                    <div class="col">
                                    <b>Total Amount Due</b>
                                    </div>
                                    <div class="col text-end">
                                        
                                    </div>
                                    <div class="col text-end pe-4">
                                    <b>$<?= $amounto + $penalty?></b>

                                    </div>
                                    <div class="col text-end">
                                        
                                    </div>
                                </div>
                            </li>
                           
                        
                        </div>
                       
                       </div>
                   
                        </div>
                        <div class="col-sm-4 table-container table-responsive shadow-table pt-2 me-2" style="border-top: 2rem solid  #009a9c;">
                        <!-- style="overflow-y: scroll; max-height: 80vh;"> -->
                            
                       <form action="save_edit.php" id="myForm" method="get" class="p-4">
                          <label for="">Edit Current Reading<i style="color: red;">*</i></label>
                          
                          <input type="number" name="currentedited" style="border-bottom: 1px solid  #009a9c;" min="<?=$display -> previous?>" value="<?=$display -> current?>" id="" class="form-control mb-3 mt-1" required>
                          <label for="">Change Reading Date<i style="color: red;">*</i></label>
                          <input type="number" name="billno" value="<?=$display -> billno?>" class="form-control" id="" hidden >
                          <input type="number" name="customerid" value="<?=$display -> customerid?>" class="form-control" id="" hidden >
                         
                          <input type="date" name="dateedited" style="border-bottom: 1px solid  #009a9c;" value="<?=$display -> readingdate?>" class="form-control mb-4 mt-1" id="">
                        <div class="row mt-4">
                       <div class="col text-end mt-4"> 
                            <button type="submit" id="" class="btn btn-primary w-100 shadow-table" onclick="submitForm()">Save</button>
                            
                        
                    </div>             
                        <div class="col text-end mt-4"> 
                            <a  href="viewbills.php?customerid=<?=$customid?>" id="" class="btn btn-warning w-100 shadow-table">Cancel</a>
                            
                        
                    </div>
                        </div>
                        </form>
                        </div>
                       </div>
                        
                        
                       
                    </div> 
                    <!-- card b ody end -->
                </div>
            </div>
           
           
          
            
        </div>



        <!-- container end ng main content -->
    </div>
    
</main>


<footer>

</footer>
        <!-- this.src - para maclick picture and maview -->
         <!-- window.open(src) src only open in new tab -->
         <script src = "bootstrap-5.3.3-dist/js/bootstrap.min.js"> </script>

<script>
  function submitForm() {
    document.getElementById('myForm').submit();
  }
</script>

<script>
        let popup = document.getElementById("dropdown");

function dropdown(){
popup.classList.add("open-dropdown");
}

function closedropdown(){
    popup.classList.remove("open-dropdown");
    }
    </script>
    <script>
        const select = document.getElementById('sort');
        const currentValue = new URLSearchParams(window.location.search).get('datasort');

        if(currentValue){
            select.value = currentValue;
        }

        select.addEventListener('change', function(){
            if(this.value !== currentValue){
                document.getElementById('sortform').submit();
            }
        });
    
    </script>
    
      <script>
document.getElementById("logoutLink").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent immediate navigation

    Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to logout page
            window.location.href = 'logout.php';
        }
    });
});
</script>
<!-- cancel -->
  <script>
document.getElementById("cancellink").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent immediate navigation

    Swal.fire({
        title: 'Cancel & Go Back?',
        text: "",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to logout page
            function submitForm() {
                    document.getElementById('myForm').submit();
                }

        }
    });
});
</script>
<!-- edit -->
 <script>
document.getElementById("savelink").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent immediate navigation

    Swal.fire({
        title: 'Update this Bill?',
        text: "",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to logout page
            function submitForm() {
                    document.getElementById('myForm').submit();
                }

        }
    });
});
</script>

    <script>
    const links = document.querySelectorAll('.link');
    links.forEach(link => {
        link.addEventListener('click', function(){
            // e.preventDefault();
            links.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
 

<script>
  function searchTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const table = document.getElementById("myTable");
    const rows = Array.from(table.getElementsByTagName("tr"));

    const headerRow = rows[0]; // keep header visible
    const dataRows = rows.slice(1);

    // Remove existing "no result" row if present
    const existingNoResult = document.getElementById("noResultRow");
    if (existingNoResult) {
      existingNoResult.remove();
    }

    let found = false;

    dataRows.forEach(row => {
      const text = row.textContent.toLowerCase();
      const match = text.includes(filter);
      row.style.display = match ? "" : "none";
      if (match) found = true;
    });

    if (!found) {
      const noResultRow = document.createElement("tr");
      noResultRow.id = "noResultRow";
      const td = document.createElement("td");
      td.textContent = "No bill found";
      td.colSpan = headerRow.cells.length;
      td.style.textAlign = "center";
      td.style.fontStyle = "italic";
      td.style.color = "#888";
      noResultRow.appendChild(td);

      // Insert "No bill found" row right after the header
      table.insertBefore(noResultRow, dataRows[0]);
    }
  }

  
</script>


</body>
</html>
