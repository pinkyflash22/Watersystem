<?php
session_start();
include('connection.php');
// if(!isset($_SESSION['user'])){
//     header("location:interface.php");
// }

if(!isset($_SESSION['id'])){
    header("location:interface.php");
}

if(isset($_GET['customerid'])){
    $meternumber = $_GET['customerid'];
    
}
$customid = $meternumber;
// if(isset($_GET['customerid'])){
//     $customerid = $_GET['customerid'];
    
// }
//gawa tayo checker para don sa ano active status nila
// section ito na nag uupdate ng status ng member haha

$statuschecker = mysqli_query($customercon, "SELECT COUNT(*) AS totalcount FROM bills WHERE customerid = '$meternumber' ");
$stat = mysqli_fetch_object($statuschecker);
// echo $stat ->totalcount;
//for balance din pwede
if($stat -> totalcount > 4){
    $updatestatus = mysqli_query($customercon,"UPDATE customerinfo SET statusid = '2' WHERE customerid ='$meternumber'");
}else{
    // $updatestatus = mysqli_query($customercon,"UPDATE status_type SET status = 'ACTIVE' WHERE meternumber ='$meternumber' ");
}

//


$getmeter = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE customerid = '$meternumber'");
$getdata = mysqli_fetch_object($getmeter);

$idmeter = $getdata -> MeterNumber;
// echo $meternumber;



