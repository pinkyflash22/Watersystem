<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include('connection.php');
// if(!isset($_SESSION['user'])){
//     header("location:interface.php");
// }
$user = $_SESSION['id'];

if(!isset($_SESSION['id'])){
    header("location:interface.php");
}
if(isset($_GET['employeeid'])){
  $customerid = $_GET['employeeid'];
    
}

if(isset($_POST['submit'])){
   
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $contact = $_POST['contact'];
    $type = $_POST['type'];
    $email = $_POST['email'];
    $bday = $_POST['bday'];
    // $date = date("Y-m-d"); 

    $checker = mysqli_query($customercon, "SELECT * FROM employeeaccount WHERE  emp_middlename ='$middlename' AND emp_lastname ='$lastname' AND emp_firstname ='$firstname' AND emp_birth ='$bday'");
    if($checker -> num_rows > 0){
      // echo "<script>alert('EMPLOYEE ALREADY EXIST');</script>";
  
      $getdata = mysqli_fetch_object($checker);
  
       $insertquery = mysqli_query($customercon, "UPDATE employeeaccount SET emp_lastname = '$lastname', emp_firstname ='$firstname', 
       emp_middlename ='$middlename' , contact ='$contact' , email ='$email' , emp_birth ='$bday' WHERE accountid ='$customerid' "  );

 
   
      $updateaccount = mysqli_query($customercon,"UPDATE accounts SET type='$type' WHERE accountid ='$customerid' ");
               $_SESSION['update'] = true;
                // header("Location: " . $_SERVER['PHP_SELF']);
               
                //  header("Location:employee_profile.php?employeeid=$customerid");
                 
    }
 
    
       
}
if(isset($_POST['change'])){
  $newpass = $_POST['repeatPassword'];
  $selection = mysqli_query($customercon,"SELECT * FROM employeeaccount WHERE accountid = '$customerid'");
  $getselect = mysqli_fetch_object($selection);
  $datamove = $getselect -> accountid;
  $updatepass = mysqli_query($customercon,"UPDATE accounts SET password ='$newpass' WHERE accountid ='$datamove'");
      $_SESSION['update'] = true;


}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UWS-TRANSACTION</title>
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
                            <img src="icons/urbiztondo-seal-1040x1040.png" style="height: 4rem; width: auto;" class="shadow-table image img-fluid" alt="Urbiztondo Seal">

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
                    $user;

                    $quest = mysqli_query($customercon,"SELECT * FROM accounts WHERE accountid ='$customerid'");
                    $getuse = mysqli_fetch_object($quest);
                    $position =$getuse -> type;
                    $thistype = $getuse -> type;
                    if($position =="EMPLOYEE"){
                        // $getdata = mysqli_query($customercon,"SELECT * FROM employeeaccount WHERE accountid ='$user'");
                        // $fetchingdata = mysqli_fetch_object($getdata);
                        // $position = $fetchingdata -> emp_firstname;
                        $position = "OFFICE CLERK & CASHIER";
                    }
                    ?>            
                    <!-- fetch account to display -->
    <div class="container mainbox fade-in-up">
        <div class="container-fluid p-2 ps-2 mt-2 mb-4">
<div class="row">
    <div class="col" style="display: flex; align-items:center; color: darkslategray;">
       <i class="bi bi-person-circle img-fluid fs-3 me-3"></i>MEMBERS / EDIT / EMPLOYEE PROFILE
          

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

    <form action="" method="get" id="sortform">      

       <div class="card p-4" style="background-color:#007c92;">
            <div class="card-title fs-3 fade-in" style="display: flex; align-items:center; color: white;">
                <div class="row  w-100" style=" ">
                    
                    <div class="col text-white" style=" display:flex;  flex-direction: column;">

                        <div class="container">
                            <img src="images\WIN_20241219_23_09_23_Pro.jpg" alt="" class="  img-fluid" style="border-radius: 50%; height: 8rem; width: 8rem;">
                        </div>
                    
                    </div>
                    <?php 

                    $flagquery = mysqli_query($customercon,"SELECT * FROM employeeaccount WHERE accountid ='$customerid'");
                    $fetchflag = mysqli_fetch_object($flagquery);
                     
                  
                    ?>
                    <div class="col-md-10">
                        <h4><?= $fetchflag -> emp_firstname ." ".$fetchflag -> emp_middlename." ".$fetchflag -> emp_lastname?></h4>

                        <h6 style="font-weight: normal;"><?=$position?></h6>
        
                        <!-- <h6 style="font-weight: normal;"><?="#".$fetchflag -> House." ".$fetchflag -> Street." ".$thebarangay." URBIZTONDO, PANGASINAN"?></h6> -->
                        <h6 style="font-weight: normal;"><?=$fetchflag -> emp_birth?></h6>
                        <h6 style="font-weight: normal;">0<?=$fetchflag -> contact?></h6>
                        <h6 style="font-weight: normal;"><?=$fetchflag -> email?></h6>
                        <div class="row d-flex">
                            <div class="col-sm-6"><button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#myCollapse3" aria-expanded="false" aria-controls="myCollapse">
                            Edit Info
                            <!-- </button>
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#myCollapse" aria-expanded="false" aria-controls="myCollapse">
                            View Unpaid
                            </button>
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#myCollapse2" aria-expanded="false" aria-controls="myCollapse">
                            View Paid
                            </button> -->
                             <button class="btn btn-primary ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#myCollapse4" aria-expanded="false" aria-controls="myCollapse">
                            Change Password
                            </button>
                          </div>
                            <div class="col"></div>
                        </div>

                      
                    </div>
                </div>
            </div>
        </div> 
         
  </form>
<div class="row mt-2">
               
                      <!-- Collapsible Content -->
  <div class="collapse" id="myCollapse3">
    <div class="card card-body p-4">
      Fill this field to update information
     
      <?php
    //   $informationquery = mysqli_query($customercon,"SELECT * FROM employeeaccount WHERE customerid='$customerid'");
    //   $info = mysqli_fetch_object($informationquery);
    //   $lastname = $info -> LastName;
    //   $firstname = $info -> FirstName;
    //   $middlename = $info -> MiddleName;
    //   $compare = $info -> statusid;
    //   $statusquery = mysqli_query($customercon,"SELECT * FROM status_type WHERE statusid ='$compare' ");
    //   $stat = mysqli_fetch_object($statusquery);
    //   $type = $stat -> type;
    //  $house = $info -> House;
    //   $email = $info -> email;
    //   $contact = $info -> contact;
    //   $street = $info -> Street;
      ?>
       <form method="POST" class="modal-content bg-light p-4 mt-2" style="border-radius: 1rem;">
    

        <div class="row">
            <div class="col text-wrap mt-4" id="addcol1">
                    <label for="">Last Name<i style="color: red;">*</i></label>
                    <input type="text" name="lastname" id="" class="form-control mb-4" value="<?=$fetchflag -> emp_lastname?>" required>
                    <label for="">First Name<i style="color: red;">*</i></label>
                    <input type="text" name="firstname" min="<?=$previous?>" id="" value="<?=$fetchflag -> emp_firstname?>" class="form-control mb-4" required>
                    <label for="">Middle Name <i>(optional)</i></label>
                    <input type="text" name="middlename" id="" class="form-control mb-4" value="<?=$fetchflag -> emp_middlename?>" >
                      <label for="">Contact No.<i></i></label>
                    <input type="number" name="contact" id="" class="form-control mb-4" value="0<?=$fetchflag -> contact?>" >
                     
                  
            </div>
            <div class="col mt-4">
                 <label for="">Email <i></i></label>
                    <input type="email" name="email" id="" class="form-control mb-4" value="<?=$fetchflag -> email?>" required >
                        <label for="">Birthdate<i style="color: red;">*</i></label>
                    <input type="date" name="bday" id="" class="form-control mb-4" value="<?=$fetchflag -> emp_birth?>">
                    <label for="">Type<i style="color: red;">*</i></label>
                    <select name="type" id="" value="<?=$thistype?>"  class="form-control mb-4" >
                        <option value="EMPLOYEE">EMPLOYEE</option>
                        <option value="ADMIN">ADMIN</option>
                       

                    </select>  
            </div>
        </div>

   
     <div class="row">
        <div class="col">

        </div>
        <div class="col-sm-3 d-flex">
     <button type="submit" name="submit" class="btn btn-success w-100 me-2 shadow-table">Save</button>
        <a href="mainmember.php" class="btn btn-secondary w-100 shadow-table" >Cancel</a>
        </div>
      </div>
    </form>

      <!-- card end -->
    </div>
  </div>
                        
</div>
        <div class="row">
            <div class="col">


            <div class="card text-center">
                    <div class="card-title mt-4 mb-0">

    

    <!-- Collapsible Content -->
  <div class="collapse" id="myCollapse">
    <div class="card card-body">
    <div class="container-fluid">
          <div class="container-fluid text-center mb-4">
                     <b>  UNSETTLED AND UNPAID BILLS </b>
                       </div>
                        <table id="myTable" class="table shadow-table" style="overflow-y: scroll; max-height: 300px;">
                        <thead style=" position: sticky; top:0;">
                            <tr class="mx">
                                <th scope="col" class="thead" >Bill No.</th>
                                <th scope="col" class="thead" >MONTH</th>
                                <th scope="col" class="thead" >AMOUNT</th>
                                <th scope="col" class="thead" ></th>
                            </tr>
                        </thead>
                     <tbody>

                   <?php 
                               
                                // while ($info = mysqli_fetch_object($member)) {
                                    // echo $data;
                                    $queries = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid ='$customerid' AND remarks ='NO' ORDER BY billno DESC ");

                                    
                                if(isset($_GET['datasort'])){
                                    $sort = $_GET['datasort'];
                                        if($sort == ""){
                                            $queries = mysqli_query($customercon,"SELECT * FROM customerinfo");

                                            
            
                                        }else{
                                            $queries = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE Barangay = '$sort'");
                                            
                                        }
                                }
                     
                          if($queries){
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
                                    <td class="spaceinside text-end pe-4 fade-in-up" style="">
                                   <?php 
                                   
                                   ?>
                                   <!-- <a href="addpaymentbill.php?customerid=<?=$customid?>&billnum=<?=$info -> billno?>" class="btn btn-primary ">Pay</a>
                                   <a href="viewpayment.php?customerid=<?=$customid?>&billnum=<?=$info -> billno?>" class="btn btn-info " style="color:#072F5F; font-weight: bold;"><i class="bi bi-eye"></i></a> -->
                                  
                                   <!-- <a href="addbill.php?meternumber=<?=$info -> MeterNumber?>" class="btn btn-warning">View</a> -->
                                    <!-- <a href="addbill.php?meternumber=<?=$info -> MeterNumber?>" class="btn btn-success ">Print</a></td> -->
                                    <a href="addpaymentbill.php?customerid=<?=$cpd?>&billnum=<?=$billnum?>" class="btn" style="background-color:#007c92; color: white;" title="ADD PAYMENT"><i class="fs-6 bi bi-plus"></i> Payment</a>
                                    <a href="addbill.php?customerid=<?=$info -> customerid?>" class="btn " style="background-color:  #009a9c; color: white;" title ="Add / Create Bill"><i class="fs-6 bi bi-plus"></i>Bill</a>
                                    <a href="viewreceipt.php?customerid=<?=$customerid?>&billnum=<?=$info -> billno?>" target="_blank" class="btn btn-success">      <i class="bi bi-printer"></i> Print</a>
                                       

                                    <!-- <a href="viewbills.php?customerid=<?=$info -> customerid?>" class="btn " style="background-color:  #67d294; color: white;">View</a> -->
                                    <a href="user_profile.php?customerid=<?=$info -> customerid?>"  class="btn btn-primary btn-md">  <i class="bi bi-pencil-square" title="Edit"></i></a>
                                   
                                        <a href="delete_bill.php?customerid=<?=$info -> customerid?>&billnum=<?=$info -> billno?>&remarks=<?=$info -> remarks?>" id="preventdelete" data-id="<?=$info -> customerid?>" class="dlt-btn btn btn-outline-danger btn-md" title="Delete"> <i class="bi bi-trash"></i></a></td>
                          

                                </td>



                            </tr>
                           
                                    <?php
                              }  //closing ng loop ng query
                            }else{
                              ?>
                            <tr class="text-center cc" >
                                <td colspan ="12" style="font-size: 1.5rem;">No Result Found</td>
                            </tr>
                              <?php 
                            }

                    
                            ?>      
                            </tbody>

                            </table>
                        </div>
    </div>
  </div>
