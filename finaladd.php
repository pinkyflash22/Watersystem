<?php 
session_start();
include('connection.php');

if(isset($_GET['id'])){

    $id = $_GET['id'];
     $query = mysqli_query($customercon, "SELECT * FROM paymentrecord WHERE MeterNumber ='$id' ORDER BY transact DESC");
     $namequery = mysqli_query($customercon, "SELECT * FROM customerinfo WHERE MeterNumber = '$id'");
 }
 
$i = 0;
 while($var = mysqli_fetch_object($query)){

    if($id == $var -> MeterNumber){
        $i = 1;
    }
 }
echo $i;
 $names = mysqli_fetch_object($namequery);
     $firstname =   $names -> FirstName;
     $lastname =   $names -> LastName;
     $midname=    $names -> MiddleName;
     $barangay =    $names -> Barangay;
     $meterid =    $names -> MeterNumber;

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
<nav><ul class = "port">
    <li>
        HOME
    </li>
    <li>
        <a href="billing.php" style="text-decoration: none; color: white;">BILLING SECTION</a>

    </li>
    <li>
RECORDS
    </li>
    <li>
        SERVICES
    </li>
    
</ul>
<ul class ="port">
    <li>
        SETTINGS    
    </li>
</ul>

</nav>    
</header>
 <br>
 <br>
 <br>   