if(isset($_POST['submit'])){

    $meter = $_POST['meternumber'];
    $prev = $_POST['previous'];

    $countbill = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid = '$meter' ORDER BY billno DESC"); //check natin if may other billing na sya na sya
    $thedata = mysqli_fetch_object($countbill); //check natin data kung meron na
    if($thedata){
        $bill = $thedata -> billno; //pabaliktad natin kinuha para makuha natin ung pinakarecnet
        $billno = $bill + 1; //dito add tayo isa sa bill nom nya
    }else{
        $billno = 1; //kung wala naman sya bill don sonce bago sya, 1 ung num ng bill nya haha
    }

    $curr = $_POST['current'];
    // $consumption = $_POST['consumption'];

    $consumption = $curr - $prev;
    $period = $_POST['period']; //to ung cover month
    date_default_timezone_set('Asia/Manila'); 
    $testmonth = substr($period, 5, 2);
    $theyear = substr($period, 0, 4);
    //gawa tayo ng pagchechekan
    
  
    // $meter = $_POST['meternumber'];
    //due date natin is the nect month ganon
    $months = array("JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", 
    "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER") ;                   //gawa tayo ng aarray for months
    for($i = 0; $i <12 ; $i++){
       if($testmonth -1 == $i){ //subrtract ng isa kasi naka aaray hays
        $themonth = $months[$i]; //textvalue na to
       
       }
    }
    $period = $themonth; //ilalagay ito sa period dun sa bills

    for($i=0; $i < 12; $i++){
        if($themonth == $months[$i]){
                if($themonth == $months[11]){
                    
                }else{
                 $duemonth = $months[$i + 1];
                }
        }
    }

    
    $itsyear = date("Y"); //getyear here
   $date = date("Y-m-d"); //get whole date today

if($testmonth == 12){
    $testmonth = 1;
    $theyear = $theyear + 1;
}else{
    $testmonth = $testmonth + 1;

}
    if($testmonth < 10){
        $testmonth = "0"."$testmonth";
    }
    // $duedate = $
    $day = 16;

    
    $duedate = $theyear."-".$testmonth."-"."16";
    // $deadline = $itsyear .

    if($consumption > 10){
        $amount= $consumption * 25;
    }
    else{
        $amount = 250;
    }
 
    $total = $amount;
    $employeeid = $_SESSION['id']; //get ung id ng employee pero iba nilagay ko haha
    $itoba = mysqli_query($customercon, "SELECT * FROM employeeaccount WHERE accountid = '$employeeid'");
    $itona = mysqli_fetch_object($itoba);
    $employeeid = $itona -> emp_id;


    


    //query 
    $addbill = mysqli_query($customercon, "INSERT INTO bills VALUES(null,'$meter','$billno','$period','$date','$duedate','$prev','$curr',
    '$consumption','$amount','$total','NO','$employeeid')");
    $_SESSION['insert'] = true;
    header("location: maintransaction.php");
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UWS-Transaction-Add-Bill</title>
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
        /* background-color:darkblue; */
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
    .modal {
  z-index: 2000 !important;
}

.modal-backdrop {
  z-index: 1999 !important;
}
 
    </style>  
  
</head>
<body>
<header class="d-flex w-100 mb-4 p-1" style="position: fixed; z-index: 1;">
<div class="container-fluid w-100 p-1" style="position: fixed;">
    <div class="row">
        <div class="col-sm-2 p-2" style="position: fixed; display: flex; align-items: center;">
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
    <!-- </div>
</div>
        </div>
    -->

      <?php 
$user = $_SESSION['id'];

                    $user;

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
      <div class="row" style="position: sticky;">
          <div class="col " style="display: flex; align-items:center; color: darkslategray;">
            <i class="bi bi-person-rolodex img-fluid fs-1 me-3">
                              <!-- <i class="bi bi-file-earmark-bar-graph img-fluid fs-1 me-3" > -->

                              </i>TRANSACTION / ADD BILL
       

  </div>
  <!-- <div class="col d-flex  justify-content-center" style="display: flex; align-items:center; color: orange;">
    <nav class="p-3">
    <ul class=" " style="list-style: none; display: flex; align-items: center; gap: 20px; ">
      <li>MESSAGES</li>
      <li>NOTIFICATION</li>
      <li><?= $position ?></li>
      <li>
        <a href="#" id="logoutLink" class="  fs-6" style="display: flex; align-items:center;">
              <i class="bi bi-box-arrow-right img-fluid fs-3 me-3"></i>

              Logout</a>
      </li>
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
   
       <form action="" method="post" class="form-group">


            <?php
                $getreading = mysqli_query($customercon, "SELECT * FROM bills WHERE customerid='$meternumber' ORDER BY billno DESC");
                $reading = mysqli_fetch_object($getreading); //pinakarecent na bill ung kukunin para mkuha previous
                if($reading){
                    $previous = $reading -> current;
                    $previousperiod = $reading -> period;
                    $curyear = $reading -> readingdate;
                    $currentyear = substr($curyear,0,4);
                    $year = $reading -> duedate;
                    $year = substr($year, 0 , 4);
                    // $meterss = $reading -> 
                    

                    $monthcover = array("JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", 
                    "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER") ;                   //gawa tayo ng aarray for months
                    for($i = 0; $i <12 ; $i++){
                       if($previousperiod== $monthcover[$i]){ 
                            $nextmonth = $i + 2; //nextmonth
                            $store = $i+1;//current month?
                            if($previousperiod == $monthcover[11]){
                                
                                $nextmonth = 1; //
                                }
                       }
                    }
                    if($nextmonth < 10){
                        $nextmonth = "0".$nextmonth;
                    }
                 $nextperiod = $year."-".$nextmonth;
                     if($store < 10){
                        $store = "0".$store;
                    }
                    $minmonth = $currentyear."-".$store;

                }else{
                    $previous = 0;
                    $previousperiod ="";
                    $monthss = date("Y-m-d");
                    $year = substr($monthss, 0,4);
                    $nexts = substr($monthss, 5, 2);
                    $nextperiod = $year."-".$nexts;
                    
                }
           
            ?>
<div class="card p-4" style="background-color:#007c92;">
            <div class="card-title fs-3 fade-in" style="display: flex; align-items:center; color: white;">
                <div class="row  w-100" style=" display:flex; align-items: center;">
                    <div class="col" style="color: white; ">
                     
                        <?php 

                        $getimage = mysqli_query($customercon,"SELECT * FROM images WHERE userid = '$meternumber'");
                        // $getit = mysqli_fetch_object($getimage);
                        //  $userimage = $getit -> userimg;

                    ?>
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



                        <!-- <img src="images\<?=$userimage?>" class="img-fluid w-25" alt=""> -->
                        <!-- <img src="images\WIN_20241219_23_09_23_Pro.jpg" alt=""> -->
                    </div>
                    <div class="col-sm-4" style=" display:flex; align-items: center;">
                    <input type="text" id="searchInput" class="form-control w-75 " placeholder="Search..." onkeyup="searchTable()">
                    
                    </div>
                </div>
            </div>
        </div> 
        <div class="container-fluid">
            
            </div>

           
<div class="container-fluid p-4 mt-2"  style="background-color:  #009a9c; color: white; background-color:#007c92; ">
  
  <div class="row mt-2">
                <div class="col me-0 ms-0">
                    <div class="card text-center"  style="background-color:  #67d294; color: white;">
                        <div class="card-body w-100">
                          
                        <h1><label name ="" value=""><?=$idmeter?></label></h1>
                            <span>Meter Number</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-center" style="background-color:  #009a9c; color: white;">
                        <div class="card-body">
                          
                        <h1><label name ="" value=""><?=$previous?></label></h1>
                            <span>Previous Reading</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-center"  style="background-color:  #67d294; color: white;">
                        <div class="card-body">
                          
                        <h1><label name ="" value=""><?=$previousperiod?></label></h1>
                            <span>Last Period</span>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row mt-2 p-4" >

                <div class="col text-wrap`">
                    <!-- <label for="">Meter Number</label> -->
                    <input type="number" name="meternumber" id="" value="<?=$meternumber?>" class="form-control" readonly style="display:none;">
                    <!-- <label for="">Previous Reading</label> -->
                    <input type="number" name="previous" id="" class="form-control" value="<?=$previous?>" readonly style="display:none;">
                    <label for="" class="fs-4">Current Reading<i style="color: red;">*</i></label>
                    <input type="number" name="current" min="<?=$previous?>" id="" class="form-control" required>
                    <!-- <label for="">Consumption</label> -->
                    <!-- <input type="number" name="consumption" id="" class="form-control" readonly> -->
                </div>
                <div class="col">
                    <label for="" class="fs-4">Period Covered</label>
                    <input type="month" name="period" id="<?=$minmonth?>" min="<?=$nextperiod?>" value="<?=$nextperiod?>" class="form-control" >    
                </div><div class="row mt-4 ">

              <div class="col">

              </div>
              <div class="row">
        <div class="col">

        </div>
        <div class="col-sm-3 d-flex">
     <button type="submit" name="submit" class="btn  w-100 me-2 shadow-table" style="background-color:  #67d294;  color: black;"><i class="bi bi-database"></i>
Save</button>
      <a href="maintransaction.php" class="btn btn-warning shadow-table" >Cancel</a>
        </div>
      </div>
            
                <!-- <a href="addbill.php?meternumber=<?=$meternumber?>" class="btn btn-secondary">Create New Bill</a> -->

            </div>

            </div>
            </div>
             
            
        </form>
<div class="container-fluid mt-4">
                                                <h5>LIST OF BILLS - UNPAID</h5>
                <table id="myTable" class="table shadow-table  mb-2 mt-0" >
                            
                        
                        <thead style=" position: sticky; top:0; z-index: 2;">
                            <tr class="mx">
                                <th scope="col" class="thead text-center" >BILL NO.</th>
                                <th scope="col" class="thead" >PERIOD</th>
                                <th scope="col" class="thead" >SUB TOTAL</th>
                                <th scope="col" class="thead" ></th>


                            </tr>
                        </thead>
                     <tbody>
                           
                    <?php 
                               
                                // while ($info = mysqli_fetch_object($member)) {
                                    // echo $data;
                                    $queries = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid ='$customid' AND remarks ='NO' ORDER BY billno DESC ");

                                    
                                if(isset($_GET['datasort'])){
                                    $sort = $_GET['datasort'];
                                        if($sort == ""){
                                            $queries = mysqli_query($customercon,"SELECT * FROM customerinfo");

                                            
            
                                        }else{
                                            $queries = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE Barangay = '$sort'");
                                            
                                        }
                                }
                     
                          if($queries -> num_rows > 0){
                                while($info = mysqli_fetch_object($queries)){

                                   
                                    $dueday = $info -> duedate;
                                $duedateyear = substr($dueday,0,4);
                              $month = substr($dueday, 5,2);
                              if($month == 1){
                               $duedateyear = $duedateyear - 1; //for transition kasi kinukuha ko is ung duedate e bwenas haha
                            //    kaya subtract kasi para sa deecember accurate year
                              }else{
                                $duedateyear = substr($dueday,0,4);
                              }
                            
                            ?>
                             <tr style="height: 1rem;">
                                <th scope ="row" class="spaceinside om text-center fade-in-up" style="" id="meter"><?=$info -> billno?></th>
                                <?php 
                                    // if($month == 1){
                                    //     $duedateyear = 
                                    
                                ?>
                                    <td class="spaceinside fade-in-up" style="" id="names"> <?=$info -> period." ".$duedateyear?> </td>
                                    <?php 
                                // }
                                    ?>
                                    <td class="spaceinside ps-4 fade-in-up" style="">₱ <?=$info -> amount?>
                                    
                                </td>
                                    <td class="spaceinside text-center fade-in-up" style="">
                                   <?php 
                                   
                                   ?>
                                   <a href="addpaymentbill.php?customerid=<?=$customid?>&billnum=<?=$info -> billno?>" class="btn btn " style="background-color:#007c92; color: white;">  <i class="bi bi-credit-card"></i> Pay</a>
                                   <!-- <a href="viewpayment.php?customerid=<?=$customid?>&billnum=<?=$info -> billno?>" class="btn btn-info " style="color:#072F5F; font-weight: bold;"><i class="bi bi-eye"></i></a> -->
                                    <a href="viewreceipt.php?customerid=<?=$customid?>&billnum=<?=$info -> billno?>" target="_blank" class="btn btn-warning"> <i class="bi bi-eye"></i></a>
                                    <a href="print_receipt.php?customerid=<?=$customid?>&billnum=<?=$info -> billno?>" target="_blank" class="btn btn-success">      <i class="bi bi-printer"></i> Print</a>
                                  
                                   <!-- <a href="addbill.php?meternumber=<?=$info -> MeterNumber?>" class="btn btn-warning">View</a> -->
                                    <!-- <a href="addbill.php?meternumber=<?=$info -> MeterNumber?>" class="btn btn-success ">Print</a></td> -->


                            </tr>
                                        



                                <div class="modal fade " id="myModal" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: darkblue; color: white;">
                                                <h5 class="modal-title  text-center ">Payment</h5>

                                                <!-- <button type="button" class="btn-close " data-bs-dismiss="modal"></button> -->
                                            </div>
                                            <div class="modal-body" >
                                                <div class="row">
                                                  
                                                        <div class="col">
                                                            <div class="card text-center" >
                                                                <div class="card-title  mt-4 mb-0">
                                                                    <span id="modalid"></span>
                                                                </div>
                                                                <div class="card-body" id="datas">PERIOD</div>
                                                            </div>
                                                        </div>

                                                        <div class="col">
                                                            <div class="card text-center">
                                                                <div class="card-title  mt-4 mb-0">

                                                                </div>
                                                                <div class="card-body">TOTAL</div>
                                                            </div>
                                                        </div>

                                                        <div class="col">
                                                            <div class="card text-center">
                                                                <div class="card-title  mt-4 mb-0">

                                                                </div>
                                                                <div class="card-body">CONSUMED</div>
                                                            </div>
                                                        </div>
                                                
                                                </div>
                                              <div class="row">
                                                

                                              <?php 
                                               
                                              ?>
                                                <form action="" method="post" id="editform">
                                                <div class="col">
                                                <label for="">Current Reading<i style="color: red;">*</i></label>
                                                <input type="text" name="current"  id="meternumber" class="form-control" required>
                                                <label for="">Amount<i style="color: red;">*</i></label>
                                                <input type="number" name="current" min="<?=$previous?>" id="" class="form-control" required>
                                                <label for="">Change<i style="color: red;">*</i></label>
                                                <input type="number" name="current" min="<?=$previous?>" id="" class="form-control" required>
                                            

                                                </div>



                                                </form>
                                                
                                                <!-- <div class="col">
                                                <label for="">Current Reading<i style="color: red;">*</i></label>
                                                <select name="datasort" id="sort" onchange ="this.form.submit()" class="btn btn-light">
                                                </div> -->
 
                                               
                                               
                                              </div>


                                            </div>

                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-success" value="Pay">
                                            </div>

                                           
                                            </div>
                                        </div>
                                </div>
                            <?php 
                                } //closing ng loop ng query
                            }// closing sa l
                            else{

                            
                            ?>
                          
 <tr><td colspan ="12" class ="text-center">No Record Found</td></tr>
                              

                        <?php 
                                            }
                        ?>
                            </tbody>

                        </table>
                                            </div>
        <!-- container end ng main content -->
    </div>
    
</main>


<footer>

</footer>
        <!-- this.src - para maclick picture and maview -->
         <!-- window.open(src) src only open in new tab -->
         <script src = "bootstrap-5.3.3-dist/js/bootstrap.min.js"> </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- scroll animation -->
 
        <script>
            document.addEventListener("DOMContentLoaded", function() {
  const reveals = document.querySelectorAll(".reveal");

  function revealOnScroll() {
    const windowHeight = window.innerHeight;
    reveals.forEach(el => {
      const elementTop = el.getBoundingClientRect().top;
      const revealPoint = 150; // how far from bottom before reveal

      if(elementTop < windowHeight - revealPoint){
        el.classList.add("active");
      } else {
        el.classList.remove("active");
      }
    });
  }

  window.addEventListener("scroll", revealOnScroll);

  // Initial check in case some are in view on page load
  revealOnScroll();
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

                               <script>

                                <?php
                                               $data = mysqli_query($customercon, "SELECT * FROM customerinfo WHERE statusid = '1'");
                                               $i = 0;
                                              while($value = mysqli_fetch_object($data)){
                                                  $i = $i+1;
                                              }
         
                                     $data = mysqli_query($customercon, "SELECT * FROM customerinfo WHERE statusid = '2'");
                                      $j = 0;
                                     while($value = mysqli_fetch_object($data)){
                                         $j = $j+1;
                                     }

                                     $data = mysqli_query($customercon, "SELECT * FROM customerinfo WHERE statusid = '3'");
                                     $k = 0;
                                    while($value = mysqli_fetch_object($data)){
                                        $k = $k+1;
                                    }
                                   
                                    $data = mysqli_query($customercon, "SELECT * FROM customerinfo WHERE statusid = '4'");
                                     $l = 0;
                                    while($value = mysqli_fetch_object($data)){
                                        $l = $l+1;
                                    }

                                ?>
                                const ctx = document.getElementById('mydoughnut').getContext('2d');
                                const myChart = new Chart(ctx, {
                                    type: 'doughnut',
                                    data: {
                                        labels: ['Active Individual', 'Inactive Individual', 'Active Booster', 'Inactive Booster'],
                                        datasets: [{
                                            label: 'Members',
                                            data: [<?=$i?>,<?=$j?>,<?=$k?> ,<?=$l?>],
                                            backgroundColor: [
                                                'purple',
                                                'orange',
                                                'magenta',
                                                'red'
                                               
                                            ],
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins:{
                                            legend: {
                                                position: 'bottom',
                                            },
                                            title: {
                                                display: true,
                                                text: 'Consumer Status'
                                            }
                                        }
                                    }
                                });
                               </script> 

<script>
    <?php 
        // $sql = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE Barangay = '1'");
        // $mysq = mysqli_fetch_object($sql);
        $barangay = [];

     
            $bar = mysqli_query($customercon, "SELECT * FROM coveredareas");
                                
            $i = 0;
            while($bara = mysqli_fetch_object($bar)){
                $barangay[$i] = $bara -> area;
                $i = $i + 1;
            }
        
       
        // $a  = $mysq -> LastName;
    ?>
      const cc = document.getElementById('chart2').getContext('2d');
   

                                const areachart = new Chart(cc, {
                                    type: 'pie',
                                    data: {
                                        // labels: ['<?=$barangay[0]?>',
                                        //  '<?=$barangay[1]?>', 
                                        //  '<?=$barangay[2]?>', 
                                        //  '<?=$barangay[3]?>'
                                        // ],
                                        labels: [
                                            <?php 
                                            for($j = 0; $j < 23; $j++){
                                            ?>
                                            '<?=$barangay[$j]?>',
                                            <?php 
                                            }
                                            ?>
                                    
                                        ],
                                        datasets: [{
                                            label: 'Members',

                                            <?php 
                                            
                                            ?>
                                            data: [10,20,30,40,1,2,4],
                                            backgroundColor:[
                                                '#f3ff82',
                                                '#abeb88',
                                                '#67d294',
                                                '#17b79c',
                                                '#009a9c',
                                                '#007c92',
                                                '#005e7d',
                                                '#1f4260'

                                            ],  
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins:{
                                            legend: {
                                                position: 'left',
                                            },
                                            title: {
                                                display: true,
                                                text: 'Area Vicinity'
                                            }
                                        }
                                    }
                                });
</script>
<script>
     <?php 
      
            $months = [];
            $bar = mysqli_query($customercon, "SELECT * FROM coveredareas");
                                
            $i = 0;
            while($bara = mysqli_fetch_object($bar)){
                $barangay[$i] = $bara -> area;
                $i = $i + 1;
            }
    ?>
const ctxs = document.getElementById('lineChart').getContext('2d');
const chart = new Chart(ctxs, {
  type: 'line',
  data: {
    labels: <?php echo json_encode($months); ?>,
    datasets: [{
      label: 'Performance',
      data: <?php echo json_encode($values); ?>,
      fill: false,
      borderColor: '#6366f1',
      backgroundColor: '#c7d2fe',
      tension: 0.3,
      pointRadius: 5,
      pointHoverRadius: 8
    }]
  },
  options: {
    responsive: true,
    animation: {
      duration: 1500,
      easing: 'easeOutQuart'
    },
    plugins: {
      legend: {
        labels: {
          color: '#4f46e5'
        }
      },
      tooltip: {
        backgroundColor: '#f3f4f6',
        titleColor: '#4f46e5'
      }
    },
    scales: {
      x: {
        ticks: { color: '#4f46e5' },
        grid: { color: '#e5e7eb' }
      },
      y: {
        ticks: { color: '#4f46e5' },
        grid: { color: '#e5e7eb' }
      }
    }
  }
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
        let popup = document.getElementById("dropdown");

function dropdown(){
popup.classList.add("open-dropdown");
}

function closedropdown(){
    popup.classList.remove("open-dropdown");
    }
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
<?php if (isset($_SESSION['insert'])): ?>
<script>
Swal.fire({
  title: 'Added Successfully',
//   text: ''.',
  icon: 'success',
  confirmButtonColor: '#4f46e5'
});
</script>
<?php unset($_SESSION['insert']); 
 
endif; ?>
</body>
</html>