<!-- This is a Perfect code butt table display later -->
<?php
$invoice_number = $_GET['invoice_number'];
include("Config2.php");

// Fetch data from the on_hold table for the given invoice_number
$select_sql = "SELECT * FROM on_hold WHERE invoice_number = '$invoice_number'";
$select_query = mysqli_query($con, $select_sql);

// Check if records are available
if (mysqli_num_rows($select_query) > 0) {
    ?>
    <table class="table table-bordered table-striped table-hover" id="resultTable" data-responsive="table"  style="margin-left: 1.5%; width:98%">
        <thead>
        <tr style="background-color:#333333; color:#ffffff; height:38px">
            <th class="color">Customer ID</th>
            <th class="color">Medicine</th>
            <th class="color">Category</th>
            <th style="background: #c53f3f;">Expiry Date</th>
            <th class="color">Price</th>
            <th class="color">Qty</th>
            <th class="color">Amount</th>
            <th class="color">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        while ($row = mysqli_fetch_array($select_query)) {
            $i++;
            ?>
            <tr class="record">
                <td>
                    <?php echo $row['C_ID']; ?>
                </td>
                <td>
                    <?php echo $row['medicine_name']; ?>
                    <input type="hidden" value="<?php echo $row['id']; ?>" id="med_id<?php echo $i; ?>" name="med_id">
                </td>
                <td>
                    <?php echo $row['category']; ?>
                </td>
                <td>
                    <?php echo $row['EXP_DATE']; ?>
                </td>
                <td>
                    <?php echo $row['cost']; ?>
                </td>
                <td>
                    <input type="number" id="quantity<?php echo $i; ?>" name="quantity" value="<?php echo $row['qty']; ?>" min="1" max="10" style="width:50px">
                    <a href="#" class="qty_upd<?php echo $i; ?>"><span class="icon-refresh"></span></a>
                </td>
                <td>
                    <?php echo $row['amount']; ?>
                </td>
                <td>
                    <a href="delete_invoice.php?invoice_number=<?php echo $invoice_number; ?>&id=<?php echo $row['id']; ?>" class="btn btn-danger">Remove</a>
                  </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <th colspan="6"><font size="6"><strong>Total:</strong></font></th>
            <td colspan="2">
                <strong>
                    <?php
                    $total_sql = "SELECT SUM(amount) AS total_amount FROM on_hold WHERE invoice_number = '$invoice_number'";
                    $total_query = mysqli_query($con, $total_sql);
                    $total_row = mysqli_fetch_assoc($total_query);
                    echo '$' . $total_row['total_amount'];
                    ?>
                </strong>
            </td>
        </tr>
        </tbody>
    </table>
 
    <a class="btn-info btn-large"  onclick="openModal()">
        Proceed <i class="fa-sharp fa-solid fa-share"></i>
    </a>
    <?php
} else {
    ?>
    <div class="sales-alert">
        <h3><center>No Sales Available!!</center></h3>
    </div>
    <?php
}
?>



<div class="container">
    <div class="row">
      <table class="table table-bordered table-striped table-hover" id="resultTable" data-responsive="table">
  
        <thead>
        <tr style="background-color: #383838; color: #FFFFFF;" >
            <th> Medicine </th>
            <th> Category</th>
            <th style="background: #c53f3f;"> Expiry Date</th>
            <th> Price </th>
            <th> Qty </th>
            <th> Amount </th>
            <th> Action </th>
          </tr>
        </thead>
      
               <tbody>
                <?php
            $invoice_number= $_GET['invoice_number'];
            $medicine_name = "";
            $category= "";
            $quantity= "";
      
                include("dbcon.php");
      
                $select_sql = "SELECT * from on_hold where invoice_number = '$invoice_number' ";
      
                $select_query = mysqli_query($con ,$select_sql);
      
                   $i = 0;
                    
                  while($row = mysqli_fetch_array($select_query)):
      
                    $i++;
                ?>
      
                <tr class="record">
                     <td><?php
      
      
                       $med_id = $row['id'];
                       $medicine_name=$row['medicine_name'];
                       echo $medicine_name;
                       echo "<input type='hidden' value=$med_id id='med_id$i' name='med_id'>";
                       echo "<input type='hidden' value=$medicine_name id='med_name$i' name='med_name'>"
                      ?></td>
                     <td><?php $category = $row['category'];
                     echo $category;
                      ?>
                         <input type="hidden" value='<?php echo $category?>' id='med_cat<?php echo $i?>' name='med_cat'>
                        
                      </td>
                      <td>
                        <?php 
                        $ex_date=$row['expire_date'];
                        echo $ex_date;
                         ?>
                         <input type="hidden" id="ex_date<?php echo $i?>" value='<?php echo $ex_date?>'' name='ex_date'>
      
                      </td>
                     <td><?php echo  $row['cost']; ?></td>
                     <td>
                     <?php
      
                        $quantity =  $row['qty'];
                        $type     =  $row['type'];
                        echo "<input type='hidden' id='hid_quantity$i' value='$quantity' name='hid_quantity'>";
                        echo "<input type='number' id='quantity$i' name='quantity' value='$quantity' min='1' max='10' style='width:50px'>"."&nbsp;(".$type.")&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo "<a href='#' class='qty_upd$i'><span class='icon-refresh'></span></a>";
                        echo "<div class='ajax-loader$i' style='visibility:hidden'>
      
                             <img src='src/img/loading.gif'>
      
                             </div>
                           ";
                                     ?>
                     </td>
                     
                     <td><?php echo $row['amount']; ?></td>
           <td><a href="delete_invoice.php?invoice_number=<?php echo $_GET['invoice_number']?>&id=<?php echo $row['id'];?>&name=<?php echo $row['medicine_name']?>&expire_date=<?php echo $row['expire_date']?>&quantity=<?php echo $row['qty'];?>" class="btn btn-danger">Remove</a></td>
      
                  <?php endwhile; ?>  
                </tr>
                <tr>
              <th colspan="5" ><font size=6><strong> Total:</strong></font></th>
              <td  colspan="2"><strong>
      
                <?php
      
                $select_sql = "SELECT sum(amount) , sum(profit_amount) from on_hold where invoice_number = '$invoice_number'";
      
                $select_query= mysqli_query($con,$select_sql);
      
                while($row = mysqli_fetch_array($select_query)){
      
                  $grand_total = $row['sum(amount)'];
                  $grand_profit =$row['sum(profit_amount)'];
                  echo '$'.$grand_total;
                }
                ?>
              </td>
            </tr>
        </tbody>
      </table><br>
      
          <?php
           if($medicine_name && $category && $quantity !=null){
            ?>
      
            <a id="popup" href="checkout.php?invoice_number=<?php echo $_GET['invoice_number']?>&medicine_name=<?php echo $medicine_name?>&category=<?php echo $category?>&ex_date=<?php echo $ex_date?>&quantity=<?php echo $quantity?>&total=<?php echo $grand_total?>&profit=<?php echo $grand_profit?>" style="width:400px;" class="btn btn-info btn-large">Proceed <i class="icon icon-share-alt"></i></a>
      
          <?php
           }else{
      
      
            ?>
      
      <div class="alert alert-danger">
        <h3><center>No Sales Available!!</center> </h3>
    </div>
      
          <?php
       
                }
      
          ?>


<!-- New code but only one row display. -->

<!-- New code but only one row display. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .navbar-custom {
            background-color: #333 !important;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 80px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            border-bottom-right-radius: 5px;
            border-bottom-left-radius: 5px;
        }
        .navbar-custom h2 {
            color: white;
            margin: 0 auto;
            text-align: center;
            width: 100%;
        }
        body {
            padding-top: 60px;
        }
    </style>
</head>
<body class="container mt-4">
    <nav class="navbar navbar-custom">
        <h2>CUSTOMERS LIST</h2>
    </nav>

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
                <th>Sex</th>
                <th>Phone Number</th>
                <th>Email Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
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
                    echo "<td class='text-center'>";
                    echo "<a href='Customer_update.php?id=" . $row['c_id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                    echo "<a href='Customer_delete.php?id=" . $row['c_id'] . "' class='btn btn-danger btn-sm'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            $conn->close();
            ?>
        </tbody>
    </table>

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
              <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                  <div class="row">
                      <div class="column">
                          <p>
                              <label for="cid">Customer ID:</label>
                              <input type="number" name="cid" id="cid" placeholder="Enter ID">
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
                          <p>
                              <label for="sex">Sex:</label>
                              <select id="sex" name="sex">
                                  <option value="">Select</option>
                                  <option value="Female">Female</option>
                                  <option value="Male">Male</option>
                                  <option value="Others">Others</option>
                              </select>
                          </p>
                      </div>
                      <div class="column">
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
      </div>

		
      <?php
			include "Config.php";
			 
			if(isset($_POST['add']))
			{
			$id = mysqli_real_escape_string($conn, $_REQUEST['cid']);
			$fname = mysqli_real_escape_string($conn, $_REQUEST['cfname']);
			$lname = mysqli_real_escape_string($conn, $_REQUEST['clname']);
			$age = mysqli_real_escape_string($conn, $_REQUEST['age']);
			$sex = mysqli_real_escape_string($conn, $_REQUEST['sex']);
			$phno = mysqli_real_escape_string($conn, $_REQUEST['phno']);
			$mail = mysqli_real_escape_string($conn, $_REQUEST['emid']);

			 
			$checkQuery = "SELECT * FROM customer WHERE c_id = $id";
            $checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows > 0) {
    echo "<p style='font-size:8; color:red;'>Customer ID already exists!</p>";
} else {
    $sql = "INSERT INTO customer VALUES ($id, '$fname', '$lname', $age, '$sex', $phno, '$mail')";
    if (mysqli_query($conn, $sql)) {
        echo "<p style='font-size:8;'>Customer successfully added!</p>";
    } else {
        echo "<p style='font-size:8; color:red;'>Error! Check details.</p>";
    }
}
            }
			$conn->close();
			?>


    
</body>

</html>
