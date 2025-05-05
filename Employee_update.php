<?php

session_start();

if(!isset($_SESSION['user_session'])){  //User_session

  header("location:index.php");
 
} 
include "Config.php";
		
if(isset($_GET['id']))
{
	$id=$_GET['id'];
	$qry1="SELECT * FROM employee WHERE e_id='$id'";
	$result = $conn->query($qry1);
	$row = $result -> fetch_row();
}


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!--Library-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
<title>Employees update</title>
<style>
    .head {
        margin-bottom: 20px;
        background-color: #333;
        color: white;
        text-align: center;
        font-weight: bold;
        padding: 15px;
    }
</style>
</head>
<body>
<nav class="head">
    <a href="Employee_view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back To Emploee View
    </a>
    <h2> UPDATE EMPLOYEE DETAILS</h2>
</nav>
<div class="container mt-4"style="background-color: aliceblue; padding-bottom:20px">  


<?php
			if( isset($_POST['update']))
		 {
			$id = mysqli_real_escape_string($conn, $_REQUEST['eid']);
			$fname = mysqli_real_escape_string($conn, $_REQUEST['efname']);
			$lname = mysqli_real_escape_string($conn, $_REQUEST['elname']);
			$bdate = mysqli_real_escape_string($conn, $_REQUEST['ebdate']);
			$age = mysqli_real_escape_string($conn, $_REQUEST['eage']);
			$sex = mysqli_real_escape_string($conn, $_REQUEST['esex']);
			$etype = mysqli_real_escape_string($conn, $_REQUEST['etype']);
			$jdate = mysqli_real_escape_string($conn, $_REQUEST['ejdate']);
			$sal = mysqli_real_escape_string($conn, $_REQUEST['esal']);
			$phno = mysqli_real_escape_string($conn, $_REQUEST['ephno']);
			$mail = mysqli_real_escape_string($conn, $_REQUEST['e_mail']);
			$invoice_number = $_POST['invoice_number'];
			 
		$sql="UPDATE employee
			SET e_fname='$fname',e_lname='$lname',bdate='$bdate',e_age='$age',e_sex='$sex',
			e_type='$etype',e_jdate='$jdate',e_sal='$sal',e_phno='$phno',e_mail='$mail' where e_id='$id'";
			
		if ($conn->query($sql))
		header("location:Employee_view.php?invoice_number=" . urlencode($invoice_number)); // ✅ Redirect with invoice_number
		else
		echo "<p style='font-size:8; color:red;'>Error! Unable to update.</p>";
		 }
		 
	?>

        <form action="<?= $_SERVER['PHP_SELF'] ?>?id=<?= htmlspecialchars($_GET['id'] ?? '') ?>" method="post" class="row g-3" style="text-align: center; font-weight:bold; font-size:23px; font-family:'Times New Roman', Times, serif">
        <input type="hidden" name="invoice_number" value="<?= htmlspecialchars($_GET['invoice_number'] ?? '') ?>">  <!-- ✅ Invoice Number preserved -->
 
             <div class="col-md-6">
						   <label for="eid" class="form-label">Employee ID:</label><br>
						   <input type="number" name="eid" value="<?php echo $row[0]; ?>" readonly>
            </div>
            <div class="col-md-6">
						  <label for="efname" class="form-label">First Name:</label><br>
						  <input type="text" name="efname" value="<?php echo $row[1]; ?>">
			      </div>
            <div class="col-md-6">
						<label for="elname" class="form-label">Last Name:</label><br>
						<input type="text" name="elname" value="<?php echo $row[2]; ?>">
            </div>
            <div class="col-md-6">
						<label for="ebdate" class="form-label">Date of Birth:</label><br>
						<input type="date" name="ebdate" value="<?php echo $row[3]; ?>">
            </div>
						<div class="col-md-6">
						<label for="eage" class="form-label">Age:</label><br>
						<input type="number" name="eage" value="<?php echo $row[4]; ?>">
            </div>
						<div class="col-md-6">
						<label for="esex" class="form-label">Gender:</label><br>
						<input type="text" name="esex" value="<?php echo $row[5]; ?>">
            </div>
						<div class="col-md-6">
						<label for="etype" class="form-label">Employee Type:</label><br>
						<input type="text" name="etype"  value="<?php echo $row[6]; ?>">
            </div>
						<div class="col-md-6">
						<label for="ejdate" class="form-label">Date of Joining:</label><br>
						<input type="date" name="ejdate" value="<?php echo $row[7]; ?>">
            </div>
						<div class="col-md-6">
						<label for="esal" class="form-label">Salary:</label><br>
						<input type="number" step="0.01" name="esal" value="<?php echo $row[8]; ?>">
            </div>
						<div class="col-md-6">
						<label for="ephno" class="form-label">Phone Number:</label><br>
						<input type="number" name="ephno" value="<?php echo $row[9]; ?>">
            </div>
						<div class="col-md-6">
						<label for="e_mail" class="form-label">Email ID:</label><br>
						<input type="text" name="e_mail"  value="<?php echo $row[10]; ?>">
            </div>
            <br><br>
						<center>
            <div class="col-md-6 text-center">
                <input type="submit" name="update" value="Update" class="btn btn-success" style="width: 100px; margin-top:40px">
            </div>
						</center>
        </form>
    </div>
</div>
    


	


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
input{
	width: 400px;
	border-radius: 5px;
	border: 1px solid rgb(199, 197, 197);
	font-size: 17px;
	padding: 7px;
	cursor: pointer;
}

</style>
</html>