<?php

session_start();

if(!isset($_SESSION['user_session'])){  //User_session

  header("location:index.php");
 
} 
	include "Config.php";
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$qry1="SELECT * FROM meds WHERE med_id='$id'";
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
   
<title>Medicine Update</title>
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
    <a href="Product_view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back To Product View
    </a>
    <h2>UPDATE MEDICINE DETAILS</h2>
</nav>
<div class="container mt-4"style="background-color: aliceblue; padding-bottom:20px">  


        
        <form action="<?= $_SERVER['PHP_SELF'] ?>?id=<?= htmlspecialchars($_GET['id'] ?? '') ?>" method="post" class="row g-3" style="text-align: center; font-weight:bold; font-size:23px; font-family:'Times New Roman', Times, serif">
        <input type="hidden" name="invoice_number" value="<?= htmlspecialchars($_GET['invoice_number'] ?? '') ?>">  <!-- ✅ Invoice Number preserved -->
 
             <div class="col-md-6">
				        <label for="medid">Medicine ID:</label><br>
					     <input type="number" name="medid" value="<?php echo $row[0]; ?>" readonly>
            </div>
            <div class="col-md-6">
						     <label for="medname" class="form-label">Medicine Name:</label><br>
						     <input type="text" name="medname" value="<?php echo $row[1]; ?>">
			      </div>
            <div class="col-md-6">
						    <label for="cat" class="form-label">Category:</label><br>
					     	<input type="text" name="cat" value="<?php echo $row[2]; ?>">
            </div>
            <div class="col-md-6">
						    <label for="qty" class="form-label">Quantity:</label><br>
						    <input type="number" name="qty" value="<?php echo $row[3]; ?>">
            </div>
            <div class="col-md-6">
						    <label for="sell_type" class="form-label">Sell Type:</label><br>
						    <input type="text" name="sell_type" value="<?php echo $row[4]; ?>">
            </div>
						<div class="col-md-6">
                <label for="actual_price" class="form-label">Actual Price: </label><br>
                <input type="number" step="0.01" name="actual_price" value="<?php echo $row[8]; ?>">
            </div>
            <div class="col-md-6">
						     <label for="selling_price" class="form-label">Selling Price: </label><br>
						     <input type="number" step="0.01" name="selling_price" value="<?php echo $row[6]; ?>">
            </div>
            
            <div class="col-md-6">
						    <label for="loc" class="form-label">Location:</label><br>
						    <input type="text" name="loc" value="<?php echo $row[7]; ?>">
            </div><br><br>
            <center>
            <div class="col-md-6 text-center">
                <input type="submit" name="update" value="Update" class="btn btn-success" style="width: 100px; margin-top:40px">
            </div>
            </center>
        </form>
    </div>
</div>
<?php

if( isset($_POST['medname']) || isset($_POST['cat']) || isset($_POST['qty']) || isset($_POST['sell_type']) || isset($_POST['selling_price']) || isset($_POST['loc']) || isset($_POST['invoice_number'])) {

    $id = $_POST['medid'];
    $name = $_POST['medname'];
    $cat = $_POST['cat'];
    $qty = $_POST['qty'];
    $sell_type = $_POST['sell_type'];
    $Sellprice = $_POST['selling_price'];
    $lcn = $_POST['loc'];
    $Actualprice = $_POST['actual_price'];
    $invoice_number = $_POST['invoice_number']; // Fetching invoice_number safely

    //Check Satus
    $status = ($qty <= 0) ? 'Unavailable' : 'Available';

    // SQL Query Update
    $sql = "UPDATE meds SET 
                med_name='$name', 
                category='$cat', 
                med_qty='$qty', 
                sell_type='$sell_type', 
                selling_price='$Sellprice', 
                location_rack='$lcn', 
                actual_price='$Actualprice', 
                status='$status' 
            WHERE med_id='$id'";

    // SQL Query RunningS
    if ($conn->query($sql)) {
        header("location:Product_view.php?invoice_number=" . urlencode($invoice_number));
    } else {
        echo "<p style='font-size:8;color:red;'>Error! Unable to update.</p>";
    }
}
?>

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