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
    <title>Employee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<nav class="head">
    <a href="mainpage.php?invoice_number=<?php echo $_GET['invoice_number']; ?>" class="btn btn-light">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>
    <h2 class="text-white text-center flex-grow-1">EMPLOYEE LIST</h2>
</nav>


<div class="container mt-4">

    <div class="top-bar">
        <button class="btn btn-success add-product-btn" id="openModal">
            <i class="fa fa-plus-circle"></i> ADD EMPLOYEE
        </button>

        <input type="text" id="searchInput" class="form-control w-25" placeholder="Search Employees">
    </div>

    <table class="table table-bordered table-striped mt-3" id="EmployeeTable">
    <thead class="table-dark">
        <tr>
            <th>Employee ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Birth Date</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Employee Type</th>
            <th>Joining Date</th>
            <th>Salary</th>
            <th>Phone Number</th>
            <th>Email ID</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Dynamic Data Here -->
    </tbody>
</table>
</div>
<div class="modal-overlay" id="modalOverlay" style="margin-top:0; padding:0">
		<div class="modal-box">
				<span class="close-btn" id="closeModal">&times;</span>
				<h2>ADD EMPLOYEE</h2>
              
        <form id="addEmployeeForm">
        <div class="row">
						<div class="column">
						<p>
							<label for="eid">Employee ID:</label><br>
							<input type="number" name="eid" required="">
						</p>
						<p>
							<label for="efname">First Name:</label><br>
							<input type="text" name="efname" required="">
						</p>
						<p>
							<label for="elname">Last Name:</label><br>
							<input type="text" name="elname">
						</p>
						<p>
							<label for="ebdate">Date of Birth:</label><br>
							<input type="date" name="ebdate">
						</p>
						<p>
							<label for="eage">Age:</label><br>
							<input type="number" name="eage">
						</p>
						<p>
							<label for="esex">Gender:</label><br>
							<select id="esex" name="esex">
									<option value="selected">Select</option>
									<option>Female</option>
									<option>Male</option>
									<option>Others</option>
							</select>
						</p>
					</div>
					<div class="column">
						<p>
							<label for="etype">Employee Type:</label><br>
							<select id="etype" name="etype">
								<option value="selected">Select</option>
									<option>Pharmacist</option>
									<option>Manager</option>
							</select>
						</p>
						<p>
							<label for="ejdate">Date of Joining:</label><br>
							<input type="date" name="ejdate">
						</p>
						<p>
							<label for="esal">Salary:</label><br>
							<input type="number" step="0.01" name="esal">
						</p>
						<p>
							<label for="ephno">Phone Number:</label><br>
							<input type="number" name="ephno" required="">
						</p>
						
						<p>
							<label for="e_mail">Email ID:</label><br>
							<input type="text" name="e_mail">
						</p>
            
            <p>
							<label for="e_pass">Password:</label><br>
							<input type="text" name="e_pass" required="">
						</p>
            </div>
					<center>					
				<input type="submit" name="add" value="Add Employee" class="save-btn" style="margin: 0%;">
					</center>
          
        </form>

            </div>
          

<!-- jQuery CDN (AJAX साठी) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    // 🔄 Load Employees on Page Load
    fetchEmployees();

    // 💾 Form Submit (AJAX) साठी
    $('#addEmployeeForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'Employee_Add.php?invoice_number=<?php echo $_GET['invoice_number']; ?>', // Backend PHP File
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                alert(response);
                $('#addEmployeeForm')[0].reset(); // Form Clear
                fetchEmployees(); // 🔄 Table Refresh Without Reload
                $('#modalOverlay').hide(); // Close modal
            }
        });
    });

    // 👁️‍🗨️ Function: Fetch Employees
    function fetchEmployees() {
        $.ajax({
            url: 'fetch_employees.php?invoice_number=<?php echo $_GET['invoice_number']; ?>',
            type: 'GET',
            success: function (data) {
                $('#EmployeeTable tbody').html(data);
            }
        });
    }
});
    $(document).ready(function () {
            $("#searchInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#EmployeeTable tbody tr").filter(function () {
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

    .action-btn {
  width: 66px;
  margin: 4px;
  border: none;
  cursor: pointer;
  color: white;
  padding: 4px;
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
body { 
  background-color: #f4f4f9;
  text-align: center;
}

/* Trigger Button */
.button-container {
  display: flex;
  justify-content: flex-end; /* Push button to the right */
  margin-right: 150px; /* Margin on the right */
  padding: 10px;
}

/* Button Styling */
#openModal {
  margin: 0;
  background-color: #28a745;
  color: white;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px;
  transition: background 0.3s ease;
}
#openModal:hover {
  background-color: #218838;
}

/* Modal Overlay */
.modal-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  justify-content: center;
  align-items: center;
	margin: 0;
}

/* Modal Box */
.modal-box {
  background: #ccc;
  width: 600px;
  padding: 20px; 
	padding-top: 1px;
	padding-bottom: 1px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  position: relative;
  animation: fadeIn 0.3s ease-in-out;
  margin-top: 8px; /* Modal वरून 85px अंतरावर */
}


/* Modal Close Button */
.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 24px;
  color: #555;
  cursor: pointer;
  transition: color 0.3s ease;
}

.close-btn:hover {
  color: red;
}

/* Form Row Styling */
.row {
  margin-top: 0;
  display: flex;  
}

/* Column Styling */
.column {
  flex: 1;
}

/* Form Labels and Input Fields */
label {
  font-weight: bold;
  color: #333;

}
input[type="date"],
select {
  width: 100%;
  padding: 6.8px;
  /* margin-top: 1px; */
  /* margin-bottom: 3px; */
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 15px;
  border-color: #333;
}
input[type="text"],
input[type="number"],
select {
  width: 100%;
  padding: 8px;
  /* margin-top: 1px; */
  /* margin-bottom: 3px; */
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 15px;
  border-color: #333;
}

input:focus, select:focus {
  outline: none;
  border-color: #007bff;
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Save Button */
.save-btn {
  background-color: #28a745;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  margin-left: 10px;
  transition: background-color 0.3s ease;
}

.save-btn:hover {
  background-color: #218838;
}

/* Fade In Animation */
@keyframes fadeIn {
  from {
      opacity: 0;
      transform: translateY(-10px);
  }
  to {
      opacity: 1;
      transform: translateY(0);
  }
}
</style>