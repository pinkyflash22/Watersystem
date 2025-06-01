<?php 
session_start();
include('connection.php');
if(isset($_GET['meterid'])){
    $meterid = $_GET['meterid']; //transaction number
}



//get user info on other table
$que = mysqli_query($customercon,"SELECT * FROM paymentrecord WHERE transact ='$meterid'");
$data  = mysqli_fetch_object($que);
$idmeter = $data -> MeterNumber; //for info of name

$nameinfo = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE MeterNumber ='$idmeter'");
$col = mysqli_fetch_object($nameinfo);
$firstname = $col ->FirstName;
 $midname = $col ->MiddleName;
 $lastname = $col->LastName;
$barangay = $col->Barangay;

    $id = $_SESSION['id'];
    $user = mysqli_query($accountcon, "SELECT * FROM accounts WHERE id ='".$id."'");
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
 
    $meter = $idmeter; //customer id

    $fetch = mysqli_query($customercon, "SELECT * FROM paymentrecord WHERE transact ='".$meterid."'");
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

          $insertdata = mysqli_query($customercon, "INSERT INTO paymentrecord VALUES(null,'$idmeter ','$testyear','$period','$current',' $previousreading',' $consumption','$bill','$penalty','$totalamount','$date','$ornumber','$balances','$useracc','$remarks','$firstname','$midname','$lastname','$barangay','$nofbill')");      
    
    }

}




//     $totalamount = $bill + $penalty;

// echo $date;




}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form action="" method="post">



<table>

<!-- <?=$meterid?> -->
<tr>
    <td>
  
        <select name="monthcover" id="" >
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
            <input type="text" name="or" id="" placeholder = " O.R Number">
        </td>
    </tr>
    <tr>
        <td>
            <!-- <input type="number" name="cubic" id="" placeholder = " Cubic Meter Consumed "> -->
        </td>
    </tr>
    <tr>
        <td>
            <input type="date" name="date" id="" placeholder = "Penalty">

        </td>
    </tr>   

    <tr>
        <td>
            <input type="number" name="current" id="" placeholder = "Current Reading">
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
            <input type="submit" name="save" id="" value = "Add payment">
            <a href="dashboard.php">back</a>
        </td>
    </tr>

    
</table>

</form>


</body>
</html>