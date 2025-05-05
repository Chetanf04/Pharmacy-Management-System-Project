<?php
ob_start();
session_start();
include "Config2.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['user_session'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['user_session'];
echo "Admin ID: " . $admin_id; // ✅ Debugging साठी चेक करा




// ✅ Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['paid_amount']) || empty($_POST['invoice_number']) || empty($_POST['date'])) {
        die("<h3>Error: Some form fields are missing.</h3>");
    }

    $invoice_number = mysqli_real_escape_string($con, $_POST['invoice_number']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $paid_amount = mysqli_real_escape_string($con, $_POST['paid_amount']);

    // Fetch total amount from on_hold
    $total_amount = 0;
    $total_profit_amount = 0;  // ✅ Initialize total profit amount

    $select_sql = "SELECT amount, profit_amount FROM on_hold WHERE invoice_number = '$invoice_number'";
    $select_query = mysqli_query($con, $select_sql);
    if (!$select_query) {
        die("<h3>Error: " . mysqli_error($con) . "</h3>");
    }

    while ($row = mysqli_fetch_assoc($select_query)) {
        $total_amount += $row['amount'];
        $total_profit_amount += $row['profit_amount'];  // ✅ Calculate total profit
    }

    // Calculate change amount
    $change_amount = $paid_amount - $total_amount;

    // Fetch medicines from on_hold and update stock + insert into invoicesales
    $select_on_hold = "SELECT * FROM on_hold WHERE invoice_number = '$invoice_number'";
    $select_on_hold_query = mysqli_query($con, $select_on_hold);
    if (!$select_on_hold_query) {
        die("<h3>Error Fetching on_hold: " . mysqli_error($con) . "</h3>");
    }

    while ($row = mysqli_fetch_assoc($select_on_hold_query)) {
        $c_id = mysqli_real_escape_string($con, $row['C_ID']);
        $med_name = mysqli_real_escape_string($con, $row['medicine_name']);
        $category = mysqli_real_escape_string($con, $row['category']);
        $expire_date = mysqli_real_escape_string($con, $row['EXP_DATE']);
        $qty = mysqli_real_escape_string($con, $row['qty']);
        $profit_amt = mysqli_real_escape_string($con, $row['profit_amount']);  // ✅ Get profit per item

        // Update stock in meds table
        $select_stock = "SELECT MED_QTY, Sold_qty FROM meds WHERE MED_NAME = '$med_name' AND CATEGORY = '$category'";
        $select_stock_query = mysqli_query($con, $select_stock);
        
        if (!$select_stock_query) {
            die("<h3>Error Fetching Stock: " . mysqli_error($con) . "</h3>");
        }
        
        $row_stock = mysqli_fetch_assoc($select_stock_query);
        if ($row_stock) {
            $new_sold_qty = $row_stock['Sold_qty'] + $qty;  // आधी विकलेल्या वस्तू + नवीन विक्री
        
            $update_stock = "UPDATE meds SET Sold_qty = '$new_sold_qty' WHERE MED_NAME = '$med_name' AND CATEGORY = '$category'";
        
            if (!mysqli_query($con, $update_stock)) {
                die("<h3>Error Updating Stock: " . mysqli_error($con) . "</h3>");
            }
        }
        
        //update status on meds table
        $select_sql1 = "SELECT MED_QTY FROM meds WHERE MED_NAME = '$med_name' AND CATEGORY = '$category'";
        $result3 = mysqli_query($con, $select_sql1);

        if ($row = mysqli_fetch_assoc($result3)) {  // Single record expected, no need for while loop
         $remain_quantity = $row['MED_QTY'];

          if ($remain_quantity <= 0) {
          $update_quantity_sql = "UPDATE meds SET status = 'Unavailable' WHERE MED_NAME = '$med_name' AND CATEGORY = '$category'";
          } else {
           $update_quantity_sql = "UPDATE meds SET status = 'Available' WHERE MED_NAME = '$med_name' AND CATEGORY = '$category'";
           }

            // Execute the update query
         if (!mysqli_query($con, $update_quantity_sql)) {
                die("<h3>Error Updating Status: " . mysqli_error($con) . "</h3>");
          }
}


        // ✅ Debugging INSERT statement for errors
        $insert_sql = "INSERT INTO invoicesales (invoice_number, total_amount, paid_amount, change_amount, date, medicine_name, qty, profit_amount, C_ID, E_ID) 
                        VALUES ('$invoice_number', '$total_amount', '$paid_amount', '$change_amount', '$date', '$med_name', '$qty', '$profit_amt', '$c_id', '$admin_id')";

        if (!mysqli_query($con, $insert_sql)) {
            die("<h3>Error Inserting Invoice: " . mysqli_error($con) . "</h3>");
        } else {
            echo "<h3>Inserted: $med_name - $qty | Profit: $profit_amt</h3>";
        }
    }

    // Generate new invoice number
    $new_invoice_number = "CA-" . rand(100000, 999999);

    // Redirect to main page
    header("Location: mainpage.php?invoice_number=$new_invoice_number");
    exit();
} else {
    echo "<h3>Form not submitted correctly.</h3>";
}
?>

