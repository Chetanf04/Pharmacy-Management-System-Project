 <?php

session_start();

if(!isset($_SESSION['user_session'])){  //User_session

  header("location:index.php");
 
}  

		include "Config.php";
	
		if(isset($_GET['pid'])&&isset($_GET['sid'])&&isset($_GET['mid'])&& isset($_GET['invoice_number']))
		{
			$pid=$_GET['pid'];
			$sid=$_GET['sid'];
			$mid=$_GET['mid'];
			$invoice_number = $_GET['invoice_number']; 
			$qry1="SELECT * FROM purchase WHERE p_id='$pid' and sup_id='$sid' and med_id='$mid'";
			$result = $conn->query($qry1);
			$row = $result -> fetch_row();
		}
		
		 if( isset($_POST['update']))
		 {
			$pid=$_POST['pid'];
			$sid=$_POST['sid'];
			$mid=$_POST['mid'];
			$qty = $_POST['pqty'];
			$cost = $_POST['pcost'];
			$pdate = $_POST['pdate'];
			$mdate = $_POST['mdate'];
			$edate = $_POST['edate'];
			$invoice_number = $_POST['invoice_number'];
			 
		$sql="UPDATE purchase SET p_cost='$cost',p_qty='$qty',pur_date='$pdate',mfg_date='$mdate',exp_date='$edate' 
				where p_id='$pid' and sup_id='$sid' and med_id='$mid'";
		if ($conn->query($sql) === TRUE) {
			header("Location: Purchase_view.php?invoice_number=" . urlencode($invoice_number));
exit();
 // Ensure script stops after redirection
	} else {
			echo "Error updating record: " . $conn->error;
	}
}
?>          
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"><!--Library-->
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
    <a href="Purchase_view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back To Purchase View
    </a>
    <h2>UPDATE PURCHASE DETAILS</h2>
</nav>
<div class="container mt-4"style="background-color: aliceblue; padding-bottom:20px">  
<?php 
			if( isset($_POST['update']))
		 {
			$pid=$_POST['pid'];
			$sid=$_POST['sid'];
			$mid=$_POST['mid'];
			$qty = $_POST['pqty'];
			$cost = $_POST['pcost'];
			$pdate = $_POST['pdate'];
			$mdate = $_POST['mdate'];
			$edate = $_POST['edate'];
			$invoice_number = $_POST['invoice_number'];
			
			$sql="UPDATE purchase SET p_cost='$cost',p_qty='$qty',pur_date='$pdate',mfg_date='$mdate',exp_date='$edate' 
				where p_id='$pid' and sup_id='$sid' and med_id='$mid'";
			if (!($conn->query($sql)))
				echo "<p style='font-size:8; color:red;'>Error! Unable to update.</p>";
		 }
	?>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="row g-3 p-4 shadow rounded bg-light" style="text-align: center; font-weight:bold; font-size:20px; font-family:'Times New Roman', Times, serif">
				<input type="hidden" name="invoice_number" value="<?= isset($invoice_number) ? htmlspecialchars($invoice_number) : '' ?>">
            <div class="col-md-6">
                <label for="pid" class="form-label">Purchase ID:</label>
                <input type="number" name="pid" class="form-control" value="<?= $row[0] ?? '' ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="sid" class="form-label">Supplier ID:</label>
                <input type="number" name="sid" class="form-control" value="<?= $row[1] ?? '' ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="mid" class="form-label">Medicine ID:</label>
                <input type="number" name="mid" class="form-control" value="<?= $row[2] ?? '' ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="pqty" class="form-label">Purchase Quantity:</label>
                <input type="number" name="pqty" class="form-control" value="<?= $row[3] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label for="pcost" class="form-label">Purchase Cost:</label>
                <input type="number" step="0.01" name="pcost" class="form-control" value="<?= $row[4] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label for="pdate" class="form-label">Date of Purchase:</label>
                <input type="date" name="pdate" class="form-control" value="<?= $row[5] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label for="mdate" class="form-label">Manufacturing Date:</label>
                <input type="date" name="mdate" class="form-control" value="<?= $row[6] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label for="edate" class="form-label">Expiry Date:</label>
                <input type="date" name="edate" class="form-control" value="<?= $row[7] ?? '' ?>">
            </div>
            <div class="col-12 text-center mt-4">
                <input type="submit" name="update" value="Update" class="btn btn-success px-4">
            </div>
        </form>

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
</style>
</html>