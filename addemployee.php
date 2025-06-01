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
   $customid = $_GET['customerid'];
    $billnum = $_GET['billnum'];


        if(isset($_GET['changebill'])){
            $billnum = $_GET['billnum'];

        }

    //     $sqlt = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE MeterNumber = '$meternumber'");
    //     $getsql = mysqli_fetch_object($sqlt);
    //     $idc = $getsql -> customerid;

    // $descquery = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid = '$idc' ORDER BY billno DESC");
    // $presentbillno = mysqli_fetch_object($descquery);
    // $thebill = $presentbillno -> billno;
}


if(isset($_GET['searchbutton'])){
    $datasearch = $_GET['search'];
    // header("location: addpaymentbill.php?customerid=$customid&billnum=$info -> billno&search=$datasearch");
   echo $customid;
}

// if(isset($_POST['pay'])){
//     $receipt = $_POST['receipt'];
//     $payment = $_POST['amountopay'];
//     $amount = $_POST['amounted'];
//     // $bill = $_POST['billno'];
//     $idofcustomer = $_POST['custid'];
//     $billnumber = $_POST['billid'];
//     $collectorid = $_SESSION['id'];

//     $getcollector = mysqli_query($customercon,"SELECT * FROM employeeaccount WHERE accountid = '$collectorid'");
//     $gettheid = mysqli_fetch_object($getcollector);
//     $idcollector = $gettheid -> emp_id;
//     $date = date("Y-m-d"); //date today if paying ganern
   
//     // $getquery = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid = '$cusid'  AND billno ='$billno'");
//     // $fetch = mysqli_fetch_object($getquery);
//     // $theid = $fetch -> customerid;
//     $change = $payment -  $amount;
//      $collectquery = mysqli_query($customercon,"INSERT INTO collected VALUES(null,'$receipt','$date','$change','$billnumber','$idcollector','$idofcustomer')");

//      $updatebill = mysqli_query($customercon,"UPDATE bills SET remarks ='YES' WHERE billid = '$billnumber'");

//      $getquery = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid = '$customid' AND remarks ='NO' ORDER BY billno DESC");
//      $fetchit = mysqli_fetch_object($getquery);
//      $billnos = $fetchit->billno;

//      header("location:addpaymentbill.php?customerid=$idofcustomer&billnum=$billnos");
// }
$meternum ="";
$lastname ="";
$firstname = "";
$middlename = "";
$barangay ="";
$type = "";
$emailadd = ""."@gmail.com";


