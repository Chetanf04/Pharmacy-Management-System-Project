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
    <title>Customer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Customer_add.css">
    <style>
        body {
            height: 100vh;
            overflow-y: auto;
        }
        .modal-box {
            background: #ccc;
            width: 600px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            position: relative;
            margin-top: 85px;
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .head {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #525050;
            padding: 10px 20px;
            color: white;
            height: 80px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .head a {
            position: absolute;
            left: 20px;
        }
        .head h2 {
            font-size: 32px;
            margin: 0;
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
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }
        input[type="text"],
input[type="number"],
input[type="email"],
select {
  width: 100%;
  padding: 8px;
  margin-top: 3px;
  margin-bottom: 3px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 15px;
  border-color: #333;
}
    </style>
</head>
<body>
<nav class="head">
    <a href="mainpage.php?invoice_number=<?php echo $_GET['invoice_number']; ?>" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>
    <h2>CUSTOMER LIST</h2>
</nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between mt-3">
        <button class="btn btn-success" id="openModal">
            <i class="fa fa-plus-circle"></i> ADD CUSTOMER
        </button>
        <input type="text" id="searchInput" class="form-control w-25" placeholder="Search Customer...">
    </div>

    <table class="table table-bordered table-striped mt-3" id="customerTable">

        <thead class="table-dark">
            <tr>
                <th>Customer ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Phone Number</th>
                <th>Email Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="customerTableBody">
            <!-- Data will be loaded here via AJAX -->
        </tbody>
    </table>
</div>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box">
        <span class="close-btn" id="closeModal">&times;</span>
        <h2>ADD CUSTOMER</h2>
        <form id="addCustomerForm">
            <div class="row">
                <div class="col">
                    <p><label for="cid">Customer ID:</label>
                    <input type="number" name="cid" id="cid" placeholder="Enter ID" required></p>
                    <p><label for="cfname">First Name:</label>
                    <input type="text" name="cfname" id="cfname" placeholder="Enter First Name"></p>
                    <p><label for="clname">Last Name:</label>
                    <input type="text" name="clname" id="clname" placeholder="Enter Last Name"></p>
                    <p><label for="age">Age:</label>
                    <input type="number" name="age" id="age" placeholder="Enter Age"></p>
                </div>
                <div class="col">
                    <p><label for="sex">Gender:</label>
                    <select id="sex" name="sex">
                        <option value="">Select</option>
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                        <option value="Others">Others</option>
                    </select></p>
                    <p><label for="phno">Phone Number:</label>
                    <input type="number" name="phno" id="phno" placeholder="Enter Phone Number"></p>
                    <p><label for="emid">Email ID:</label>
                    <input type="email" name="emid" id="emid" placeholder="Enter Email"></p>
                </div>
            </div>
            <button type="submit" class="btn" style="background-color:#28a745; color: white;">
    Add Customer
</button>

        </form>
    </div>
</div>

<script>$(document).ready(function () {

// ✅ Load Customer Data
function loadCustomerData() {
    $.ajax({
        url: 'fetch_Customer.php?invoice_number=<?php echo $_GET['invoice_number']; ?>',
        type: 'GET',
        success: function (data) {
            $('#customerTableBody').html(data);
        },
        error: function () {
            alert('Failed to load customer data. Try again!');
        }
    });
}

loadCustomerData();

// ✅ Search Customer (Real-Time)
$('#searchInput').on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#customerTable tbody tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});

// ✅ Add Customer
$('#addCustomerForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: 'Customer_add.php?invoice_number=<?php echo $_GET['invoice_number']; ?>',
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            if (response.includes("successfully")) {
                // ✅ Success Alert
                alert(response);
                loadCustomerData(); // Refresh Table
                $('#addCustomerForm')[0].reset(); // Reset Form
                $('#modalOverlay').hide(); // Close Modal
            } else {
                // ⚠️ Error Alert
                alert(response);
            }
        },
        error: function () {
            alert("❌ Error! Unable to add customer.");
        }
    });
});
});

    // Open Modal
    $('#openModal').on('click', function() {
        $('#modalOverlay').css('display', 'flex');
    });

    // Close Modal
    $('#closeModal').on('click', function() {
        $('#modalOverlay').hide();
    });
</script>
</body>
</html>
