
<?php
session_start();

if (!isset($_SESSION['user_session'])) {
    header("location:index.php");
    exit;
}

include("Config2.php");

if (isset($_POST['submit'])) {

    // Get data from the form
    $invoice_number = $_GET['invoice_number']; // Retains invoice number without modification
    $product = trim($_POST['product']);
    $qty = $_POST['qty'];
    $date = $_POST['date'];
    $C_ID = $_POST['C_ID']; // Added Customer ID

    // Check if customer exists in the customer table
    $customer_check_sql = "SELECT * FROM customer WHERE C_ID = '$C_ID'";
    $customer_check_query = mysqli_query($con, $customer_check_sql);

    if (!mysqli_fetch_array($customer_check_query)) {
        die("Error: Customer ID not found in database.");
    }

    // Fetch product details from the meds table
    $select_sql = "SELECT * FROM meds WHERE MED_NAME = '$product'";
    $select_query = mysqli_query($con, $select_sql);

    if ($row = mysqli_fetch_array($select_query)) {
        $medicine_name = $row['MED_NAME'];
        $category = $row['CATEGORY'];
        $available_qty = $row['MED_QTY'];
        $actual_price = $row['actual_price'];
        $cost = $row['selling_price'];
    } else {
        die("Error: Product not found in database.");
    }

    // Check if the requested quantity is available
    if ($available_qty < $qty) {
        die("Error: Not enough stock available.");
    }

    if ($row) {
        $current_stock = $row['MED_QTY'];
    
        if ($current_stock >= $qty) {
            // Update stock only if enough quantity is available
            $update_sql = "UPDATE meds SET MED_QTY = MED_QTY - $qty WHERE MED_NAME = '$product'";
            $update_query = mysqli_query($con, $update_sql);
    
            if (!$update_query) {
                die("Error updating stock: " . mysqli_error($con));
            } else {
                echo "Stock updated successfully!";
            }
        } else {
            echo "Error: Not enough stock available! Current stock: $current_stock";
        }
    } else {
        echo "Error: Medicine not found!";
    }

    // Calculate amount
    $amount = $qty * $cost;

   // Calculate profit
    $profit = $cost - $actual_price;
	$profit_amount = $profit*$qty;

    // Fetch updated stock quantity for verification
    $select_sql = "SELECT MED_QTY FROM meds WHERE MED_NAME = '$product'";
    $select_query = mysqli_query($con, $select_sql);

    if ($row = mysqli_fetch_array($select_query)) {
        $updated_qty = $row['MED_QTY'];
    }

    // If quantity becomes zero, mark the product as unavailable (if needed)
    if ($updated_qty <= 0) {
        $update_status_sql = "UPDATE meds SET status = 'Unavailable' WHERE MED_NAME = '$product'";
        $update_status_query = mysqli_query($con, $update_status_sql);
    }

    // Fetch EXP_DATE from the purchase table
    $exp_sql = "SELECT EXP_DATE FROM purchase WHERE MED_ID = (SELECT MED_ID FROM meds WHERE MED_NAME = '$product') ORDER BY EXP_DATE ASC LIMIT 1";
    $exp_query = mysqli_query($con, $exp_sql);
    
    if ($exp_row = mysqli_fetch_array($exp_query)) {
        $exp_date = $exp_row['EXP_DATE'];
    } else {
        $exp_date = NULL; // If no expiry date found, store NULL
    }

    // Insert transaction details into on_hold table with C_ID
    $insert_sql = "INSERT INTO on_hold (invoice_number, medicine_name, category, qty, cost, amount, date, EXP_DATE, C_ID, profit_amount) 
                   VALUES ('$invoice_number', '$medicine_name', '$category', '$qty', '$cost', '$amount', '$date', '$exp_date', '$C_ID', '$profit_amount')";
    $insert_query = mysqli_query($con, $insert_sql);

    if ($insert_query) {
        header("location:Pharma_mainpage.php?invoice_number=$invoice_number");
        exit;
    } else {
        die("Error in transaction: " . mysqli_error($con));
    }
}
?>