if(isset($_POST['submit'])){
    $meternum = $_POST['meternumber'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $barangay = $_POST['barangay'];
    $type = $_POST['type'];
$house = $_POST['house'];
$street = $_POST['street'];

    $checker = mysqli_query($customercon, "SELECT * FROM customerinfo WHERE meternumber ='$meternum'");
    $getdata = mysqli_fetch_object($checker);
    if($getdata){
     $_SESSION['success'] = true;

    }else{
        // echo "walang katulad";
        // query dito
        if($type == "INDIVIDUAL"){
            $statusid = 1;
        }else{
            $statusid= 3;
        }
        $username ="mmmm";
        $insertinaccount = mysqli_query($customercon,"INSERT INTO accounts VALUES(null,'$username','$meternum','CONSUMER')");
//pansamantala ooo muna email
if($insertinaccount){
        $getaccountid = mysqli_query($customercon,"SELECT * FROM accounts ORDER BY accountid DESC");
          $getinput = mysqli_fetch_object($getaccountid);
          $accountid = $getinput -> accountid;
}
        $insertquery = mysqli_query($customercon, "INSERT INTO customerinfo VALUES(null,'$meternum','$lastname','$firstname','$middlename','$house','$street','$barangay','$statusid','$accountid')");
        
     
       if($insertquery){
        $mysql = mysqli_query($customercon,"SELECT * FROM customerinfo ORDER BY customerid DESC");
        $getinfo = mysqli_fetch_object($mysql);

        $customercredential = $getinfo -> customerid;
/// add ng account para sakanila
        if($customercredential < 10){
          $username = "USER-00".$customercredential;
        }elseif($customercredential >=10){
          $username = "USER-0".$customercredential;

        }elseif($customercredential >=100){
          $username = "USER-".$customercredential;
        }

        if($insertinaccount){
          $update = mysqli_query($customercon,"UPDATE accounts SET username='$username' WHERE accountid ='$accountid'");
         
          // $update = mysqli_query($customercon,"UPDATE customerinfo SET accountid='$accountid' WHERE customerid ='$customercredential'");
             if($update){
               echo "<script>alert('ADDED SUCCESSFULLY');</script>";
                $_SESSION['success'] = true;
                header("Location: " . $_SERVER['PHP_SELF']);
                // header("location:mainmember.php");
                exit;
             }
        }
    
       }
      }

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
        <div class="container-fluid p-2 ps-2 mt-2 mb-4">
<div class="row">
    <div class="col" style="display: flex; align-items:center; color: darkslategray;">
      <i class="bi bi-bank img-fluid fs-1 me-3" ></i> MEMBER / ADD EMPLOYEE
          
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

    <!-- <form action="" method="get" id="sortform">       -->

       <div class="card p-4" style="background-color:#007c92;">
            <div class="card-title fs-3 fade-in" style="display: flex; align-items:center; color: white;">
                <div class="row  w-100" style=" display:flex; align-items: center;">
                    
                    <div class="col text-whire" style=" display:flex;  flex-direction: column;">
                 
                            <div class="row fs-5 ps-4"> Hello,  <?=$position?>!</div>
                            <div class="row fs-6 ps-4">  You can add a payment, create and view bills. </div>
                    
                    </div>
            <div class="col-sm-4" style=" display:flex; align-items: center;">

                   
                     <input type="text" id="searchInput" class="form-control w-75" placeholder="Search..." onkeyup="searchTable()">

                </div>
            </div>
  </div>
       

        <div class="row">
            
            <div class="col">

           <form method="POST" class="modal-content bg-light p-4 mt-2" style="border-radius: 1rem;">
     
      <div class="container-fluid ">
       <div class="row">
            <div class="col text-wrap mt-4" id="addcol1">
                    <label for="meternumber">Meter Number<i style="color: red;">*</i></label>
                    <input type="number" name="meternumber" id="" min="10000000" value="<?=$meternum?>" class="form-control mb-4" required>
                    <label for="">Last Name<i style="color: red;">*</i></label>
                    <input type="text" name="lastname" id="" class="form-control mb-4" value="<?=$lastname?>" required>
                    <label for="">First Name<i style="color: red;">*</i></label>
                    <input type="text" name="firstname" min="<?=$previous?>" id="" value="<?=$firstname?>" class="form-control mb-4" required>
                    <label for="">Middle Name <i>(optional)</i></label>
                    <input type="text" name="middlename" id="" class="form-control mb-4" value="<?=$middlename?>" >
            </div>
                <div class="col mt-4">
                <?php 
                $member = mysqli_query($customercon,"SELECT * FROM coveredareas");
                 ?>
                    <label for="">Barangay<i style="color: red;">*</i></label>
                    <select name="barangay" value="<?=$barangay?>"id="" class="form-control mb-4">
                    
                        <?PHP 
                                                while($get = mysqli_fetch_object($member)){
    
                                            ?>
                                            <option value="<?= $get->barangayid?>"><?=$get->area?></option>
                                            <?php 
                                                }
                                            ?>


                    </select>
                    <label for="">Type<i style="color: red;">*</i></label>
                    <select name="type" id="" value="<?=$type?>" class="form-control mb-4">
                        <option value="INDIVIDUAL">Individual</option>
                        <option value="BOOSTER">Booster</option>

                    </select>
                    <label for="">House / Lot No.<i style="color: red;">*</i></label>
                    <input type="text" name="house" min="<?=$previous?>" id="" value="" class="form-control mb-4" required>
                    <label for="">Street Name<i style="color: red;">*</i></label>
                    <input type="text" name="street" id="" class="form-control mb-4" value="" >
                    
                </div>
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
// function searchTable() {
//   const input = document.getElementById("searchInput");
//   const filter = input.value.toLowerCase();
//   const table = document.getElementById("myTable");
//   const trs = table.getElementsByTagName("tr");

//   for (let i = 1; i < trs.length; i++) {
//     const row = trs[i];
//     const text = row.textContent.toLowerCase();
//     row.style.display = text.includes(filter) ? "" : "none";
//   }
// }

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
    
    <?php if (isset($_SESSION['success'])): ?>
<script>
Swal.fire({
  title: 'Success!',
  text: 'Employee added successfully.',
  icon: 'success',
  confirmButtonColor: '#4f46e5'
});
</script>
<?php unset($_SESSION['success']); endif; ?>

 

</script>
</body>
</html>