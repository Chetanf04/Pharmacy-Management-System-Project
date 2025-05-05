<?php
session_start();
if (!isset($_SESSION['user_session'])) {
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Customer_add.css">
</head>
<body>
<nav class="head ">
        <a href="mainpage.php?invoice_number=<?php echo $_GET['invoice_number']; ?>" class="btn btn-light">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>
    <h2 class="text-white text-center flex-grow-1">MEDICINE PRODUCT</h2>
</nav>


<div class="container mt-4">

    <div class="top-bar">
        <button class="btn btn-success add-product-btn" id="openModal">
            <i class="fa fa-plus-circle"></i> ADD PRODUCT
        </button>

        <div class="search-group">
            <input type="text" class="form-control" id="name_med1" onkeyup="med_name1()" placeholder="Filter using ID" title="Type BarCode">
            <input type="text" class="form-control" id="med_quantity" onkeyup="quanti()" placeholder="Filter using Medicine Name" title="Type Medicine Name">
        </div>
    </div>


    <div class="table-responsive">
    <div id="totalMedicines" style="text-align:center; font-size:22px; margin-bottom:0">
    Total Medicines: <font color="green" style="font:bold 22px 'Aleo';">[0]</font>
</div>

    <!-- ✅ Table to Display Medicines -->
<table class="table table-bordered table-striped mt-3" id="medicineTable">
    <thead class="table-dark">
        <tr>
            <th>Medicine ID</th>
            <th>Medicine Name</th>
            <th>Category</th>
            <th>QTY Available</th>
            <th style="background: #c53f3f;">Expiry Date</th>
            <th>Actual Price</th>
            <th>Selling Price</th>
            <th>Profit</th>
            <th>Location</th>
            <th>Status</th>
            <th>Action</th> <!-- Action Column -->
        </tr>
    </thead>
    <tbody>
        <!-- Using AJAX Load THe Data-->
    </tbody>
</table>

</div>



</body>
</html>
<style>
.mt-3{
    margin-top: 0 !important;
}
.navbar{
  margin-bottom: 50px;
}
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .add-product-btn {
        width: 150px;
        padding: 5px 6px;
    }
    .search-group {
        display: flex;
        gap: 10px;
    }
    .search-group input {
        width: 300px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid white;
    }
    tbody {
        border: 1px solid white;
    }
    th, td {
        border: 1px solid white;
        padding: 8px;
        text-align: center;
    }

    /* **Table width flexible hoil** */
.table-responsive {
    overflow-x: auto;
    width: 100%;
    max-width: 100%;
}

/* **Action buttons row madhe fixed thevayche** */
.action-buttons {
    display: flex;
    gap: 5px; /* Space between buttons */
    right: 0;
    padding: 5px;
    z-index: 2;
}
.label{
    font-size: 11.844px;
    font-weight: bold;
    line-height: 14px;
    color: #ffffff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    white-space: nowrap;
    vertical-align: baseline;
    background-color: #999999;
    padding: 1px 4px 2px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
}
.label-success{
    background-color: #468847;
}
</style>
	<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box">
        <span class="close-btn" id="closeModal">&times;</span>
        <h2>ADD PRODUCT</h2>


  <!-- ✅ Product Add Form -->
<form id="addMedicineForm">
    <div class="row">
        <div class="column">
            <p><label for="medid">Medicine ID:</label><br>
            <input type="number" name="medid" id="medid" required></p>

            <p><label for="medname">Medicine Name:</label><br>
            <input type="text" name="medname" id="medname" required></p>

            <p><label for="cat">Category:</label><br>
            <input type="text" name="cat" id="cat" required></p>

            <p>
    <label for="qty">Quantity:</label>
    <input type="number" name="qty" id="qty" required style="margin-right: 10px;">
    </P>
    <p>
        <label for="sell_type">Sell Type:</label><br>
            <select name="sell_type" required>
                <option value="Capsule">Capsule</option>
                <option value="Syrup">Syrup</option>
                <option value="Bot">Bot</option>
                <option value="Tab">Tab</option>
                <option value="Sachet">Sachet</option>
                <option value="Unit">Unit</option>
                <option value="Tube">Tube</option>
            </select>
    </p>

        </div>

        <div class="column">
            <p><label for="actual_price">Actual Price:</label><br>
            <input type="number" name="actual_price" id="actual_price" required></p>

            <p><label for="selling_price">Selling Price:</label><br>
            <input type="number" name="selling_price" id="selling_price" required></p>

            <p><label for="profit_price">Profit:</label><br>
            <input type="text" name="profit_price" id="profit_price" readonly></p>

            <p><label for="loc">Location:</label><br>
            <input type="text" name="loc" id="loc" required></p><br>
        </div>
    </div>

    <center><input type="submit" value="Add Medicine" class="save-btn"></center>
</form>



</body>
<style>
.head { 
display: flex;
align-items: center;
justify-content: center; /* Center the heading */
background: #525050; /* Navbar background color */
padding: 10px 20px;
color: white;
font-weight: 300;
position: relative;
height: 80px; /* Set height for better alignment */
box-shadow: var(--box-shadow);
margin-bottom: 50px;
position: relative; /* Ensures correct positioning */
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
border-bottom-left-radius: 5px;
border-bottom-right-radius: 5px;
}

.head a {
position: absolute;
left: 20px; /* Moves the button to the left */
}

.head h2 {
font-size: 32px;
color: white;
margin: 0;
text-align: center;
}

.btn-secondary {
background-color: rgb(235, 242, 237);
color: #525050;
text-decoration: none;
padding: 5px 10px;
border-radius: 5px;
font-size: 16px;
cursor: pointer;
}

.top-bar {
display: flex;
justify-content: space-between;
align-items: center;
margin-bottom: 10px;
}
.add-product-btn {
width: 170px;
padding: 0px 6px;
}
.search-group {
display: flex;
gap: 10px;
}
.search-group input {
width: 300px;
}
table {
width: 100%;
border-collapse: collapse;
border: 1px solid white;
}
tbody {
border: 1px solid white;
}
th, td {
border: 1px solid white;
padding: 8px;
text-align: center;
}
.action-btn {
  width: 66px;
  margin: 4px;
  border: none;
  cursor: pointer;
  color: white;
  padding: 1px;
  border-radius: 5px;
  display: inline-block;
  text-decoration: none;
}
.edit-btn {
  background-color:rgb(28, 215, 34);
  color: white;
}
.del-btn {
  background-color:rgb(215, 38, 26);
  color: white;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

// 💰 Profit Auto Calculate (With ₹ Symbol & Negative Profit Handling)
$('#actual_price, #selling_price').on('input', function () {
    let actual = parseFloat($('#actual_price').val()) || 0;
    let selling = parseFloat($('#selling_price').val()) || 0;
    let profit = selling - actual;
    let profitPercent = actual > 0 ? ((profit / actual) * 100).toFixed(2) : 0;

    let profitText = profit >= 0 ? `₹${profit} (${profitPercent}%)` : `-₹${Math.abs(profit)} (${profitPercent}%)`;
    $('#profit_price').val(profitText);
});

// ✅ Form Submit Using AJAX
$('#addMedicineForm').on('submit', function (e) {
    e.preventDefault(); // ❌ No Page Refresh

    $.ajax({
        url: 'Add_medicine.php?invoice_number=<?php echo $_GET["invoice_number"]; ?>', // ✅ PHP Insert Script
        type: 'POST',
        data: $(this).serialize(), // 📤 Send Form Data
        success: function (response) {
            alert(response); // ✅ Success Message
            $('#addMedicineForm')[0].reset(); // 🧹 Clear Form
            loadMedicines(); // 🔄 Refresh Medicine Table
            $('#modalOverlay').hide(); // ❌ Close Modal
        },
        error: function (xhr, status, error) {
            alert('🚨 Error: ' + error); // ⚠️ Show Detailed Error
        }
    });
});

// 🟢 Function to Load Medicines (Fetch from DB)
function loadMedicines() {
    $.ajax({
        url: 'fetch_medicines.php?invoice_number=<?php echo $_GET["invoice_number"]; ?>', 
        type: 'GET',
        dataType: 'json', // 📥 Expect JSON data
        success: function (data) {
            // ✅ Update Table Rows
            $('#medicineTable tbody').html(data.tableRows);

            // ✅ Display Total Medicines
            $('#totalMedicines').html(`Total Medicines: <font color="green" style="font:bold 22px 'Aleo';">[${data.totalCount}]</font>`);
        },
        error: function () {
            alert('🚨 Failed to load medicines.');
        }
    });
}


// 🔄 Load Medicines on Page Load
loadMedicines();
});


    function med_name1() {
    var input = document.getElementById("name_med1").value.toUpperCase();
    var table = document.getElementById("customerTable");
    var tr = table.getElementsByTagName("tr");
    for (var i = 1; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName("td")[0];
        tr[i].style.display = td && td.innerHTML.toUpperCase().includes(input) ? "" : "none";
    }
}

