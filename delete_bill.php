<?php
session_start();
if(!isset($_SESSION['id'])){
    header("location:interface.php");
}

include("connection.php");
$emp =  $_SESSION['id'];

$selectquery = mysqli_query($customercon,"SELECT * FROM employeeaccount WHERE accountid ='$emp'");
$getemp = mysqli_fetch_object($selectquery);
$deletor = $getemp -> emp_id;

$person = $_GET['customerid'];
$remarks = $_GET['remarks'];

$accountidquery = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE customerid='$person'");
$g = mysqli_fetch_object($accountidquery);
$meternumber = $g -> MeterNumber;
$lastname = $g -> LastName;
$firstname = $g -> FirstName;
$middlename = $g -> MiddleName;
$barangay = $g -> Barangay;
$accountid = $g -> accountid;

$datah = mysqli_query($customercon,"SELECT * FROM accounts WHERE accountid ='$accountid'");
$getdatah = mysqli_fetch_object($datah);
$username = $getdatah -> username;
$password = $getdatah -> password;




$billnum = $_GET['billnum'];
// $deleteid = 0;
$getdeletes = mysqli_query($customercon,"SELECT * FROM archive_account WHERE username='$username' AND oldpassword='$password'");

if(mysqli_num_rows($getdeletes) > 0){
// if may account na don

// echo 0;
// echo "<br>".$meternumber;
$functional = mysqli_fetch_object($getdeletes);
$deleteid= $functional -> accountdelete;
$deletion = mysqli_query($customercon,"SELECT * FROM archive_customer WHERE deleteaccountid = '$deleteid'");
$fetchdeletion = mysqli_fetch_object($deletion);
$customer_deleted_id = $fetchdeletion -> customer_deleted_id;

if($accountidquery) //if may laman
{
$getquery = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid ='$person' AND billno ='$billnum' AND remarks='$remarks'"); //check natin if may bills sya
$fetch = mysqli_fetch_object($getquery);
 $amounto = $fetch -> amount;
                            $billid = $fetch -> billid;
                        // $readdate = $fetch -> readingdate;
                        // $duedate = $fetch -> duedate;
                        $consump = $fetch -> consumption;
                        $period = $fetch -> period;
                        $totalamount = $fetch -> amount;
                        $dateofread = $fetch -> readingdate;
                        
                        if($remarks=="YES"){
                            $remarks = "UNPAID";
                        }else{
                            $remarks = "PAID";

                        }
                        $check = mysqli_query($customercon,"SELECT * FROM archive_customer WHERE meternumber ='$meternumber'");
                        if($check -> num_rows >0){

                        }else{

                        $archive = mysqli_query($customercon,"INSERT INTO archive_customer VALUES(null,'$meternumber','$lastname','$firstname','$middlename','$barangay','$customer_deleted_id')");

                        }

$insertquery = mysqli_query($customercon,"INSERT INTO archive_bills VALUES (null,'$billnum','$customer_deleted_id','$period','$totalamount','$consump','$deletor','$remarks','$dateofread')" );
 $delete = mysqli_query($customercon,"DELETE FROM bills WHERE customerid='$person' AND billid ='$billid'");
 $_SESSION['del'] = true;
header("location: viewbills.php?customerid=$person");
exit;

 
}


}else{

    $archiveaccount = mysqli_query($customercon,"SELECT * FROM accounts WHERE accountid ='$accountid'");
    $getaccount = mysqli_fetch_object($archiveaccount);
    //get information on account
    $username = $getaccount -> username;
    $oldpass = $getaccount ->password;
    $type = $getaccount -> type;


    $inserttoaccount = mysqli_query($customercon, "INSERT INTO archive_account VALUES(null,'$username','$oldpass','$type')");
            $getdeleteid = mysqli_query($customercon,"SELECT * FROM archive_account WHERE username = '$username' AND oldpassword ='$oldpass'");
            $fetchdelete = mysqli_fetch_object($getdeleteid);
            $customer_deleted_id = $fetchdelete -> accountdelete;

    // echo 1;
$archive = mysqli_query($customercon,"INSERT INTO archive_customer VALUES(null,'$meternumber','$lastname','$firstname','$middlename','$barangay','$customer_deleted_id')");
// $getdelete = mysqli_query($customercon,"SELECT * FROM archive_customer WHERE meternumber ='$meternumber'");
// $functional = mysqli_fetch_object($getdelete);
// $deleteid = $functional -> deleteid;

if($accountidquery) //if may laman
{
$getquery = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid ='$person' AND billno ='$billnum' AND remarks='$remarks'"); //check natin if may bills sya
$fetch = mysqli_fetch_object($getquery);
 $amounto = $fetch -> amount;
                            $billid = $fetch -> billid;
                        // $readdate = $fetch -> readingdate;
                        // $duedate = $fetch -> duedate;
                        $consump = $fetch -> consumption;
                        $dateofread = $fetch -> readingdate;
                        $period = $fetch -> period;
                        $totalamount = $fetch -> amount;
                        if($remarks=="YES"){
                            $remarks = "UNPAID";
                        }else{
                            $remarks = "PAID";

                        }
 $insertquerye = mysqli_query($customercon,"INSERT INTO archive_bills VALUES (null,'$billnum','$customer_deleted_id','$period','$totalamount','$consump','$deletor','$remarks','$dateofread')" );
 $delete = mysqli_query($customercon,"DELETE FROM bills WHERE customerid='$person' AND billid ='$billid'");
 $_SESSION['del'] = true;
header("location: viewbills.php?customerid=$person");
exit;
}
}


// $getdelete = mysqli_query($customercon,"SELECT * FROM archive_customer WHERE meternumber ='$meternumber'");
// $functional = mysqli_fetch_object($getdelete);
// $deleteid = $functional -> deleteid;


?>