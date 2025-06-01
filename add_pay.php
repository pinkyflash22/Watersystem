<?php 
session_start();
include('connection.php');
$add = new mysqli("localhost", "root","","customercard");

$ornum = $_POST['ornum'];
$id = $_POST['id']; //bill id
$amount = $_POST['amounts']; //ininput
$billnum = $_POST['billnum'];
$customerid = $_POST['customerid'];
echo $emp = $_POST['emp'];
$date = $_POST['date'];
$cons = $_POST['cons'];

$data = mysqli_query($customercon,"SELECT * FROM employeeaccount WHERE accountid ='$emp' ");
$fetch = mysqli_fetch_object($data);
$collectorid = $fetch -> emp_id;
$sub = $cons * 25;
$null = null;

$change = $amount - $sub;
$remarks = "YES";
$stmt = $add -> prepare("INSERT INTO collected VALUES (null,?,?,?,?,?,?)");
$stmt-> bind_param("isiiii",$ornum,$date,$change,$id,$collectorid,$customerid );

$stmt -> execute();

$update = mysqli_query($customercon,"UPDATE bills SET remarks ='YES' WHERE billno = '$billnum'");
header("location: addpayment2.php");

?>