<?php 


 if($i == 0){

    if(isset($_POST['new'])){
        $current = $_POST['current'];
        $ornumber = $_POST['or'];
        $balances = 0;
        $previousreading = 0;
        $billingno = 1;
        $consumption = $current;
        if($consumption > 6){
            $bill = ($consumption * 25);
            
            }else if($consumption< 0){
            
            }else{
                    $bill = 250;
            
             }
             $penalty = 0;    
$date = $_POST['dates']; //date of payment
$remarks = $_POST['paid']; //status of paid or unpaid

$period = $_POST['period']; //month to pay
$totalamount = $bill + $penalty;
$nofbill = 1;
$testdate = substr($date, 8, 2);
$testmonth = substr($date, 5, 2);
$testyear = substr($date, 0,4);

//$previousyear = $testyear;
$previousmonth = $period;

$id = $_SESSION['id'];
$user = mysqli_query($accountcon, "SELECT * FROM accounts WHERE id ='".$id."'");
$row = mysqli_fetch_object($user);

$useracc = $row -> empfirst;           


echo $testyear; //year to compare to start another year a nd reset month to january
echo $testmonth; //month to compare
echo $testdate; //date to compare if abot duedate

$numbervalue = 0;
if($previousmonth == "JANUARY"){
    $numbervalue = 0;
}else if($previousmonth == "FEBRUARY"){
    $numbervalue = 1;
}else if($previousmonth == "MARCH"){
    $numbervalue = 2;
}else if($previousmonth == "APRIL"){
    $numbervalue = 3;
}else if($previousmonth == "MAY"){
    $numbervalue = 4;
}else if($previousmonth == "JUNE"){
    $numbervalue = 5;
}else if($previousmonth == "JULY"){
    $numbervalue = 6;
}else if($previousmonth == "AUGUST"){
    $numbervalue = 7;
}else if($previousmonth == "SEPTEMBER"){
    $numbervalue = 8;
}else if($previousmonth == "OCTOBER"){
    $numbervalue = 9;
}else if($previousmonth == "NOVEMBER"){
    $numbervalue = 10;
}else if($previousmonth == "DECEMBER"){
    $numbervalue = 11;
}else{
    $numbervalue = 0;
}

//for input month conversion
$testvalue = 0;
if($testmonth == "01"){
    $testvalue = 0;
}else if($testmonth == "02"){
    $testvalue = 1;
}else if($testmonth == "03"){
    $testvalue = 2;
}else if($testmonth == "04"){
    $testvalue = 3;
}else if($testmonth == "05"){
    $testvalue = 4;
}else if($testmonth == "06"){
    $testvalue = 5;
}else if($testmonth == "07"){
    $testvalue = 6;
}else if($testmonth == "08"){
    $testvalue = 7;
}else if($testmonth == "09"){
    $testvalue = 8;
}else if($testmonth == "10"){
    $testvalue = 9;
}else if($testmonth == "11"){
    $testvalue = 10;
}else if($testmonth == "12"){
    $testvalue = 11;
}else{

    $testvalue = 0;
}



// if($numbervalue == 11){
//     $previousyear = $previousyear +1;
// }

if($numbervalue ==11 && $testvalue ==0){

    $previousyear = $testyear - 1;
}else{

    $previousyear = $testyear;
}

//month to num value



     //previous - current, to be pay 
//     $penalty = 0; //16 month

if($period == 0){
    echo "inv:";
}else{

    if($testdate > 16 ){ //opara sa mga may 31 ung buwan
        $penalty = $bill * 0.10;
}else{
    $penalty = 0;
}


    $insertdata = mysqli_query($customercon, "INSERT INTO paymentrecord VALUES(null,'$meterid ','$previousyear','$period','$current',' $previousreading',' $consumption','$bill','$penalty','$totalamount','$date','$ornumber','$balances','$useracc','$remarks','$firstname','$midname','$lastname','$barangay','$nofbill')");
}






        }


?>
<form action="" method="post">
<table>
    <tr>
        <td>
            <input type="text" name="current" id="" placeholder = "Current Reading">
        </td>
    </tr>
    <tr>
        <td>
            <input type="text" name="or" id="" placeholder = " O.R Number">
        </td>
    </tr>
    <tr>
        <td>
        <input type="date" name="dates" id="">
        </td>
    </tr>
    <tr>
    <td>
  
        <select name="period" id="" >
            <option value="0" >SELECT MONTH</option>
<option value="JANUARY">JANUARY</option>
<option value="FEBRUARY">FEBRUARY</option>
<option value="MARCH">MARCH</option>
<option value="APRIL">APRIL</option>
<option value="MAY">MAY</option>
<option value="JUNE">JUNE</option>
<option value="JULY">JULY</option>
<option value="AUGUST">AUGUST</option>
<option value="SEPTEMBER">SEPTEMBER</option>
<option value="OCTOBER">OCTOBER</option>
<option value="NOVEMBER">NOVEMBER</option>
<option value="DECEMBER">DECEMBER</option>

        </select>
    </td>
</tr>
<tr>
    <td>
        <select name="paid" id="">
        <option value="UNPAID">UNPAID</option>
        <option value="PAID">PAID</option>
      
        </select>
    </td>
</tr>
    <tr>
        <td>
            <input type="submit" value="SAVE" name= "new">
        </td>
    </tr>
</table>

</form>

<?php 
}
else{
if(isset($_GET['id'])){
    $meterid = $_GET['id']; //customer
}



//get user info on other table
$que = mysqli_query($customercon,"SELECT * FROM paymentrecord WHERE MeterNumber ='$meterid' ORDER BY transact DESC");
$data  = mysqli_fetch_object($que);
 $transact = $data -> transact; //for info of name

$nameinfo = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE MeterNumber ='$meterid'");
$col = mysqli_fetch_object($nameinfo);
$firstname = $col ->FirstName;
 $midname = $col ->MiddleName;
 $lastname = $col->LastName;
$barangay = $col->Barangay;

    $ids = $_SESSION['id'];
    $user = mysqli_query($accountcon, "SELECT * FROM accounts WHERE id ='".$ids."'");
    $row = mysqli_fetch_object($user);
    
    $useracc = $row -> empfirst; //user account


if(isset($_POST['save'])){

    $ornumber = $_POST['or']; //or receipt number
  //  $cubic = $_POST['cubic']; //numbre of cubic meter
    $date = $_POST['date']; //date of payment

    $remarks = $_POST['paid']; //status of paid or unpaid

$period = $_POST['monthcover']; //month to pay


$testdate = substr($date, 8, 2);
$testmonth = substr($date, 5, 2);
$testyear = substr($date, 0,4);
echo $testyear; //year to compare to start another year a nd reset month to january
echo $testmonth; //month to compare
echo $testdate; //date to compare if abot duedate


//need to get previous dates
 
    $current = $_POST['current']; //current cubic meter
 
    $meter = $meterid; //customer id

    $fetch = mysqli_query($customercon, "SELECT * FROM paymentrecord WHERE transact ='".$transact."'");
    $previous = mysqli_fetch_object($fetch);
    $previousreading = $previous -> CurrentReading; //old current will be previous
    $previousmonth = $previous -> MonthCovered;
    $previousyear = $previous ->Year;
    $billingno = $previous ->billno;
    $nofbill = $billingno + 1;
//conversion of month to number value
$numbervalue = 0;
if($previousmonth == "JANUARY"){
    $numbervalue = 0;
}else if($previousmonth == "FEBRUARY"){
    $numbervalue = 1;
}else if($previousmonth == "MARCH"){
    $numbervalue = 2;
}else if($previousmonth == "APRIL"){
    $numbervalue = 3;
}else if($previousmonth == "MAY"){
    $numbervalue = 4;
}else if($previousmonth == "JUNE"){
    $numbervalue = 5;
}else if($previousmonth == "JULY"){
    $numbervalue = 6;
}else if($previousmonth == "AUGUST"){
    $numbervalue = 7;
}else if($previousmonth == "SEPTEMBER"){
    $numbervalue = 8;
}else if($previousmonth == "OCTOBER"){
    $numbervalue = 9;
}else if($previousmonth == "NOVEMBER"){
    $numbervalue = 10;
}else if($previousmonth == "DECEMBER"){
    $numbervalue = 11;
}else{
    $numbervalue = 0;
}

//for input month conversion
$testvalue = 0;
if($testmonth == "01"){
    $testvalue = 0;
}else if($testmonth == "02"){
    $testvalue = 1;
}else if($testmonth == "03"){
    $testvalue = 2;
}else if($testmonth == "04"){
    $testvalue = 3;
}else if($testmonth == "05"){
    $testvalue = 4;
}else if($testmonth == "06"){
    $testvalue = 5;
}else if($testmonth == "07"){
    $testvalue = 6;
}else if($testmonth == "08"){
    $testvalue = 7;
}else if($testmonth == "09"){
    $testvalue = 8;
}else if($testmonth == "10"){
    $testvalue = 9;
}else if($testmonth == "11"){
    $testvalue = 10;
}else if($testmonth == "12"){
    $testvalue = 11;
}else{

    $testvalue = 0;
}



if($numbervalue == 11){
    $previousyear = $previousyear +1;
}

//month to num value
   $consumption = 0; //previous - current, to be pay 
//     $penalty = 0; //16 month
if($period == 0){
    echo "inv:";
}else{ //month of period
    if($current < $previousreading){
        echo "invalid";
    }else{
        $consumption = $current -  $previousreading;
        if($consumption > 6){
            $bill = ($consumption * 25);
            }else if($consumption< 0){
                }else{
                    $bill = 250;
                }
                $penalty = 0;
                if($testyear == $previousyear){ //sample 2024 = 2024
                    if($testvalue > $numbervalue){  //1 > 0 true
                
                        if($testdate > 16 ){ //opara sa mga may 31 ung buwan
                                $penalty = $bill * 0.10;
                        }else{
                            $penalty = 0;
                        }
                    }else{

                    }
                
                }else if($testyear > $previousyear){ //2025 - 2024
                        if($testvalue < $numbervalue){ // january 2025- december 2024
                            if($testdate > 16 ){ //opara sa mga may 31 ung buwan
                                $penalty = $bill * 0.10;
                        }else{
                            $penalty = 0;
                        }
                        }
                }else{ 
                
                }

                $totalamount = $bill + $penalty;
                $balances = 0;

                $insertdata = mysqli_query($customercon, "INSERT INTO paymentrecord VALUES(null,'$meterid ','$testyear','$period','$current',' $previousreading',' $consumption','$bill','$penalty','$totalamount','$date','$ornumber','$balances','$useracc','$remarks','$firstname','$midname','$lastname','$barangay','$nofbill')");      
               

}

}
}
?>

<form action="" method="post">
<div class="box-wrap">
<h2>PAYMENT PROCESS</h2>
<div class= "box">

<div style="display: flex; padding: 10px; width: 700px;">
    <div class ="out">
        <!-- <label>Current Meter Reading</label> -->
        <p>Meter Reading</p>
        <input type="number" name="current" id="" placeholder = "Current Reading"  style ="width: 250px; height: 35px; padding: 10px; border-radius: 5px;">
    </div>
    <div class="out">
        <p>Month to Pay</p>
        <select name="monthcover" id="" style ="width: 250px; height: 35px; padding: 5px; border-radius: 5px;" >
            <option value="0" >SELECT MONTH</option>
            <option value="JANUARY">JANUARY</option>
            <option value="FEBRUARY">FEBRUARY</option>
            <option value="MARCH">MARCH</option>
            <option value="APRIL">APRIL</option>
            <option value="MAY">MAY</option>
            <option value="JUNE">JUNE</option>
            <option value="JULY">JULY</option>
            <option value="AUGUST">AUGUST</option>
            <option value="SEPTEMBER">SEPTEMBER</option>
            <option value="OCTOBER">OCTOBER</option>
            <option value="NOVEMBER">NOVEMBER</option>
            <option value="DECEMBER">DECEMBER</option>
            </select>
    </div>
 </div>
       

 <div style="display: flex; padding: 10px; width: 700px;">
    <div class="out">
    <p>Original receipt no.</p>
    <input type="text" name="or" id="" placeholder = " O.R Number" style ="width: 250px; height: 35px; padding: 10px; border-radius: 5px;">
    </div>
    <div class="out">
        <p>Payment Date</p>
    <input type="date" name="date" id="" placeholder = "Penalty" style ="width: 250px; height: 35px; padding: 10px; border-radius: 5px;" >
    </div>
 </div>

    <div style="display: flex; padding: 10px;">
        <div class="out" >
<p>Payment Status</p>
    
<select name="paid" id=""  style ="width: 250px; height: 35px; padding: 10px; border-radius: 5px;">
        <option value="UNPAID">UNPAID</option>
        <option value="PAID">PAID</option>
</select>
        </div>
    </div>
    

    
<div style="display: flex; padding: 10px; width:85%; justify-content: space-evenly; width: 620px;">
<div>
<input type="submit" name="cancel" id="" value = "Cancel" style = "background: red; border-radius: 10px; width: 300px; margin-right: 10px;height: 50px; font-size: 20px; font-weight: bold;">
</div>;
<div>
<input type="submit" name="save" id="" value = "Add payment" style = "background: lightgreen; border-radius: 10px; width: 300px; height: 50px; font-size: 20px; font-weight: bold;">
</div>

          
</div>
<a href="dashboard.php">back</a>


 
   
        
  
 
            </div>

</div>

</form>

<?php 

} 
?>
<center>PAYMENT RECORDS</center>

