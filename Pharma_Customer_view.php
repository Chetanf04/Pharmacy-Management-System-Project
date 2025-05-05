<?php

session_start();

if(!isset($_SESSION['user_session'])){  
    header("location:index.php");
    exit;
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
    <!--Library-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Customer_add.css">
    <style>


body {

height: 100vh;
overflow-y: auto; 
}
/* Modal Box */
.modal-box {
background: #ccc;
width: 600px;
padding: 20px;
padding-top: 0;
border-radius: 8px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
position: relative;
animation: fadeIn 0.3s ease-in-out;
margin-top: 85px; /* Modal वरून 85px अंतरावर */
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
    z-index: 999;
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
</head>
<body>
<nav class="head">
    <a href="Pharma_mainpage.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="btn btn-secondary">
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

<!-- Customer Table -->
<div id="customerTableWrapper">
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
            </tr>
        </thead>
        <tbody id="customerTableBody">
            <?php
            include "Config.php";
            $sql = "SELECT c_id, c_fname, c_lname, c_age, c_sex, c_phno, c_mail FROM customer";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["c_id"] . "</td>";
                    echo "<td>" . $row["c_fname"] . "</td>";
                    echo "<td>" . $row["c_lname"] . "</td>";
                    echo "<td>" . $row["c_age"] . "</td>";
                    echo "<td>" . $row["c_sex"] . "</td>";
                    echo "<td>" . $row["c_phno"] . "</td>";
                    echo "<td>" . $row["c_mail"] . "</td>";
                    echo "</tr>";
                }
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!-- ✅ Message Display साठी Div -->
<div id="message" style="margin-top: 10px;"></div>

    <script>
        $(document).ready(function () {
            $("#searchInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#customerTable tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>

	
        <!-- Modal Container -->
        <div class="modal-overlay" id="modalOverlay">
          <div class="modal-box">
              <span class="close-btn" id="closeModal">&times;</span>
              <h2>ADD CUSTOMER</h2>
              <form id="addCustomerForm" action="Pharma_Customer_view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" method="post">
                  <div class="row">
                      <div class="column">
                          <p>
                              <label for="cid">Customer ID:</label>
                              <input type="number" name="cid" id="cid" placeholder="Enter ID" required="">
                          </p>
                          <p>
                              <label for="cfname">First Name:</label>
                              <input type="text" name="cfname" id="cfname" placeholder="Enter First Name">
                          </p>
                          <p>
                              <label for="clname">Last Name:</label>
                              <input type="text" name="clname" id="clname" placeholder="Enter Last Name">
                          </p>
                          <p>
                         
                              <label for="age">Age:</label>
                              <input type="number" name="age" id="age" placeholder="Enter Age">
                          </p>
                          </div>
                          <div class="column">
                          <p>
                              <label for="sex">Gender:</label>
                              <select id="sex" name="sex">
                                  <option value="">Select</option>
                                  <option value="Female">Female</option>
                                  <option value="Male">Male</option>
                                  <option value="Others">Others</option>
                              </select>
                          </p>
                    
                          <p>
                              <label for="phno">Phone Number:</label>
                              <input type="number" name="phno" id="phno" placeholder="Enter Phone Number">
                          </p>
                          <p>
                              <label for="emid">Email ID:</label>
                              <input type="text" name="emid" id="emid" placeholder="Enter Email">
                          </p>
                      </div>
                  </div>
                  <input type="submit" name="add" value="Add Customer" class="save-btn">
              </form>
          </div>
          <div id="message"></div>
          <?php
include "Config.php";

if (isset($_POST['cid'])) {
    $id = mysqli_real_escape_string($conn, $_POST['cid']);
    $fname = mysqli_real_escape_string($conn, $_POST['cfname']);
    $lname = mysqli_real_escape_string($conn, $_POST['clname']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $phno = mysqli_real_escape_string($conn, $_POST['phno']);
    $mail = mysqli_real_escape_string($conn, $_POST['emid']);

    $checkQuery = "SELECT * FROM customer WHERE c_id = $id";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
     
    } else {
        $sql = "INSERT INTO customer VALUES ($id, '$fname', '$lname', $age, '$sex', $phno, '$mail')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    document.getElementById('message').innerHTML = '<p style=\"color:green;\">Customer successfully added!</p>';
                  </script>";
        } else {
            echo "<script>
                    document.getElementById('message').innerHTML = '<p style=\"color:red;\">Error! Check details.</p>';
                  </script>";
        }
    }
}

$conn->close();
?>
    
</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$("#addCustomerForm").on("submit", function (e) {
    e.preventDefault();

    if ($("#cid").val() === "" || $("#cfname").val() === "" || $("#phno").val() === "") {
        $("#message").html("<div class='alert alert-danger'>Please fill required fields.</div>");
        return;
    }

    $.ajax({
        url: "Pharma_Customer_view.php",
        type: "POST",
        data: $(this).serialize(),
        success: function (response) {
            $("#message").html(response);
            if (response.includes("successfully")) {
                fetchCustomerTable();
                $("#addCustomerForm")[0].reset();
                $("#modalOverlay").hide(); // Close modal after success
            }
        }
    });



    // Separate function to fetch and refresh customer table
    function fetchCustomerTable() {
        $.ajax({
            url: "Pharma_fetch_customers.php", // This fetches the updated table
            success: function (data) {
                $("#customerTableBody").html(data); // Update table body
            }
        });
    }
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
</html>