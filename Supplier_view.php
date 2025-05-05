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
    <title>Supplier</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Customer_add.css">
</head>
<body>
<nav class="head">
    <a href="mainpage.php?invoice_number=<?php echo $_GET['invoice_number']; ?>" class="btn btn-light">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>
    <h2 class="text-white text-center flex-grow-1">SUPPLIERS LIST</h2>
</nav>


<div class="container mt-4">

    <div class="top-bar">
        <button class="btn btn-success add-product-btn" id="openModal">
            <i class="fa fa-plus-circle"></i> ADD SUPPLIERS
        </button>

        <input type="text" id="searchInput" class="form-control w-25" placeholder="Search Suppliers">
    </div>

<!-- Supplier Table -->
<table class="table table-bordered table-striped mt-3" id="SupplierTable"> 
    <thead class="table-dark">
        <tr>
            <th>Supplier ID</th>
            <th>Company Name</th>
            <th>Address</th>
            <th>Phone Number</th>
            <th>Email Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="supplierTableBody">
        <!-- AJAX will load data here -->
    </tbody>
</table>
</div>
<!-- Supplier Add Form -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box">
        <span class="close-btn" id="closeModal">&times;</span>
        <h2>ADD SUPPLIER</h2>
        <form id="addSupplierForm">
            <div class="row">
                <div class="column">
                    <p>
                        <label for="sid">Supplier ID:</label><br>
                        <input type="number" name="sid" required>
                    </p>
                    <p>
                        <label for="sname">Supplier Company Name:</label><br>
                        <input type="text" name="sname" required>
                    </p>
                    <p>
                        <label for="sadd">Address:</label><br>
                        <input type="text" name="sadd">
                    </p>
                </div>
                <div class="column">
                    <p>
                        <label for="sphno">Phone Number:</label><br>
                        <input type="number" name="sphno" required>
                    </p>
                    <p>
                        <label for="smail">Email Address:</label><br>
                        <input type="email" name="smail">
                    </p>
                </div>
            </div>
            <br>
            <button type="submit" class="save-btn">Add Supplier</button>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function(){

    // Load Supplier Data
    function loadSupplierData() {
        $.ajax({
            url: 'fetch_Supplier.php?invoice_number=<?php echo $_GET['invoice_number']; ?>', // Script to fetch data
            type: 'GET',
            success: function(data) {
                $('#supplierTableBody').html(data); // Load into table
            }
        });
    }

    loadSupplierData(); // Initial load

    // Add Supplier Using AJAX
    $('#addSupplierForm').on('submit', function(e){
        e.preventDefault(); // Prevent page reload
        $.ajax({
            url: 'Supplier_add.php?invoice_number=<?php echo $_GET['invoice_number']; ?>', // Script to add data
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response);// Success or Error message
                loadSupplierData(); // Reload table data
                $('#addSupplierForm')[0].reset(); // Clear form
                $('#modalOverlay').hide(); // Close modal
            }
        });
    });

});

    $(document).ready(function () {
            $("#searchInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#SupplierTable tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
// Open Modal
document.getElementById('openModal').addEventListener('click', function() {
            document.getElementById('modalOverlay').style.display = 'flex';
        });

        // Close Modal
        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('modalOverlay').style.display = 'none';
        });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<style>
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .add-product-btn {
        width: 180px;
        padding: 0px 0px;
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
    .btn-edit {
    background-color: green !important;
    border-color: green !important;
    color: white !important;
}

.btn-delete {
    background-color: red !important;
    border-color: red !important;
    color: white !important;
}
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
margin-bottom: 20px;
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
</style>