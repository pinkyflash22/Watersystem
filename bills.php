<?php 
session_start();
include('connection.php');

$months = $_GET['month'] ?? 'all';
$yearly = $_GET['year'] ?? 'all';
$payment = $_GET['payment'] ?? 'all';
$barangay = $_GET['barangayid'] ?? '0';

$remark = $payment;
if($yearly == "all"){
    $yearly = 0;
}
if($payment =="all"){

}

// if(isset($_GET['month'])){
//     $months = $_GET['month'];
// }

// if(isset($_GET['year'])){
//     $yearly = $_GET['year'];
// }

// $months = "DECEMBER";
// $yearly = 2025;

$j= 0;

 $monthconvert = array("JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", 
    "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER") ;                   //gawa tayo ng aarray for months
    for($i = 0; $i <12 ; $i++){
       if($monthconvert[$i] == $months){ 
        $j = $i + 1;
       }
    }
// $period;
// $totalconsumption = 0;
echo $thisyear = date("Y"); //get whole date today
echo $thisday = date("d");
echo $thismonth = date("m");
// $k = 0;
//  for($i = 0; $i <12 ; $i++){
//        if($monthconvert[$i] == $thismonth){ 
//         $k = $i+1;
//        }
//     }

    ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Report Table</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  @media print {
    @page {
      size: A4 portrait;
      margin: 1cm;
    }

    html, body {
      width: 210mm;
      height: 297mm;
      margin: 0;
      padding: 0;
      font-size: 12px;
    }

    body * {
      visibility: hidden;
    }

    #reportTable, #reportTable * {
      visibility: visible;
    }

    #reportTable {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
    }

    .no-print {
      display: none !important;
    }
  }
</style>

</head>
<body class="p-4">

  <div class="container">
   <div class="row text-center">
     <h3 class="mb-3">Monthly Billing Report </h3>
     <sub class="fs-3"><?=$months?><i class="fs-6"></i></sub>

    <!-- Print Button -->
    <div class="row">
        <div class="col">

        </div>
        <div class="col-sm-4 text-end">
            <button onclick="printReport()" class="btn btn-primary no-print mb-3">
      <i class="bi bi-printer"></i> Print Report 
    </button>
        </div>
    </div>
   </div>

<div class="row">
    
</div>
   
    <table class="table table-bordered table-striped" id="reportTable">
      <thead class="table-dark">
   
        <tr>
          <th>#</th>
          <th>Reading Date</th>
          <th>Due Date</th>
          <th>Meter Number</th>
          <th>Client</th>
          <th>Previous</th>
          <th>Current</th>
          <th>Consumption</th>
          <th>Penalty</th>
          <th>Sub total</th>
        <?php if($remark == "all"){?>
          <th>Status</th>
            <?php } ?>
          <th>Amount</th>


        </tr>
      </thead>
      <tbody>

      <?php 
    $overallamount = 0;
      

//     if($barangay>0){
// $sql = mysqli_query($customercon,"SELECT * FROM bills WHERE period='$months'AND remarks='$remark'");
// barangay to customer to bills
//     }

if($remark == "all"){

    if($months == "all"){
    $sql = mysqli_query($customercon,"SELECT * FROM bills");
    }else{
    $sql = mysqli_query($customercon,"SELECT * FROM bills WHERE period='$months'");
    }
}else{
     if($months == "all"){
$sql = mysqli_query($customercon,"SELECT * FROM bills WHERE remarks='$remark'");
    }else{
$sql = mysqli_query($customercon,"SELECT * FROM bills WHERE period='$months'AND remarks='$remark'");
    }
}

