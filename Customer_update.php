<?php

session_start();

if(!isset($_SESSION['user_session'])){  //User_session

  header("location:index.php");
 
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
   
<title>Medicines</title>
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
    <a href="Customer_view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back To Customer View
    </a>
    <h2>UPDATE CUSTOMER DETAILS</h2>
</nav>
<div class="container mt-4"style="background-color: aliceblue; padding-bottom:20px">  
        <?php
include "Config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qry1 = "SELECT * FROM customer WHERE c_id='$id'";
    $result = $conn->query($qry1);

    if ($result->num_rows > 0) {
        $row = $result->fetch_row(); // ✅ fetch_row() use kartoy
    } else {
        echo "<p class='text-danger text-center'>No customer found with ID: $id</p>";
        exit();
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['cid'];
    $fname = $_POST['cfname'];
    $lname = $_POST['clname'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $phno = $_POST['phno'];
    $mail = $_POST['emid'];
    $invoice_number = $_POST['invoice_number']; // ✅ Fetching invoice_number safely

    $sql = "UPDATE customer SET 
            c_fname='$fname', 
            c_lname='$lname', 
            c_age='$age', 
            c_sex='$sex', 
            c_phno='$phno', 
            c_mail='$mail' 
            WHERE c_id='$id'";

    if ($conn->query($sql)) {
        header("Location: Customer_view.php?invoice_number=" . urlencode($invoice_number)); // ✅ Redirect with invoice_number
        exit();
    } else {
        echo "<p class='text-danger text-center'>Error! Unable to update.</p>";
    }
}
?>

        
        <form action="<?= $_SERVER['PHP_SELF'] ?>?id=<?= htmlspecialchars($_GET['id'] ?? '') ?>" method="post" class="row g-3" style="text-align: center; font-weight:bold; font-size:23px; font-family:'Times New Roman', Times, serif">
        <input type="hidden" name="invoice_number" value="<?= htmlspecialchars($_GET['invoice_number'] ?? '') ?>">  <!-- ✅ Invoice Number preserved -->
 
        <div class="col-md-6">
                <label for="cid" class="form-label">Customer ID:</label>
                <input type="number" name="cid" value="<?php echo $row[0]; ?>" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label for="cfname" class="form-label">First Name:</label>
                <input type="text" name="cfname" value="<?php echo $row[1]; ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="clname" class="form-label">Last Name:</label>
                <input type="text" name="clname" value="<?php echo $row[2]; ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="age" class="form-label">Age:</label>
                <input type="number" name="age" value="<?php echo $row[3]; ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="sex" class="form-label">Gender:</label>
                <input type="text" name="sex" value="<?php echo $row[4]; ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="phno" class="form-label">Phone Number:</label>
                <input type="number" name="phno" value="<?php echo $row[5]; ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="emid" class="form-label">Email ID:</label>
                <input type="text" name="emid" value="<?php echo $row[6]; ?>" class="form-control">
            </div><br><br>
            <div class="col-md-6 text-center">
                <input type="submit" name="update" value="Update" class="btn btn-success" style="width: 100px; margin-top:40px">
            </div>
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
}
</style>
</html>