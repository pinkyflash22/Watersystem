
<?php
session_start();
include("connection.php");

$month = $_GET['month'] ?? 'all';
$year = $_GET['year'] ?? 'all';
$payment = $_GET['payment'] ?? 'all';
$barangay = $_GET['barangayid'] ?? '0';
// BARANGAY muna papuntang tao
$tagabilang = 0;


if($payment == "all"){
$remarks = "NO";
$statuse = 'all';

}else{
$remarks = "YES";


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>UWS-Generate Report</title>
    <link rel="icon" type="image/png" href="icons/urbiztondo-seal-1040x1040.png">

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
   <div class="container-fluid" id="reportTable">
    <div class="row text-center">
    <h3 class="mb-3">GENERAL BILLING REPORT  </h3>
    </div>
    <div class="row text-center">
    <div class="col-sm-12  d-flex">
      <?php 
        if($month == "all"){
          $monthe = "ALL";
        }else{
          $monthe = $month;
        }
        if($payment == "NO"){
          $statuse = "UNPAID";
        }elseif($payment == 'YES'){
          $statuse = "PAID";

        }else{
          $statuse ="UNPAID & PAID";
        }
        if($barangay == "0"){
          $barangays = "WHOLE MUNICIPALITY";
        }else{
          $querop = mysqli_query($customercon,"SELECT * FROM coveredareas WHERE barangayid = '$barangay'");
          $fetchbar = mysqli_fetch_object($querop);
          $barangays = $fetchbar -> area;
        }
      ?>
      <h6 class="me-4 ">YEAR: <?=$year?></h6>
      <h6 class="me-4">MONTH: <?=$monthe?></h6>
      <h6 class="me-4">STATUS: <?=$statuse?></h6>
      <h6 class="me-4">AREA: <?=$barangays?></h6>


    </div>
  </div>
   

   
    <table class="table table-bordered table-striped" >
      <thead class="table-dark">
   
        <tr>

         <th>Customer ID</th>
         <th>Client</th>
         <th>Area</th>


            <th>Paid Bills</th>
            <th>Unpaid Bills</th>
            <th>Paid Amount</th>
            <th>Unpaid Amount</th>
            <th>Overall Amount</th>
            <th class="no-print">Action</th>



        </tr>
      </thead>
      <tbody>
        <?php
// $year = 2024;
// mysqli_query($customercon,
// $sql ="SELECT customerid, COUNT(CASE WHEN remarks = 'NO' THEN 1 END) AS unpaid_count,COUNT(CASE WHEN remarks = 'YES' THEN 1 END) AS paid_count,
//  SUM(CASE WHEN remarks = 'NO' THEN amount ELSE 0 END) AS unpaid_amount, SUM(CASE WHEN remarks = 'YES' THEN amount ELSE 0 END) AS paid_amount,
//   SUM(amount) AS overall_amount FROM bills JOIN coveredareas ON bills.Barangay = coveredareas.barangayid
// WHERE 1=1";

$sql ="SELECT bills.customerid,coveredareas.area AS barangay_name,GROUP_CONCAT(DISTINCT bills.period ORDER BY YEAR(bills.readingdate)) AS months, COUNT(CASE WHEN remarks = 'NO' THEN 1 END) AS unpaid_count,COUNT(CASE WHEN remarks = 'YES' THEN 1 END) AS paid_count,
 SUM(CASE WHEN remarks = 'NO' THEN amount ELSE 0 END) AS unpaid_amount, SUM(CASE WHEN remarks = 'YES' THEN amount ELSE 0 END) AS paid_amount,
  SUM(amount) AS overall_amount FROM bills JOIN customerinfo ON bills.customerid = customerinfo.customerid
JOIN coveredareas ON customerinfo.Barangay = coveredareas.barangayid
WHERE 1=1";

  // GROUP BY customerid");

if ($year !== 'all') {
    $sql .= " AND YEAR(readingdate) = '$year'";
}
if ($month !== 'all') {
    // Assuming you have a column like 'month_name' storing the word of the month
    $sql .= " AND period = '$month'";
}
if ($payment !== 'all') {
    // Assuming you have a column like 'month_name' storing the word of the month
    $sql .= " AND remarks = '$payment'";
}
if ($barangay !== '0') {
//  $sql .= " AND coveredareas.barangayid = '$barangay'";
$sql .= " AND customerinfo.Barangay = '$barangay'";
  // $selectbarangay = mysqli_query($customercon,"SELECT * FROM coveredareas WHERE barangayid = '$barangay'");
    // Assuming you have a column like 'month_name' storing the word of the month
    // $sql .= " AND Barangay = '$barangay'";
}


$sql .= " GROUP BY customerid";


$try = mysqli_query($customercon, $sql);
        if($try -> num_rows > 0){
           "oklay";
        }else{
           "notokay";
        }
$total_overall = 0;
while ($row = mysqli_fetch_assoc($try)) {
    

?>
<tr>
 
            <td><?php 
            $set = $row['customerid'];
            $setter = mysqli_query($customercon,"SELECT * FROM customerinfo WHERE customerid = '$set'");
            $getsetter = mysqli_fetch_object($setter);
            echo $getsetter -> MeterNumber;
         
            ?></td>
            <td>
            <a href="viewbills.php?customerid=<?=$set?>"><?=$getsetter -> LastName .", ". $getsetter -> FirstName ." ". $getsetter -> MiddleName ?></a>  
            </td>
            <td><?=$row['barangay_name']?></td>

            <td class="text-end"><?=$row['paid_count']?></td>

            
            <td class="text-end"><?=$row['unpaid_count']?></td>
            <td class="text-end">₱ <?=number_format($row['paid_amount'], 2)?></td>
            <td class="text-end">₱ <?=number_format($row['unpaid_amount'], 2)?></td>
            <td class="text-end">₱ <?=number_format($row['overall_amount'], 2)?></td>
        <td class="no-print"><a href="viewreport.php?customerid=<?=$set?>">view Details</a></td>


</tr>
<?php
 $total_overall += $row['overall_amount'];
            }?>

<?php 
if($try -> num_rows>0){
?>

      <tr><td colspan="4"></td><td colspan="3" class="text-end fs-4" style="font-weight: bold;">Total: </td ><td class="text-end fs-4" style="font-weight: bold;">₱ <?=number_format($total_overall, 2) ?></td><td></td></tr>

<?php
}else{
  ?>
<tr>
  <td colspan ="12" class ="text-center">No Record Found</td>
</tr>
  <?php
}
?>


      </tbody>
    </table>
    </div>

  </div>

  <!-- JavaScript Print Function -->
  <script>
    function printReport() {
      window.print();
    }
  </script>

  <!-- Optional: Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