if($sql){

while($fetch = mysqli_fetch_object($sql)){
$year = $fetch -> duedate;
if($months == "DECEMBER"){ //filter for month only of decemvber
 $yearonly = substr($year, 0, 4);
 $due = substr($year, 5 , 2);
 $yearonly -= 1;

}else{ //all months here filters
 
 if(($fetch -> period) == "DECEMBER"){ //filter where all months is selected, targets december value
    $yearonly = substr($year, 0, 4);
 $due = substr($year, 5 , 2);
 $yearonly -= 1;
 }else{
    $yearonly = substr($year, 0, 4);
 $due = substr($year, 5 , 2);
 }
 
}
   $id = $fetch -> customerid ;
$status = $fetch -> remarks;
 $yearonly;
 $yearly;
 if($yearonly ==$yearly){
      
          if($barangay == 0){
             $getquery = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE customerid ='$id' ");
          }else{
             $getquery = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE customerid ='$id' AND Barangay ='$barangay' ");
          }
            //  $getquery = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE customerid ='$id' ");
         
          $get = mysqli_fetch_object($getquery);

          if($get){
          ?>

           <tr>


        <td style="font-weight: bold;"><?= $i++?></td>
          <td><?=$fetch -> readingdate?></td>
          <td><?= $year?></td>
          <!-- <td></td> -->
           <td><?=$get -> MeterNumber  ?></td>

          <td><?= $get -> LastName .", ".$get->FirstName." ".$get -> MiddleName?></td>
          <td class="text-end" ><?= $fetch -> previous  ?></td>
          <td class="text-end"><?= $fetch -> current ?></td>
          <td class="text-end"><?= $consump = $fetch -> consumption?></td>
          <!-- <td><?= htmlspecialchars($user['25']) ?></td> -->

          
        
<?php
if($j == 12){
    $due = 13;
}
    $fetch -> billid;

    if($consump < 10){
        $subamount = 250;
    }else{
        $subamount = $consump * 25;
    }



    if($due < $thismonth){
            $penalty = $subamount * 0.10;
    }else if($due == $thismonth){
        if($thisday > 16 ){
            $penalty = $subamount * 0.10;
        }else{
            $penalty = 0;
        }
    }else{
        $penalty = 0;
    }

    $totalamount = $subamount + $penalty;
    $overallamount += $totalamount;

?>

 <td class="text-end" ><?=$penalty?></td>
<td class="text-end" ><?= $subamount?></td>
                    <?php
                    if($remark == "all"){
                        if($status == "NO"){
                            $status = "UNPAID";
                        }else{
                            $status = "PAID";
                        }
                        ?>
                    <td class="text-end" ><?=$status?></td>

                    <?php
                    }
                    ?>
<td class="text-end" ><?= $totalamount?></td>



        </tr>

<?php

 }//get
    //dito dulo idugtong
 }//if end
 else{

          if($barangay == 0){
             $getquery = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE customerid ='$id' ");
          }else{
             $getquery = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE customerid ='$id' AND Barangay ='$barangay' ");
          }
            //  $getquery = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE customerid ='$id' ");
         
          $get = mysqli_fetch_object($getquery);

          if($get){
    ?>

           <tr>


        <td style="font-weight: bold;"><?= $i++?></td>
          <td><?=$fetch -> readingdate?></td>
          <td><?= $year?></td>
          <!-- <td></td> -->
           <td><?=$get -> MeterNumber  ?></td>

          <td><?= $get -> LastName .", ".$get->FirstName." ".$get -> MiddleName?></td>
          <td class="text-end" ><?= $fetch -> previous  ?></td>
          <td class="text-end"><?= $fetch -> current ?></td>
          <td class="text-end"><?= $consump = $fetch -> consumption?></td>
          <!-- <td><?= htmlspecialchars($user['25']) ?></td> -->

          
        
<?php
if($j == 12){
    $due = 13;
}
    $fetch -> billid;

    if($consump < 10){
        $subamount = 250;
    }else{
        $subamount = $consump * 25;
    }



    if($due < $thismonth){
            $penalty = $subamount * 0.10;
    }else if($due == $thismonth){
        if($thisday > 16 ){
            $penalty = $subamount * 0.10;
        }else{
            $penalty = 0;
        }
    }else{
        $penalty = 0;
    }

    $totalamount = $subamount + $penalty;
    $overallamount += $totalamount;

?>

 <td class="text-end" ><?=$penalty?></td>
<td class="text-end" ><?= $subamount?></td>
                    <?php
                    if($remark == "all"){
                        if($status == "NO"){
                            $status = "UNPAID";
                        }else{
                            $status = "PAID";
                        }
                        ?>
                    <td class="text-end" ><?=$status?></td>

                    <?php
                    }
                    ?>
<td class="text-end" ><?= $totalamount?></td>



        </tr>




<?php
          }//second get
 }//else
} //while loop ?>
<?php if($remark == "all"){
    ?>
  
      <tr><td colspan="5"></td><td colspan="6" class="text-end fs-4" style="font-weight: bold;">Total: </td ><td class="text-end fs-4" style="font-weight: bold;"><?=$overallamount?></td></tr>

    <?php 
}else{
?>
      <tr><td colspan="5"></td><td colspan="5" class="text-end fs-4" style="font-weight: bold;">Total: </td ><td class="text-end fs-4" style="font-weight: bold;"><?=$overallamount?></td></tr>

<?php
}
}else{
    ?>
      <tr>
        <td colspan="5"></td>
        <td>
            NO RESULT FOUND
        </td>
        <td colspan="5"></td>

    </tr>

    <?php
}

?>
  
</tbody>
</table>
       <script>
    function printReport() {
      window.print();
    }
  </script>

  <!-- Optional: Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
