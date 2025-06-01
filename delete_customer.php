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
$person = $_GET['customerid']; //get user dito

$accountidquery = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE customerid='$person'");


if($accountidquery -> num_rows >0) //if may laman
{
 $account = mysqli_fetch_object($accountidquery);
 //get info dito ng customer

 $accountid = $account -> accountid; //get natin account id ng cutomer using  customer id
 $meternumber = $account -> MeterNumber;
 $lastname = $account -> LastName;
 $firstname = $account -> FirstName;
 $middlename = $account -> MiddleName;
 $barangay = $account -> Barangay;


 $archiveaccount = mysqli_query($customercon,"SELECT * FROM accounts WHERE accountid ='$accountid'");

 if($archiveaccount -> num_rows > 0)
 {

$getaccount = mysqli_fetch_object($archiveaccount);
//get information on account
$username = $getaccount -> username;
$oldpass = $getaccount ->password;
$type = $getaccount -> type;

    $getdeletes = mysqli_query($customercon,"SELECT * FROM archive_account WHERE username ='$username' AND oldpassword ='$oldpass'"); //check natin if meron nang katulad ng account
        if($getdeletes -> num_rows > 0){
            //if existing
         $functional = mysqli_fetch_object($getdeletes);
         $customer_deleted_id  = $functional -> accountdelete; //getnatin id lang

            
        }else{
            //pag hindi naman insert tayo 
            $inserttoaccount = mysqli_query($customercon, "INSERT INTO archive_account VALUES(null,'$username','$oldpass','$type')");
            //get natin para makuha ung id to insert sa cuystomer
          
            $getdeleteid = mysqli_query($customercon,"SELECT * FROM archive_account WHERE username = '$username' AND oldpassword ='$oldpass'");
            if($getdeleteid -> num_rows > 0){
                $fetchdelete = mysqli_fetch_object($getdeleteid);
                $customer_deleted_id = $fetchdelete -> accountdelete;
            $archive = mysqli_query($customercon,"INSERT INTO archive_customer VALUES(null,'$meternumber','$lastname','$firstname','$middlename','$barangay','$customer_deleted_id')");
                //after insertion fetch natin ung mga bills paid and unpaid tapos insert

                $getbills = mysqli_query($customercon,"SELECT * FROM bills WHERE customerid ='$person'");
                if($getbills -> num_rows > 0){
                    //loop natin hanngang maubos na laman nya
                    while($billdata = mysqli_fetch_object($getbills)){
                        
                    $bill = $billdata -> billno;
                    $customer_deleted_id ;
                    $period = $billdata -> period;
                    $amount = $billdata -> amount;
                    $consumption = $billdata -> consumption;
                    $deletor = $emp;
                    $status = $billdata -> remarks;
                    $dateofread = $billdata -> readingdate;

                            if($status == "YES"){
                                $finalstatus = "PAID";
                            }else{
                                $finalstatus = "UNPAID";
                            }
                    //INSERT NA 
                    $insertingbills = mysqli_query($customercon,"INSERT INTO archive_bills VALUES(null, '$bill','$customer_deleted_id','$period','$amount','$consumption','$deletor','$finalstatus','$dateofread')");
                    } // while block




                }

            } //inserting sa archive_customer
      //deletion here

     
     
        } // if - else block

 } //if bvlock

//delete section;




} //if may laman
else{

}

                 $deleteaccounts = mysqli_query($customercon,"DELETE FROM bills WHERE customerid ='$person'");
      $deleteaccountss = mysqli_query($customercon,"DELETE FROM customerinfo WHERE customerid ='$person'");
         $deleteaccount = mysqli_query($customercon,"DELETE FROM accounts WHERE accountid ='$accountid'");
            
            $_SESSION['delete'] = true;
                // header("Location:" . $_SERVER['PHP_SELF']);
                header("location:mainmember.php");
                exit;
?>