<!-- paid bills -->
 <div class="collapse" id="myCollapse4">
    <div class="card card-body p-4 ">
      Fill this field to update information
     
      <?php
     
      ?>
      <form action="" method="post">

      <div class="row mt-4">
       
        <div class="col p-4">
                     
        <!-- <label for="currentpassword">Current Password</label> -->
        <!-- <input type="password" name="currentPassword" class="form-control"  id=""> -->
                    

            
        </div>
        <div class="col p-4">
                    <label for="newPassword">New Password:</label>
    <input type="password" id="newPassword" class="form-control" name="newPassword" oninput="checkMatch()">

    <label for="repeatPassword">Repeat New Password:</label>
    <input type="password" id="repeatPassword" class="form-control"  name="repeatPassword" oninput="checkMatch()">
    <div id="message"></div>

        </div>
        <div class="col">

        </div>
                  </div>
        <div class="row">
           <div class="col"></div>
            <div class="col"></div>
                    <div class="col-sm-3 d-flex justify-content-center align-items-end">
     <button type="submit" name="change" class="btn btn-success w-100 me-2 shadow-table">UPDATE</button>
        <a href="user_profile.php?customerid=<?=$customerid?>" class="btn btn-secondary w-100 shadow-table" >Cancel</a>
        </div>
        <div class="col">
        </div>
        <div class="col"></div>
        </div>
      </div>
      </form>

      <!-- card end -->
    </div>
  </div>
