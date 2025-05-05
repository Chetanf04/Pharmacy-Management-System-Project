<?php

session_start();

if(!isset($_SESSION['user_session'])){  //User_session

  header("location:index.php");
 
}                       
?>             

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" type="text/css" href="Customer_view.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="Customer_add.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Product</title>
</head>
<body>

  <nav class="head">
  <a href="Pharma_mainpage.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="btn btn-secondary">
  <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
  </a>
    <h2>MEDICINE PRODUCT</h2>
</nav>
<center>
<!-- <div class="contentheader_1">
        <h2>PRODUCT LIST : </h2> 
      </div> -->
          <div class="pr_row">
            <input type="text"  id="name_med1" size="4"  onkeyup="med_name1()" placeholder="Filter using ID" title="Type BarCode">
            <input type="text" size="4"  id="med_quantity" onkeyup="quanti()" placeholder="Filter using Medicine Name" title="Type Medicine Name">
</center>
</div>
<?php
include("Config2.php");

$select_sql = "SELECT * FROM meds ORDER BY MED_QTY";
$select_query = mysqli_query($con, $select_sql);

if (!$select_query) {
    die("Query Failed: " . mysqli_error($con)); // Shows the exact error
}

$row = mysqli_num_rows($select_query);
?>
    <div style="text-align:center; font-size:22px; margin-top:10px;">
    Total Medicines: <font color="green" style="font:bold 22px 'Aleo';">[<?php echo $row; ?>]</font>
    </div>
<table align="center" id="table1">
    <tr>
        <th>Medicine ID</th>
        <th>Medicine Name</th>
        <th>Category</th>
        <th>Quantity Available</th>
        <th>Sold Qty</th>
        <th style="background: #c53f3f;">Expiry Date</th>
        <th>Meds Price</th>
        <th>Status</th>
        <th>Location in Store</th>
    </tr>

    <?php
    include "Config.php";

    $sql = "SELECT 
                m.med_id, 
                m.med_name, 
                m.category, 
                m.med_qty, 
                m.Sold_qty,
                m.Sell_type,
                p.EXP_DATE, 
                m.selling_price, 
                m.status,
                m.location_rack 
            FROM meds m
            LEFT JOIN purchase p ON m.med_id = p.MED_ID
            ORDER BY p.EXP_DATE ASC"; 

    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error); // Display error if query fails
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["med_id"] . "</td>";
          echo "<td>" . $row["med_name"] . "</td>";
          echo "<td>" . $row["category"] . "</td>";
          echo "<td>" . $row["med_qty"] . "&nbsp;&nbsp;(<strong><i>" . $row["Sell_type"] . "</i></strong>)</td>";   
          echo "<td>" . $row["Sold_qty"] . "</td>";
          echo "<td>" . $row["EXP_DATE"] . "</td>";
          echo "<td>" . $row["selling_price"] . "</td>";
            // **Fixed Status Column**
            echo "<td>";
            $status = $row['status'];
            if ($status == 'Available') {
                echo '<span class="label label-success">' . $status . '</span>';
            } else {
                echo '<span class="label label-success">' . $status . '</span>';
            }
            echo "</td>";
            echo "<td>" . $row["location_rack"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No records found</td></tr>";
    }

    $conn->close();
    ?>
</table>



</body>
<style>
  :root {
  --box-shadow: 0 .5rem 1rem rgba(0,0,0.1);
}
  /* Body Styling */
  body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    background-color: #f4f4f9;
     /* box-sizing: border-box; */
    font-family: Arial, Helvetica, sans-serif;
    width: 100%;
  }
.head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background:#525050; /* Navbar background color */
  padding: 10px 20px;
  color: white;
  font-weight: 300;
  position: relative;
  height: 60px; /* Set height for better alignment */
  box-shadow: var(--box-shadow); 
  margin-bottom: 20px;

}
  


.head h2 {
  color: white;
  margin: 0 auto; /* Automatically adjust margins for centering */
  position: absolute;
  left: 50%; /* Start the element at 50% of the width */
  transform: translateX(-50%); /* Adjust the element's position to center */
}
/* Right-aligned link */
.topnav {
  position: absolute;
  right: 20px;
}

.topnav a {
  text-decoration: none;
  color: white;
  font-weight: bold;
  padding: 5px 10px;
  background-color: red; /* Button background color */
  border-radius: 5px;
  transition: background-color 0.3s ease;
}
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Table session */

.contentheader {
  width: 95%;
  height: 40px;
  display: flex;
  align-items: center;
  padding: 10px 10px 10px 0;
  margin: 20px  0 10px 15px;
  background-color:#ddd;
  }
  
#table1 {
  font-family: Arial;
  border-collapse: collapse;
  width: 80%;
  overflow:auto;
}

#table1 td, #table1 th {
  border: 1px solid #ddd;
  padding: 8px;
}

#table1 tr:nth-child(even){background-color: #f2f2f2;}

#table1 tr:hover {background-color: #ddd;}

#table1 th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #333;
  color: white;
}
.contentheader_1 {
width: 100%;
height: 50px;
margin: 20px;
display: flex;
align-items: center;
background-color: #ddd;
justify-content: center;
}

.pr_row {
  display: flex;
  align-items: center;
  gap: 5px;
  margin-top: 50px;
  width: 40%;
}

.column {
  flex: 1; /* Ensure each column takes up equal space */
  min-width: 150px; /* Minimum width for smaller screens */
}

input, button {
  width: 100%; /* Occupy full column width */
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 14px;
}
/* Trigger Button */
.button-container {
  margin-left: 20%;
  display: flex;
  justify-content: flex-end; /* Push button to the right */
  padding: 10px;
}

/* Button Styling */
#openModal {
  margin: 0;
  width: 200px;
  background-color: #28a745;
  color: white;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px;
  transition: background 0.3s ease;
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

/* customer add section */

body { 
  background-color: #f4f4f9;
  text-align: center;
}

/* Trigger Button */
.button-container {
  display: flex;
  justify-content: flex-end;
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
  margin: 0;
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
  gap: 20px;
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
  margin-top: 3px;
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
  margin-top: 3px;
  margin-bottom: 3px;
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

.btn-secondary{
  background-color:rgb(235, 242, 237);
  color: #525050;
  text-decoration: none;
  padding: 5px 10px;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;

  transition: background-color 0.3s ease;
}
.label{
    font-size: 11.844px;
    font-weight: bold;
    line-height: 14px;
    color: #ffffff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    white-space: nowrap;
    vertical-align: baseline;
    background-color: #999999;
    padding: 1px 4px 2px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
}
.label-success{
    background-color: #468847;
}
  
</style>

<script>
  function med_name1() {//***Search For Medicine *****
  var input, filter, table, tr, td, i;
  input = document.getElementById("name_med1");
  filter = input.value.toUpperCase();
  table = document.getElementById("table1");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

//***Search For quantity *****
function quanti() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("med_quantity");
  filter = input.value.toUpperCase();
  table = document.getElementById("table1");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

</script>
</html>