<form action="" method="post">


<table class = "content-table"> <!--table for info of customers -->
<tr class="tablehead">
<td>Transact No.
        </td>
        <td>
            Bill No.
        </td>
        <td>
            Month Covered
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
        <td>
            O.R No.
        </td>
        <td>
            Payment Date
        </td>
        <td>
            Balances
        </td>
        <td>
            Remarks
        </td>
        <td>
            Collector
        </td>
    </tr>

<?php 



   //$details = mysqli_fetch_object($member);
  $old = mysqli_query($customercon, "SELECT * FROM paymentrecord WHERE MeterNumber ='$id' ORDER BY transact DESC");
  echo $id;
   while($details = mysqli_fetch_object($old)){ //taga display ng mga record ng individual

   
?>
<tr>

<td>
<!-- <?= $details -> lastname ?>, <?= $details -> firstname ?>  <?= $details -> middlename ?>. -->
<?= $details ->transact ?>
   </td>
   <td>
   <?= $details -> billno ?>
   </td>
   <td>
   <?= $details -> MonthCovered ?>
   </td>
   <td>
   <?= $details -> CurrentReading ?>
   </td>
   <td>
   <?= $details -> PreviousReading ?>
   </td>
   <td>
   <?= $details -> Consumption ?>
   </td>
   <td>
   <?= $details -> AmountofBilling ?>
   </td>
   <td>
   <?= $details -> Penalty ?>
   </td>
   <td>
   <?= $details -> TotalAmount ?>
   </td>
   <td>
   <?= $details -> ORno ?>
   </td>
   <td>
   <?= $details -> DateofPayment ?>
   </td>
   <td>
   <?= $details -> Balances ?>
   </td>
   <td>
   <?= $details -> Remarks ?>
   </td>
   <td>
   <?= $details -> EmployeeCollector ?>
   </td>
</tr>  
<?php } ?>
        </table>
    </form>
</body>
</html>