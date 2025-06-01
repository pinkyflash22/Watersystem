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
    header("location: maintransaction.php?search=$datasearch");
}

if(isset($_POST['pay'])){
    $receipt = $_POST['receipt'];
    $payment = $_POST['amountopay'];
    $amount = $_POST['amounted'];
    // $bill = $_POST['billno'];
    $idofcustomer = $_POST['custid'];
    $billnumber = $_POST['billid'];
    $collectorid = $_SESSION['id'];

    $getcollector = mysqli_query($customercon,"SELECT * FROM employeeaccount WHERE accountid = '$collectorid'");
    $gettheid = mysqli_fetch_object($getcollector);
    $idcollector = $gettheid -> emp_id;
    $date = date("Y-m-d"); //date today if paying ganern
   
    // $getquery = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid = '$cusid'  AND billno ='$billno'");
    // $fetch = mysqli_fetch_object($getquery);
    // $theid = $fetch -> customerid;
    $change = $payment -  $amount;
     $collectquery = mysqli_query($customercon,"INSERT INTO collected VALUES(null,'$receipt','$date','$change','$billnumber','$idcollector','$idofcustomer')");

     $updatebill = mysqli_query($customercon,"UPDATE bills SET remarks ='YES' WHERE billid = '$billnumber'");

     $getquery = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid = '$customid' AND remarks ='NO' ORDER BY billno DESC");
     $fetchit = mysqli_fetch_object($getquery);
     $billnos = $fetchit->billno;

     header("location:addpaymentbill.php?customerid=$idofcustomer&billnum=$billnos");
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
        color: white;
        text-decoration: none;
        padding: .25rem;
       }
       a:hover{
        background-color: lightblue;
    
       }
       aside{
        background-color: darkblue;
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
       .inputs{
        width: 50%;
        height: auto;
        border-radius: 0.5rem;
        padding-left: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        margin-right: 1rem;
       }
       .inputs:focus{
        box-shadow: 0 0 3px darkslategray;
        outline: none;
       }
       .inputs:active{
        box-shadow: 0 0 5px darkslategray;
        outline: none;
       }
       .modify{
        box-shadow: none !important;
       }
       table thead tr .thead{
        background-color:darkblue;
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
     .hove:hover{
        transform: scale(1.1);
        cursor: pointer;
        box-shadow: 0 0 4px darkblue;
        transition: ease-in-out 100ms;
       }
    </style>  
</head>
<body>


<header>

</header>

<main class="d-flex">
<aside class="sidebar text-white">
<div class="container mt-4 mb-4 d-flex align-items-center ">
<img src="icons/urbiztondo-seal-1040x1040.png" class="w-25 img-fluid me-3" alt="">
<div class="col d-flex align-items-center" style="font-size: .75rem;"><p class="pt-2">Urbiztondo Water Services</p></div>

</div>
<hr style="outline: 1px solid  rgb(225, 242, 246);opacity:100; width: auto;">
    <nav class="d-flex flex-column p-3 mt-4 items">
       
<!-- <img src="Team System\dashboard (1).png" class="img-fluid w-25 p-2" alt=""> -->
        <a href="maindashboard.php" class="mb-4 fs-6"><i class="bi bi-speedometer img-fluid fs-3"></i>Dashboard</a>
        <a href="" class="mb-4 fs-6"><i class="bi bi-bank img-fluid fs-3"></i>Transaction</a>
        <a href="mainbilling.php" class="mb-4 fs-6"><img src="Team System\dashboard (1).png" class="img-fluid w-25 p-2" alt="">Billing</a>
        <a href="mainrecord.php" class="mb-4 fs-6"><img src="Team System\dashboard (1).png" class="img-fluid w-25 p-2" alt="">Records</a>
        <a href="mainmember.php" class="mb-4 fs-6"><img src="Team System\dashboard (1).png" class="img-fluid w-25 p-2" alt="">Members</a>
        <a href="logout.php" class="mb-4 fs-6"><img src="Team System\dashboard (1).png" class="img-fluid w-25 p-2" alt="">Logout</a>
    </nav>
    </aside>
    <div class="container mt-1 mainbox">

        <div class="card p-4">
            <div class="card-title fs-3">
            <img src="Team System\dashboard.png" class="img-fluid imgs">PAYMENT 
            </div>
        </div>  

        <div class="row">
            <div class="col">



            <form action="" method="get" id="sortform">      

            <div class="card text-center">
                    <div class="card-title mt-4 mb-0">

                    <form action="" method="get">
                    <input type="search" name="search" id="search" class="inputs" placeholder="Search by category...."> 
                    <input type="submit" class="btn btn-primary " name="searchbutton" value="Search"> 
                    </form>
                        
                        <!-- <select name="filter" class="btn btn-light" id=""></select>
                          -->
                          <?php 
                            
                                     $member = mysqli_query($customercon,"SELECT * FROM coveredareas");
                                     
                                     //default

                                     
                                   
                                    ?>
                          <select name="datasort" id="sort" onchange ="this.form.submit()" class="btn btn-light">
                                            <option value="" disabled selected><i></i></option>    
                                            <option value="" href="maintransaction.php">ALL</option>
                                            <?PHP 
                                                while($get = mysqli_fetch_object($member)){
    
                                            ?>
                            <option value="<?= $get-> barangayid?>"><?=$get->area?></option>

                                            <?php 
                                                }
                                            ?>
                                        </select>
                    </div>
                    <div class="card-body" style="text-align: left;">
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

                        echo $penalty;
                        }else{

                        }       
                        
                       ?>
                       <div class="container-fluid ">
                            <div class="row mb-4 ">
                               <div class="col " style="height: 150px;">
                                    <div class="card text-center hove" style="border-top: 5px solid blue; height: 100%; box-shadow: 1px 1px 5px lightgray;">
                                        <div class="card-title">

                                        </div>
                                        <div class="card-body">
                                        <?php 
                                            if($display){

                                            
                                            ?>
                                        <h2 class="h2"><?=$display -> billno?></h2>
                                       
                                        <h5 class="h5">BILL NO. </h5>
                                   
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
                               <div class="card text-center hove" style="border-top: 5px solid blue; height: 100%; box-shadow: 1px 1px 5px lightgray;">
                                        <div class="card-title">

                                        </div>
                                        <div class="card-body">
                                        <?php 
                                            if($display){

                                            
                                            ?>
                                        <h2 class="h2"><?=$display -> consumption?></h2>
                                       
                                        <h5 class="h5">CONSUMPTION </h5>
                                        <sub>Cubic Meter</sub>
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
                               <div class="card text-center hove" style="border-top: 5px solid blue; height: 100%; box-shadow: 1px 1px 5px lightgray;"> 
                                        <div class="card-title">
                                               
                                        </div>
                                        <div class="card-body">
                                        <?php 
                                            if($display){

                                            
                                            ?>
                                        <h2 class="h2"><?=$amounto + $penalty?></h2>
                                        <h5 class="h5">TOTAL AMOUNT DUE</h5>
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
                               <div class="card text-center hove" style="border-top: 5px solid blue; height: 100%; box-shadow: 1px 1px 5px lightgray;">
                                        <div class="card-title">

                                        </div>
                                        <div class="card-body">
                                            <?php 
                                            if($display){

                                            
                                            ?>
                                        <h3 class="h3"><?=$display -> period?></h3>
                                        <h5 class="h5">PERIOD</h5>
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
                       
                       <?php 
                        if($display){

                        
                       ?>
                       <div class="container mb-4">
                        
                       <form action="" method="post" class="form-group">
                       <label for="">Please Fill up this field<i style="color: red;">*</i></label>  
                       <hr>
                        <div class="row p-1  mb-2">
                            
                                <div class="col">
                        
                                    <label for="amount">Receipt Number<i style="color: red;">*</i></label>
                                    <input type="number" name="receipt" id="" class="form-control" placeholder ="" required>
                                        
                            
                                </div>
                                <div class="col">
                                    <label for="amount">Amount<i style="color: red;">*</i></label>
                                            <?php
                                            if($display){
                                            ?>
                                        <input type="number" name="amountopay" min="<?=$amounto + $penalty?>" id="" value="" class="form-control" required>
                                        <input type="number" name="amounted" value="<?=$display -> amount?>" id="" class="form-control" hidden>
                                        <input type="number" name="billno" value="<?=$display -> billno?>" id="" class="form-control" hidden>
                                        <input type="number" name="custid" value="<?=$display -> customerid?>" id="" class="form-control" hidden>
                                        <input type="number" name="billid" value="<?=$display -> billid?>" id="" class="form-control" hidden>
                                    




                                        <?php 
                                        }else{                 
                                        ?>
                                        <input type="number" name="amountopay" min="0" id="" class="form-control">

                                        <?php 
                                        }
                                        ?>
                                </div>
                            
                        </div>
                            <div class="row p-1">
                                <div class="col">

                                </div>
                                        <div class="col " style="display:flex; justify-content: end;">
                                        <input type="submit" name="pay" value="Pay"  class="btn btn-primary w-50 form-control">
                                        </div>
                            </div>
                            <br>
                            <hr>
                        </form>
                       </div>
                       <?php 
                        }
                        ?>

                        <div class="container-fluid">
                        <table class="table" style="overflow-y: scroll; max-height: 300px;">
                            
                        
                        <thead style=" position: sticky; top:0;">
                            <tr class="mx">
                                <th scope="col" class="thead" >BILL NO.</th>
                                <th scope="col" class="thead" >PERIOD</th>
                                <th scope="col" class="thead" >SUB TOTAL <i class="bi bi-alarm"></i></th>
                                <th scope="col" class="thead" ></th>


                            </tr>
                        </thead>
                     <tbody>
                            <tr>
                  <?php 
                 $cust = mysqli_connect("localhost", "root", "","customercard");
                 $result = $cust -> query("SELECT * FROM bills WHERE remarks ='NO'");
                                //    $data= mysqli_query($customercon,"SELECT * FROM bills");

                                   while($row = $result -> fetch_assoc()){
                                     $year =   $row['readingdate'];
                                    $periodyear = substr($year, 0, 4);

                                    ?>
                                <th scope ="row" class="spaceinside om" style="width: 15%;" id="meter"><?=$row['billno']?></th>

                                    <td class="spaceinside" style="width: 40%;" id="names"><?=$row['period']." ".$periodyear?></td>
                                    <td class="spaceinside" style="width: 25%;"><?=$row['consumption']?></td>
                                    <td class="spaceinside text-center" style="width: 20%;">

                                    
                                        <button class="editBtn btn btn-primary" 
                                        data-id='<?=$row['billid']?>'
                                         
                                        data-period='<?=$row['duedate']?>' 
                                        data-month ='<?=$row['period']?>'
                                        data-consump = '<?=$row['consumption']?>'
                                        data-bill = '<?=$row['billno']?>'
                                        data-customer = '<?=$row['customerid']?>'
                                        data-employee = '<?=$_SESSION['id']?>'
                                        data-bs-toggle='modal' 
                                        data-bs-target='#editModal' >
                                        Add Payment
                                        </button>
                            
                                   </td>
                                 

                            </tr>
                                        

                            <?php 
                                } //closing ng loop ng query
                            
                            
                            ?>
                     </tbody>
                                <div class="container-fluid">
                                <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <form action="add_pay.php" method="post">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title">
                                                    Payment Process - <span id="user"></span>
                                                </div>
                                            </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col " style="height: 5rem;">
                                            <div class="card text-center hove" style="border-top: 5px solid blue; height: 100%; box-shadow: 1px 1px 5px lightgray;">
                                                    <div class="card-title"> </div>
                                                    <div class="card-body">
                                                        <h6><span id="userbill"></span></h6>
                                                        <p>Bill No.</p>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col " style="height: 5rem;">
                                             <div class="card text-center hove" style="border-top: 5px solid blue; height: 100%; box-shadow: 1px 1px 5px lightgray;">
                                                <div class="card-title"></div>
                                                    <div class="card-body">
                                                        <h6><span id="usermonth"></span></h6>
                                                        <p>Period</p>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            <div class="col " style="height: 5rem;">
                                             <div class="card text-center hove" style="border-top: 5px solid blue; height: 100%; box-shadow: 1px 1px 5px lightgray;">
                                                <div class="card-title"></div>
                                                    <div class="card-body">
                                                        <h6><span id="usercon"></span></h6>
                                                        <p>Consumption</p>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        <div class="col " style="height: 5rem;">
                                            <div class="card text-center hove" style="border-top: 5px solid blue; height: 100%; box-shadow: 1px 1px 5px lightgray;">
                                                <div class="card-title"></div>
                                                    <div class="card-body">
                                                           <h6><span id="subtotal"></span></h6>
                                                            <p>Total Amount</p>                                       
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="col " style="height: 5rem;">
                                                <div class="card text-center hove" style="border-top: 5px solid blue; height: 100%; box-shadow: 1px 1px 5px lightgray;">
                                                    <div class="card-title"></div>
                                                        <div class="card-body">
                                                           <h6><span id="duedate"></span></h6>
                                                           <p>Due Date</p>
                                                        </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mt-4">
                                        <div class="container-fluid">
                                            <div class="col">
                                                <label for="">Receipt Number</label>
                                                <input type="number" name="ornum" id="" class="form-control" required>
                                                <input type="hidden" name="id" id="userid">
                                            </div>
                                            <div class="col">
                                                <label for="">Amount</label>
                                                <input type="number" name="amounts" min="" class="form-control" id="topay" required>
                                                <input type="number" name="billnum" min="" id="billnum" hidden>
                                                <input type="number" name="customerid" min="" id="customerid" hidden>
                                                <input type="number" name="emp" min="" id="emp" hidden>
                                                <input type="date" name="date" min="" id="now" hidden>
                                                <input type="number" name="cons" min="" id="consumption" hidden>
                                                <input type="number" name="penalty" min="" id="penalty" hidden>



                                                

                                            </div>
                                        </div>
                                    </div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Pay</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            </table>
                            
                        </div>
                    </div> 
                    <!-- card b ody end -->
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
    document.addEventListener("DOMContentLoaded", () =>{
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', () => {

        let amou = btn.dataset.consump;
        let amounted = amou;
        if(amou > 10){
            amounted = amou * 25;
        }else{
            amounted= 250;
        }

        document.getElementById('userid').value = btn.dataset.id;
       let date =  btn.dataset.period;

       //duedate ito
        let duemonth = date.substr(5,2); //month of due date
        let year = date.substr(0,4); //year of due date
        let dayofdue = date.substr(8,2);

        let xduemonth = parseInt(duemonth);
        let xyear = parseInt(year);
        let xdayofdue = parseInt(dayofdue);



        //date section today
            const now = new Date();
            const formatter = new Intl.DateTimeFormat('en-CA', {
                timeZone: 'Asia/Manila',
                year : 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
            const formattedDate = formatter.format(now);
            console.log("formatted: ", formattedDate);

            const yyyy =  formattedDate.substr(0, 4); 
            const mm = formattedDate.substr(5, 2);
            const dd = formattedDate.substr(8, 2);

        let xyyyy = parseInt(yyyy);
        let xmm = parseInt(mm);
        let xdd = parseInt(dd);

            
            
    // end of date section
            document.getElementById('now').value = yyyy +"-"+mm+"-"+dd; //date today
            
          document.getElementById('billnum').value = btn.dataset.bill; //number ng bill nya
           document.getElementById('customerid').value = btn.dataset.customer;
           //user
           document.getElementById('user').value = btn.dataset.customer;
        

            document.getElementById('emp').value = btn.dataset.employee;
            document.getElementById('consumption').value =btn.dataset.consump ;

            document.getElementById('topay').min = amounted;

let penalty;

        document.getElementById('usermonth').textContent = btn.dataset.month;
        document.getElementById('usercon').textContent = btn.dataset.consump;

          document.getElementById('userbill').textContent = btn.dataset.bill; //number ng bill nya
        // document.getElementById('duedate').textContent = duemonth;
        
var monthw ;
        //check condition
        const monthword = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", 
                            "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"] ;  
            for(let i = 0; i < monthword.length ; i++){
            if(duemonth -1 == i){ //subrtract ng isa kasi naka aaray hays
            monthw = monthword[i]; //textvalue na to             
            }
            }
        document.getElementById('duedate').textContent = monthw;


        if(xyyyy > xyear){
            penalty = 0.10 * amounted;
        }else if(xyyyy < xyear){
                penalty = 0;

        }else if(xyyyy == xyear){
            if(xmm > xduemonth){
                                    // if($daytoday > $day){
                                    //     $penalty = 0.10 * $amounto;
                                    // }else{
                                    // $penalty = 0;
                                    // }
                penalty = 0.10 * amounted;

                                }else if(xmm == xduemonth){
                                         if(xdd > xdayofdue){
                                            penalty = 0.10 * amounted;
                                        }else{
                                        penalty = 0;
                                        }
                                }else if(xmm < xduemonth){
                                    penalty = 0;
                                }
                            }
            document.getElementById('penalty').value = penalty;
        document.getElementById('subtotal').textContent = amounted + penalty;
                        


    }); //click
    }); // button
    }); //dom 
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
    
    
 

</script>
</body>
</html>