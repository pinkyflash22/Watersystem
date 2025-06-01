<?php
session_start();
include('connection.php');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
// if(!isset($_SESSION['user'])){
//     header("location:interface.php");
// }

if(!isset($_SESSION['id'])){
    header("location:interface.php");
}

$meternum ="";
$lastname ="";
$firstname = "";
$middlename = "";
$barangay ="";
$type = "";

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
        // echo "<div class='container' id='click'> <h1>MERON NA</h1><button class='btn btn-primary' onclick=''>X</button></div>";

    }else{
        // echo "walang katulad";
        // query dito
        if($type == "INDIVIDUAL"){
            $statusid = 1;
        }else{
            $statusid= 3;
        }
        $insertquery = mysqli_query($customercon, "INSERT INTO customerinfo VALUES(null,'$meternum','$lastname','$firstname','$middlename','$house','$street','$barangay','$statusid','103')");
    
      echo "<script>alert('ADDED SUCCESSFULLY');</script>";
        header("location:mainmember.php");
            exit;
      }

}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        color: white;
        text-decoration: none;
        padding: .25rem;
       }
       a:hover{
        background-color: lightblue;
        /* border-radius: 1rem; */
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
    table .cc:hover{
        &>td{
            /* background-color: green; */
            transform: scale(1);
            transition: ease-in-out;
            
            border-radius: 0 1rem 1rem 0;
        }
    }
       
      .link{
        color: white;
        text-decoration: none;
        padding: .25rem;
        padding-left: 1rem;
       }
       .link:hover, .link.active{
        color:darkblue;
        background-color: rgb(225, 242, 246);
        width: 140%;
        border-left: 5px solid orange;
        transition: background-color 0.3s ease, color 0.3s ease;
        
      
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
     
    </style>  
</head>
<body >






<div class="container-fluid w-50" style="transform: translateY(25%);" >
    <form action="" method="post">
        <div class="card" >
            <div class="card-body">
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
            <div class="card-footer">
                <input type="submit" value="Save" name="submit" id="submit" class="form-control btn btn-primary">
            </div>
        </div>
    </form>
</div>



















     <script src = "bootstrap-5.3.3-dist/js/bootstrap.min.js"> </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
         <script>
    const links = document.querySelectorAll('.link');
    links.forEach(link => {
        link.addEventListener('click', function(){
            // e.preventDefault();
            links.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>


         <script src = "bootstrap-5.3.3-dist/js/bootstrap.min.js"> 

           function func(){
                var add = document.getElementById("add");
                var button = document.getElementById("s");

                add.style.display="inline";
                button.style.display="none";
                if(button.innertext === "Add New Member"){
                    button.innerText = "X";
                }else{
                    button.innerText = "Add New Member";

                }
           
            }

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


<!-- chart -->
 <script>
   <?php
                                    $data = mysqli_query($customercon, "SELECT * FROM bills WHERE remarks = 'NO'");
                                               $i = 0;
                                              while($value = mysqli_fetch_object($data)){
                                                  $i = $i+1;
                                              }
         
                                     $data = mysqli_query($customercon, "SELECT * FROM bills WHERE remarks = 'YES'");
                                      $j = 0;
                                     while($value = mysqli_fetch_object($data)){
                                         $j = $j+1;
                                     }

                                ?>

                                let paid = <?=$j?>;
                                let unpaid = <?=$i?>;

  const ctx = document.getElementById('paids').getContext('2d');
  const billingDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Paid Bills', 'Unpaid Bills'],
      datasets: [{
        data: [paid, unpaid],
        backgroundColor: ['#28a745', 'ORANGE'], // Green, Red
        borderColor: ['#fff', '#fff'],
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      cutout: '60%',
      plugins: {
        legend: {
          position: 'bottom',
        },
          title: {
                                                display: true,
                                                text: 'Bills Settled'
                                            },
        tooltip: {
          callbacks: {
            label: function(context) {
              const total = paid + unpaid;
              const value = context.raw;
              const percentage = ((value / total) * 100).toFixed(2);
              return `${context.label}: ${value} (${percentage}%)`;
            }
          }
        }
      }
    }
  });
</script>
<!-- <script>
  const sortSelect = document.getElementById('sortreport');
  const reportBtn = document.getElementById('generateReportBtn');

  sortSelect.addEventListener('change', () => {
    const selectedValue = sortSelect.value || 'all';
    reportBtn.href = `unpaid_report.php?area=${encodeURIComponent(selectedValue)}`;
  });
</script> -->

<script>
  const monthSort = document.getElementById('monthSort');
  const yearSort = document.getElementById('yearSort');
  const barangaySort = document.getElementById('barangaySort');

  const paymentSort = document.getElementById('paymentSort');
  const reportBtn = document.getElementById('generateReportBtn');

  function updateReportLink() {
    const month = monthSort.value || 'all';
    const year = yearSort.value || 'all';
    const payment = paymentSort.value || 'all';
    const barangay = barangaySort.value || 'all';
    reportBtn.href = `unpaid_report.php?month=${encodeURIComponent(month)}&year=${encodeURIComponent(year)}&payment=${encodeURIComponent(payment)}&barangayid=${encodeURIComponent(barangay)}`;
  }

  monthSort.addEventListener('change', updateReportLink);
  barangaySort.addEventListener('change', updateReportLink);
  yearSort.addEventListener('change', updateReportLink);
  paymentSort.addEventListener('change', updateReportLink);
</script>


<script>
  function openReportPopup() {
    window.open(
      'unpaid_bills.php',
      'UnpaidReport',
      'width=900,height=600,scrollbars=yes,resizable=yes'
    );
  }
</script>

<script>
  function openReportPopup2() {
    window.open(
      'paidbills.php',
      'UnpaidReport',
      'width=900,height=600,scrollbars=yes,resizable=yes'
    );
  }
</script>
<script>
    
</script>
</body>
</html>l