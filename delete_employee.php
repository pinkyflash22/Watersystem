<?php
session_start();
if(!isset($_SESSION['id'])){
    header("location:interface.php");
}
include("connection.php");
$emp =  $_SESSION['id'];
$person = $_GET['account'];

$selectquery = mysqli_query($customercon,"SELECT * FROM employeeaccount WHERE accountid ='$emp'");

if($selectquery -> num_rows > 0){
$getemp = mysqli_fetch_object($selectquery);
$deletor = $getemp -> emp_id;

    $selectemployee = mysqli_query($customercon,"SELECT * FROM accounts WHERE accountid='$person'");
    if($selectemployee -> num_rows>0){

        $employeetodelete = mysqli_fetch_object($selectemployee);
        $username = $employeetodelete -> username;
        $password = $employeetodelete -> password;
        $usertype = $employeetodelete -> type;


        $insertoarchiveaccount = mysqli_query($customercon,"INSERT INTO archive_account VALUES(null,'$username', '$password', '$usertype')");
        //napasok na., kunin natin ngayon ung id nya

        $getarchiveaccountid = mysqli_query($customercon,"SELECT * FROM archive_account ORDER BY accountdelete DESC");
        if($getarchiveaccountid -> num_rows>0){
            $data = mysqli_fetch_object($getarchiveaccountid);
            $archive_account_id = $data -> accountdelete;


            $getdataofemployee = mysqli_query($customercon,"SELECT * FROM employeeaccount WHERE accountid ='$person'");
            if($getdataofemployee -> num_rows>0){
             
                $gather = mysqli_fetch_object($getdataofemployee);
                $name = $gather -> emp_firstname;
                $lastname = $gather -> emp_lastname;
                $middlename = $gather -> emp_middlename;
                $bday = $gather -> emp_birth;
                $datestart = $gather -> dateofcreation;



            $inserintoinfo = mysqli_query($customercon,"INSERT INTO archive_employee VALUES(null, '$name', '$lastname', '$middlename', '$bday', '$datestart','$archive_account_id')");

            //delte na natin
            $deleteaccount = mysqli_query($customercon,"DELETE FROM accounts WHERE accountid = '$person'");
            $todelete = mysqli_query($customercon,"DELETE FROM employeeaccount WHERE accountid = '$person'");
                
            $_SESSION['delete'] = true;
                // // header("Location:" . $_SERVER['PHP_SELF']);
                header("location:mainmember.php");
                exit;
            }   

            // naget na ung kakapasok lang na dinelete; 
        }


    }






}




?>