<div class="collapse" id="myCollapse2">
    <div class="card card-body">
    <div class="container-fluid mt-4">
                                  <div class="container-fluid text-center mb-4">
                                         <b>  SETTLED AND PAID BILLS </b>

                       </div>
                                <table id="myTable" class="table shadow-table" style="overflow-y: scroll; max-height: 300px;">
                        <thead style=" position: sticky; top:0;">
                            <tr class="mx">
                                <th scope="col" class="thead" >Bill No.</th>
                                <th scope="col" class="thead" >MONTH</th>
                                <th scope="col" class="thead" >AMOUNT</th>
                                <th scope="col" class="thead" ></th>
                            </tr>
                        </thead>
                     <tbody>

                   <?php 
                               
                                // while ($info = mysqli_fetch_object($member)) {
                                    // echo $data;
                                    $queries = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid ='$customerid' AND remarks ='YES' ORDER BY billno DESC ");

                                    
                                if(isset($_GET['datasort'])){
                                    $sort = $_GET['datasort'];
                                        if($sort == ""){
                                            $queries = mysqli_query($customercon,"SELECT * FROM customerinfo");

                                            
            
                                        }else{
                                            $queries = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE Barangay = '$sort'");
                                            
                                        }
                                }
                     
                          if($queries){
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
                                   <!-- <a href="addpaymentbill.php?customerid=<?=$customid?>&billnum=<?=$info -> billno?>" class="btn btn-primary ">Pay</a>
                                   <a href="viewpayment.php?customerid=<?=$customid?>&billnum=<?=$info -> billno?>" class="btn btn-info " style="color:#072F5F; font-weight: bold;"><i class="bi bi-eye"></i></a> -->
                                  
                                   <!-- <a href="addbill.php?meternumber=<?=$info -> MeterNumber?>" class="btn btn-warning">View</a> -->
                                    <!-- <a href="addbill.php?meternumber=<?=$info -> MeterNumber?>" class="btn btn-success ">Print</a></td> -->
                                    <!-- <a href="addpaymentbill.php?customerid=<?=$cpd?>&billnum=<?=$billnum?>" class="btn" style="background-color:#007c92; color: white;" title="ADD PAYMENT"><i class="fs-6 bi bi-plus"></i> Payment</a> -->
                                    <!-- <a href="addbill.php?customerid=<?=$info -> customerid?>" class="btn " style="background-color:  #009a9c; color: white;" title ="Print"><i class="fs-6 bi bi-plus"></i>print</a> -->
                                    <a href="print_receipt.php?customerid=<?=$customerid?>&billnum=<?=$info -> billno?>" target="_blank" class="btn btn" title ="Print"  style="background-color:  #009a9c; color: white;"><i class="bi bi-printer"></i> Print</a>

                                        <a href="viewbills.php?customerid=<?=$info -> customerid?>" class="btn " style="background-color:  #67d294; color: white;">View</a>
                                    <!-- <a href="user_profile.php?customerid=<?=$info -> customerid?>"  class="btn btn-primary btn-md">  <i class="bi bi-pencil-square" title="Edit"></i></a> -->
                                   
                                        <!-- <a href="delete_customer.php?customerid=<?=$info -> customerid?>" id="preventdelete" data-id="<?=$info -> customerid?>" class="dlt-btn btn btn-outline-danger btn-md" title="Delete"> <i class="bi bi-trash"></i></a></td> -->
                                        <a href="delete_bill.php?customerid=<?=$info -> customerid?>&billnum=<?=$info -> billno?>&remarks=<?=$info -> remarks?>" id="preventdelete" data-id="<?=$info -> customerid?>" class="dlt-btn btn btn-outline-danger btn-md" title="Delete"> <i class="bi bi-trash"></i></a></td>
                              

                                </td>



                            </tr>
                           
                                    <?php
                              }  //closing ng loop ng query
                            }else{
                              ?>
                            <tr class="text-center cc" >
                                <td colspan ="12" style="font-size: 1.5rem;">No Result Found</td>
                            </tr>
                              <?php 
                            }

                    
                            ?>      
                            </tbody>

                            </table>
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
<?php if (isset($_SESSION['update'])): ?>
<script>
Swal.fire({
  title: 'UPDATED SUCCESSFULY!',
//   text: ''.',
  icon: 'success',
  confirmButtonColor: '#4f46e5'
});
</script>
<?php unset($_SESSION['update']); 
 
endif; ?>
</body>
</html>