function quanti() {
    var input = document.getElementById("med_quantity").value.toUpperCase();
    var table = document.getElementById("customerTable");
    var tr = table.getElementsByTagName("tr");
    for (var i = 1; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName("td")[1];
        tr[i].style.display = td && td.innerHTML.toUpperCase().includes(input) ? "" : "none";
    }
}

			 // Open Modal
       document.getElementById('openModal').addEventListener('click', function() {
            document.getElementById('modalOverlay').style.display = 'flex';
        });

        // Close Modal
        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('modalOverlay').style.display = 'none';
        });


        $(document).ready(function(){ 
            function calculateProfit() {
                var act_price = parseFloat($("#actual_price").val()) || 0;
                var sell_price = parseFloat($("#selling_price").val()) || 0;

                if (act_price > 0 && sell_price > 0 && sell_price >= act_price) { 
                    var pro_price = sell_price - act_price;
                    var percentage = Math.round((pro_price / act_price) * 100);
                    var output = pro_price.toFixed(2) + " (" + percentage + "%)";
                    $("#profit_price").val(output); // Profit Price input 
                } else {
                    $("#profit_price").val(""); // input is Wrong to no display.
                }
            }

            // Calculate the profite whenever inserting actual price and selling price.
            $("#actual_price, #selling_price").on('input', calculateProfit);
        });
    
    function med_name1() {
    var input = document.getElementById("name_med1").value.toUpperCase();
    var table = document.getElementById("medicineTable"); // ✅ Make sure the correct table ID is used
    if (!table) return; // 🚨 Prevent error if table is missing

    var tr = table.getElementsByTagName("tr");
    for (var i = 1; i < tr.length; i++) { // ✅ Start from 1 to avoid filtering header row
        var td = tr[i].getElementsByTagName("td")[0];
        tr[i].style.display = td && td.textContent.toUpperCase().includes(input) ? "" : "none";
    }
}

function quanti() {
    var input = document.getElementById("med_quantity").value.toUpperCase();
    var table = document.getElementById("medicineTable"); // ✅ Make sure the correct table ID is used
    if (!table) return;

    var tr = table.getElementsByTagName("tr");
    for (var i = 1; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName("td")[1];
        tr[i].style.display = td && td.textContent.toUpperCase().includes(input) ? "" : "none";
    }
}

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
