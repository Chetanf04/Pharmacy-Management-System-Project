<?php
session_start();
include "Config.php";

if (!isset($_SESSION['user_session'])) {  
    header("location:index.php");
    exit;
}

$admin_username = $_SESSION['user_session']; 


// ✅ Database Query (Use ID field properly)
$sql = "SELECT ID, A_USERNAME FROM admin WHERE ID = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Query Preparation Failed: " . $conn->error);
}

$stmt->bind_param("s", $admin_username);  // VARCHAR म्हणून 's' वापरा
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query Execution Failed: " . $conn->error);
}

if ($row = $result->fetch_assoc()) {
    $admin_id = $row['ID'];  
    $admin_name = $row['A_USERNAME'];  
} else {
    echo "<p style='color:red;'>❌ Admin not found in database!</p>";
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Pharmacy</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
    <script type="text/javascript">
       jQuery(document).ready(function($) {
    $("a[id*=popup]").facebox({
      loadingImage : 'src/img/loading.gif',
      closeImage   : 'src/img/closelabel.png'
    })
  })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!--Library-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
<!-- Add Bootstrap JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


    <!--Google Font-->
   
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body><header class="header">
    <a href="#" class="logo">
        <img src="Medicure_logo.png" alt="Medicure Logo">
        <span style="font-weight:500; font-size:20px">MEDICURE</span>
    </a>

    <div class="notification-container">
    <?php
include("Config2.php");

// कमी स्टॉक असलेली औषधे तपासा
$quantity = 10;
$select_sql1 = "SELECT * FROM meds WHERE MED_QTY <= '$quantity'";
$result1 = mysqli_query($con, $select_sql1);
$row2 = $result1->num_rows;

if ($row2 == 0) {
    $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

    echo '<a href="qty_alert.php?invoice_number=' . $invoice_number . '" class="notification label-inverse" id="popup">
            <i style="font-size:27px" class="fa-solid fa-circle-exclamation"></i>
            <span class="badge">' . $row2 . '</span>
          </a>';
} else {
    $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

    echo '<a href="qty_alert.php?invoice_number=' . $invoice_number . '" class="notification label-inverse" id="popup">
            <i style="font-size:27px" class="fa-solid fa-circle-exclamation"></i>
            <span class="badge">' . $row2 . '</span>
          </a>';
}

// 6 महिन्यात एक्सपायर होणारी औषधे तपासा
$date = date('Y-m-d');    
$inc_date = date("Y-m-d", strtotime("+6 months", strtotime($date)));

$select_sql = "SELECT COUNT(*) as exp_count 
               FROM meds 
               INNER JOIN purchase ON meds.MED_ID = purchase.MED_ID 
               WHERE purchase.EXP_DATE <= '$inc_date'";

$result = mysqli_query($con, $select_sql);
$row = mysqli_fetch_assoc($result);
$row1 = $row['exp_count'];

if ($row1 == 0) {
    $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

    echo '<a href="expiry_alert_2.php?invoice_number=' . $invoice_number . '" class="notification label-inverse" id="popup">
            <i style="font-size:27px" class="fa-regular fa-bell"></i>
            <span class="badge">' . $row1 . '</span>
          </a>';
} else {
    $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

    echo '<a href="expiry_alert_2.php?invoice_number=' . $invoice_number . '" class="notification label-inverse" id="popup">
            <i style="font-size:27px" class="fa-regular fa-bell"></i>
            <span class="badge">' . $row1 . '</span>
          </a>';
}
?>


        <a href="logout.php?invoice_number=<?php echo $_GET['invoice_number']; ?>" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>
</header>

  <div class="sidenav">
    <h2>main</h2>
    <a href="mainpage.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="House">
      <i class="fa-solid fa-house"></i>
      Dashboard
    </a>
    
    <a href="Customer_view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="House">
    <i class="fa-solid fa-user-plus"></i>
      Customers
    </a>

    <a href="Purchase_view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="House">
      <i class="fa-regular fa-star"></i>
      Purchase
    </a>

    <a href="Product_view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="House">
     <i class="fa-regular fa-file-lines"></i>
     Products
    </a>


    <a href="Supplier_view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="House">
    <i class="fa-solid fa-user"></i>
      Suppliers
    </a>

    <a href="Employee_view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="House">
    <i class="fa-solid fa-users"></i>
    Employee
    </a>

    <a href="Sales_Report.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="House">
      <i class="fa-sharp fa-solid fa-chart-simple"></i>
      Sales Reports
    </a>

    <a href="Transaction_Report.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="House">
    <i class="fa-regular fa-file"></i>
      Transactions Reports
    </a>


  </div>

  <div class="container" >
   <div class="Wel_Time" style="background-color:white;">

    <!-- Time and Date Display -->
    <div class="datetime" id="datetime" style="font-size: 19px;">
    <i class="fa-solid fa-calendar-days"></i>
       <i id="date" class="date"></i><br>
      <button class="time" id="time"></button>
    </div>
    <div class="wel_dash">
        <font>Today's Sales:</font>
                  <strong><?php
  
                    include("Config2.php");
  
                    $date = date("Y-m-d");
  
                    $select_sql = "SELECT sum(total_amount) from invoicesales where Date = '$date'";
  
                    $select_query = mysqli_query($con,$select_sql);
  
                    while($row = mysqli_fetch_array($select_query)){
  
                               echo '<i class="fa-solid fa-indian-rupee-sign"></i> '.$row['sum(total_amount)'];
  
  
                    }
  
  
  
                  ?></strong>  
        </div>
   </div>
    <!-- Summary Section -->
    <div class="container_sale">
     <div class="row">
      <div class="contentheader">
        <h2>Hello, <?php echo htmlspecialchars($admin_name); ?>..!</h2>
       </div> 
     <center>
     <div class="col-md-12" >
     <form class="form-container" method="POST" action="insert_invoice.php?invoice_number=<?php echo $_GET['invoice_number'] ?>">
        <input type="text" name="bar_code" id="bar_code" autocomplete="off" placeholder="Enter Barcode Number" style="width:275px; height: 38px;" required> 
        <!-- Display Medicine Name (Readonly) -->
        <input type="text" id="product_display" placeholder="Medicine" style="width:275px; height: 38px;" readonly>
        <!-- Hidden Input to Send Medicine Name via POST -->
        <input type="hidden" name="product" id="product">
        <!-- <input type="text" name="C_ID" id="C_ID" required autocomplete="off" placeholder="Customer ID" style="width:160px; height: 38px;"> -->
        <select id="C_ID" name="C_ID" style="width:160px; height: 38px;">
            <option value="0" selected="selected">Customer ID</option>			
            <?php	
        include("Config.php");
        // Query to fetch customer IDs in reverse order
        $qry1 = "SELECT C_ID FROM customer ORDER BY C_ID DESC"; 
        $result1 = $conn->query($qry1);

        echo mysqli_error($conn);

        if ($result1->num_rows > 0) {
            while ($row1 = $result1->fetch_assoc()) {
                echo "<option>".$row1["C_ID"]."</option>";
            }
        }
        ?>
        </select>
        &nbsp;&nbsp;
        <input type="number" name="qty" id="qty" placeholder="Qty" autocomplete="off" style="width: 100px; height: 38px;" required>
        <input type="date" name="date" value="<?php echo date("Y-m-d"); ?>" style="display: none;">
        <button type="submit" name="submit" value="submit" class="btn btn-success" id="btn_submit" style="width: 130px; height: 38px; padding: 2px">
    <i class="fa fa-plus-circle" aria-hidden="true"></i>Add To Cart
</button>

    </form>
</div>
     </center>

     <?php
$invoice_number = $_GET['invoice_number'];
include("Config2.php");
?>

<!-- Table structure visible initially -->
<table class="table table-bordered table-striped table-hover" id="resultTable" data-responsive="table" style="margin-left: 1.5%; width:98%">
    <thead>
        <tr style="background-color:#333333; color:#ffffff; height:38px">
            <th class="color">Customer ID</th>
            <th class="color">Medicine</th>
            <th class="color">Category</th>
            <th style="background: #c53f3f;">Expiry Date</th>
            <th class="color">Price</th>
            <th class="color">Qty</th>
            <th class="color">Amount</th>
            <th class="color">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th colspan="6"><font size="6"><strong>Total:</strong></font></th>
        </tr>
    </tbody>
</table>

<?php
$select_sql = "SELECT * FROM on_hold WHERE invoice_number = '$invoice_number'";
$select_query = mysqli_query($con, $select_sql);

if (mysqli_num_rows($select_query) > 0) {
    ?>
    <script>
        document.querySelector("#resultTable tbody").innerHTML = "";
    </script>
    <?php
    while ($row = mysqli_fetch_array($select_query)) {
        ?>
        <script>
            document.querySelector("#resultTable tbody").innerHTML += `
                <tr class="record">
                    <td><?php echo $row['C_ID']; ?></td>
                    <td><?php echo $row['medicine_name']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['EXP_DATE']; ?></td>
                    <td><?php echo $row['cost']; ?></td>
                    <td><?php echo $row['qty']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td>
                        <a href="delete_invoice.php?invoice_number=<?php echo $invoice_number; ?>&id=<?php echo $row['id']; ?>" class="btn btn-danger">Remove</a>
                    </td>
                </tr>`;
        </script>
        <?php
    }

    $total_sql = "SELECT SUM(amount) AS total_amount FROM on_hold WHERE invoice_number = '$invoice_number'";
    $total_query = mysqli_query($con, $total_sql);
    $total_row = mysqli_fetch_assoc($total_query);
    ?>
    <script>
        document.querySelector("#resultTable tbody").innerHTML += `
            <tr>
                <th colspan="6"><font size="6"><strong>Total:</strong></font></th>
                <td colspan="2"><strong><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo $total_row['total_amount']; ?></strong></td>
            </tr>
            <tr>
                <td colspan="8">
                      <div style="margin:10px 0 10px 0">
                        <a class="btn-info btn-large" onclick="openModal()">
                            Proceed <i class="fa-sharp fa-solid fa-share"></i>
                        </a>
                    </div>
                </td>
            </tr>`;
    </script>
    <?php
} else {
    ?>
    <div class="sales-alert">
        <h3><center>No Sales Available!!</center></h3>
    </div>
    <?php
}
?>

<!-- Modal Structure -->
<div class="modal-custom" id="customModal" style="display: none;">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <button class="close-btn" onclick="closeModal()">&times;</button><br>
                <h4>Check Out</h4>
            </div>
            <div class="modal-body">
            <form method="post" action="preview.php?invoice_number=<?php echo isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '' ?>">
                <input type="hidden" name="medicine_name" value="<?php echo isset($_GET['medicine_name']) ? $_GET['medicine_name'] : ''; ?>">
                <input type="hidden" name="category" value="<?php echo isset($_GET['category']) ? $_GET['category'] : ''; ?>">
                <input type="hidden" name="quantity" value="<?php echo isset($_GET['quantity']) ? $_GET['quantity'] : ''; ?>">
                <input type="hidden" name="grand_total" value="<?php echo isset($_GET['amount']) ? $_GET['amount'] : ''; ?>">
                <input type="hidden" name="grand_profit" value="<?php echo isset($_GET['profit']) ? $_GET['profit'] : ''; ?>">
                <input type="hidden" name="date" value="<?php echo date("Y/m/d"); ?>">
                <input type="hidden" name="Customer_ID" value="<?php echo isset($_GET['C_ID']) ? $_GET['C_ID'] : ''; ?>">
                <input type="number" class="form-control-custom" name="paid_amount" placeholder="Paid Amount" required>
                <button type="submit" class="btn-submit">Submit</button>
            </form>

            </div>
        </div>
    </div>


</body>
<style>
* {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  border: none;
  outline: none;
  text-decoration: none !important;
  text-transform: none;
  transition: all .2s linear;
}

html {
  font-size: 62.5%;
  overflow-x: hidden;
  scroll-padding-top: 7rem;
  scroll-behavior: smooth;
}

body {
  background: #fff;
}

header {
  height: 80px;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  border: 1px solid;
  padding: 1rem 3.5%;
  box-shadow: var(--box-shadow);
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #fff;
  z-index: 1000;
}

header .logo {
  display: flex;
  align-items: center;
  font-size: 1.7rem;
  color: #333;
  font-weight: 500;
}

.header .logo img {
  display: inline-block;
  width: 65px;
  margin-right: 10px;
}

.header a {
  color: black;
  font-size: 1.7rem;
}

/* Notification icons container */
.notification-container {
  display: flex;
  align-items: center;
  gap: 50px; /* Adds a 20px gap between icons and logout button */
}

/* Notification bell and exclamation icons */
.notification {
  position: relative;
  display: inline-block;
}

.notification .badge {
  position: absolute;
  top: -15px;
  right: -15px;
  padding: 8px 8px;
  border-radius: 50%;
  font-size: 10px;
  background-color: red;
  color: white;
}

/* Logout button */
.logout-btn {
  color: #ffffff;
  padding: 4px 15px;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: rgb(224, 58, 52);
  border: 1px solid rgb(213, 89, 89);
  border-radius: 5px;
  text-decoration: none;
}

.col-md-12 {
width: 100%;
}
form {
padding: 0 0 20px;
}
.contentheader {
width: 100%;
height: 60px;
font-size: 15px;
text-decoration-line: none;
font-weight: bold;
display: flex;
align-items: center;
padding: 10px;
background-color:whitesmoke;
color: #333333;
margin: 10px;
}
.contentheader h2 {
font-size: 25px;
font-weight: bold;
}
.date {
font-family:'Times New Roman', Times, serif;
font-style: normal;
}
.datetime {
color:#333333;
}
.color{
background-color:#333333;
}


input[type="text"],
input[type="number"],
select,
button {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px 10px;
    font-size: 14px;
    box-sizing: border-box;
    height: 40px;
}
select{
    color: rgb(117, 113, 113);
    margin-right: 12px;
}


input[type="text"]::placeholder,
input[type="number"]::placeholder {
    color:rgb(117, 113, 113);
}

input[readonly] {
    background-color: #f9f9f9;
    color: #555;
}

.btn-success {
    background-color: #28a745;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    height: 40px; /* Match height with other inputs */
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-success:hover {
    background-color: #218838;
}

.btn-success i {
    margin-right: 5px;
}

.form-container {
    width: 92.5%;
    display: flex;
    gap: 0px; /* Set column gap to 2px */
    align-items: center;
    margin-bottom: 5px;
}
button {
    margin: 0; /* Remove any default margin */
}
.sales-alert {
color:rgb(242, 69, 66);
font-size: 22px;
height: 80px;

background-color:rgb(239, 208, 200);
border: 1px solidrgb(245, 195, 183);
border-radius: 4px;
display: flex;
align-items: center;
justify-content: center;
}
.sales-alert h3{
font-weight: bold;
}

.btn{
display: inline-block;
padding: 4px 14px;
margin-bottom: 0;
font-size: 14px;
line-height: 20px;
text-align: center;
}
.btn-danger{
color: #ffffff;
text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
background-color:rgb(224, 58, 52);
border: 1px solidrgb(213, 89, 89);
border-radius: 5px;
}

.btn-info{ 
color: #ffffff;
text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
background-color: #49afcd;
cursor: pointer;
} 
.btn-large{
padding: 7px 40px;
width: 260px;
font-size: 16px;
font-weight: 500;
height: 25px;
text-align: center;
text-decoration: none;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
margin-top: 10px;
margin-bottom: 30px;
}
/* Modal Overlay */
.modal-custom {
background-color: rgba(0, 0, 0, 0.7); /* Dark overlay */
display: flex;
justify-content: center;
align-items: flex-start; /* Align to top */
height: 100vh;
width: 100%;
position: fixed;
top: 0;
left: 0;
z-index: 1050;
padding-top: 80px; /* Space from top */
}

.wel_dash {
padding-top: 10px;
height: 50px;
width: 74%;
text-align: right;
font-size: 17px;
font-weight: 500;
margin-bottom: 15px;
margin-left: 5px;
}
.wel_dash h4 {
color: #4a4848;
}


/* Modal Content */
.modal-content-custom {
    background: #fff; /* White background */
    width: 400px; /* Fixed width */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2); /* Soft shadow */
    padding: 20px;
    padding-top: 0;
    text-align: center;
}
.modal-content-custom:hover{
    border-color:rgb(19, 19, 19);
}

/* Modal Header */
.modal-header-custom h4 {
    font-family: 'Times New Roman', Times, serif;
    font-size: 24px;
    margin-bottom: 10px;
    font-weight: bold;
}

/* Close Button */
.close-btn {
    background: transparent;
    border: none;
    font-size: 25px;
    font-weight: bold;
    color: #ff5c5c; /* Red color for close */
    float:right;
    margin-bottom: 10px;
    cursor: pointer;
}

/* Form Input */
.form-control-custom {
    width: 100%;
    padding: 10px;
    /* border: 1px solid #ddd; */
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 16px;
    border: 2px solid transparent; /* Default border */
}
.form-control-custom:hover{
    border-color: #c53f3f;
}

/* Submit Button */
.btn-submit {
    background: #28a745; /* Green background */
    color: #fff;
    border: none;
    padding: 10px 15px;
    font-size: 18px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}

.btn-submit:hover {
    background: #218838;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    // // sidenav dropdown-btn
    // const dropdowns = document.querySelectorAll('.dropdown-btn');
    // dropdowns.forEach(dropdown => {
    //   dropdown.addEventListener('click', function () {
    //     this.classList.toggle('active');
    //     const dropdownContent = this.nextElementSibling;
    //     dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
    //   });
    // });
          // Dynamic Time and Date Display
          function updateDateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateString = now.toLocaleDateString('en-US', options);
            document.getElementById('date').textContent = `${dateString}`;
            document.getElementById('time').textContent = `${timeString}`;
          }setInterval(updateDateTime, 1000);
    //       document.getElementById('date').innerText = dateString;
    //     document.getElementById('time').innerText = timeString;

    // setInterval(updateDateTime, 1000); // Update every second
    // updateDateTime(); // Initial call

 // Function to validate the form before submission
document.getElementById('btn_submit').addEventListener('click', function(event) {
    const barCode = document.getElementById('bar_code').value.trim();
    const product = document.getElementById('product').value.trim();
    const avaiQty = parseInt(document.getElementById('avai_qty').value, 10);
    const qty = parseInt(document.getElementById('qty').value, 10);

    if (!barCode) {
        alert('Please enter the barcode.');
        event.preventDefault();
        return;
    }

    if (!product) {
        alert('Please enter the product name.');
        event.preventDefault();
        return;
    }

    if (isNaN(qty) || qty <= 0) {
        alert('Please enter a valid quantity.');
        event.preventDefault();
        return;
    }

    if (!isNaN(avaiQty) && qty > avaiQty) {
        alert('Requested quantity exceeds available stock.');
        event.preventDefault();
        return;
    }
});
document.getElementById('bar_code').addEventListener('input', function() {
    const barCode = this.value.trim();
    if (barCode) {
        fetch(`fetch_product.php?bar_code=${barCode}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('product').value = data.product_name;
                    document.getElementById('avai_qty').value = data.available_quantity;
                } else {
                    alert(data.message);
                    document.getElementById('product').value = '';
                    document.getElementById('avai_qty').value = '';
                }
            })
            .catch(error => {
                console.error('Error fetching product details:', error);
            });
    } else {
        document.getElementById('product').value = '';
        document.getElementById('avai_qty').value = '';
    }
});
// medicine name automatic display
$(document).ready(function() {
    $('#bar_code').on('input', function() {
        var barcode = $(this).val();

        if (barcode != '') {
            $.ajax({
                url: 'fetch_medicine.php', // Backend PHP file
                type: 'POST',
                data: { bar_code: barcode },
                success: function(data) {
                    // Display for user
                    $('#product_display').val(data);
                    // Hidden input for POST
                    $('#product').val(data);
                },
                error: function() {
                    alert("Error fetching data.");
                }
            });
        } else {
            $('#product_display').val('');
            $('#product').val('');
        }
    });
});

function openModal() {
            document.getElementById('customModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('customModal').style.display = 'none';
        }

        
  </script>
</html>