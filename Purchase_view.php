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
    <title>Purchases</title>

    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <!--Library-->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link rel="stylesheet" type="text/css" href="Customer_add.css">
 <style>
            /* Align buttons and search in one row */
.top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
 }
        
#searchInput {
            width: 300px;
            text-align: center;
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
font-size: 28px;
color: white;
margin: 0;
text-align: center;
font-weight: bold;
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
</head>
<body>

    <!-- Navbar -->
    <nav class="head" style="height: 80px;">
    <a href="mainpage.php?invoice_number=<?php echo $_GET['invoice_number']; ?>" class="btn btn-light">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>

    <h2 style="color: white;">STOCK PURCHASE LIST</h2>
    </nav>

    <div class="container mt-4">
        <!-- Add Medicine & Search Bar in one line -->
        <div class="top-bar mb-3">
            <button class="btn btn-success" id="openModal">
                <i class="fa fa-plus-circle"  aria-hidden="true"></i> ADD PURCHASE
            </button>

            <input type="text" id="searchInput" class="form-control" placeholder="Search For Medicine Name">

        </div>

        <!-- Table -->
        <table class="table table-bordered table-striped text-center" id="purchaseTable">
    <thead class="table-dark">
        <tr>
            <th>Purchase ID</th>
            <th>Supplier ID</th>
            <th>Medicine ID</th>
            <th>Medicine Name</th>
            <th>Quantity</th>
            <th>Cost of Purchase</th>
            <th>Date of Purchase</th>
            <th>Manufacturing Date</th>
            <th class="bg-danger text-white">Expiry Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Dynamic Data Will Be Loaded Here -->
    </tbody>
</table>

    </div>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box">
    <span class="close-btn" id="closeModal">&times;</span>
    <h3 style="margin-bottom: 20PX;">ADD PURCHASE DETAILS</h3>
        
	<form id="purchaseForm">
    <div class="row">
        <div class="column">
            <p><label for="pid">Purchase ID:</label><br>
            <input type="number" name="pid" required></p>

            <p><label for="sid">Supplier ID:</label><br>
            <input type="number" name="sid"></p>

            <p><label for="mid">Medicine ID:</label><br>
            <input type="number" name="mid" required></p>

            <p><label for="pqty">Purchase Quantity:</label><br>
            <input type="number" name="pqty"></p>
        </div>

        <div class="column">
            <p><label for="pcost">Purchase Cost:</label><br>
            <input type="number" step="0.01" name="pcost"></p>

            <p><label for="pdate">Date of Purchase:</label><br>
            <input type="date" name="pdate"></p>

            <p><label for="mdate">Manufacturing Date:</label><br>
            <input type="date" name="mdate"></p>

            <p><label for="edate">Expiry Date:</label><br>
            <input type="date" name="edate"></p>
        </div>
    </div>

    <center><button type="submit" class="save-btn">Add Purchase</button></center>
</form>

	</div>

</div>

</body>
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Function to load data
    function loadPurchaseData() {
        $.ajax({
            url: 'fetch_purchases.php?invoice_number=<?php echo $_GET['invoice_number']; ?>',
            type: 'GET',
            success: function(data) {
                $('#purchaseTable tbody').html(data);
            }
        });
    }

    // Initial load
    loadPurchaseData();

    // Form Submit using AJAX
    $('#purchaseForm').on('submit', function(e) {
        e.preventDefault(); // Prevent page reload

        $.ajax({
            url: 'add_purchase.php?invoice_number=<?php echo $_GET['invoice_number']; ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response);// Success or Error message
                $('#purchaseForm')[0].reset(); // Clear form
                loadPurchaseData(); // Reload table
                $('#modalOverlay').hide(); // Close modal
            }
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


$(document).ready(function () {
    $("#searchInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#purchaseTable tbody tr").filter(function () {
            $(this).toggle($(this).find(".med-name").text().toLowerCase().indexOf(value) > -1);
        });
    });
});

</script>

</html>
