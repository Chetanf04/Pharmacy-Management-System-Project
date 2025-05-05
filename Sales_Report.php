<?php
include("Config2.php");
session_start();

if (!isset($_SESSION['user_session'])) {
    header("location:index.php");
}

$d1 = isset($_POST['d1']) ? $_POST['d1'] : '';
$d2 = isset($_POST['d2']) ? $_POST['d2'] : '';
$data_available = false;

if (isset($_POST['submit'])) {
    $select_sql = "SELECT 
                    date, 
                    invoice_number, 
                    C_ID,
                    GROUP_CONCAT(medicine_name SEPARATOR ', ') AS medicines, 
                    GROUP_CONCAT(qty SEPARATOR ', ') AS quantities, 
                    SUM(total_amount) AS total_amount, 
                    SUM(profit_amount) AS profit_amount
                   FROM invoicesales 
                   WHERE date BETWEEN '$d1' AND '$d2' 
                   GROUP BY invoice_number, date 
                   ORDER BY date DESC";

    $select_query = mysqli_query($con, $select_sql);
    if (!$select_query) {
        die("Error in query: " . mysqli_error($con));
    }
    if (mysqli_num_rows($select_query) > 0) {
        $data_available = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="Customer_view.css">
    <style>
        .navbar-brand { font-weight: bold; }
        .table th { background-color: #343a40; color: white; }
    </style>
</head>

<body>
    <nav class="head" style="height: 70px;">
      <a href="mainpage.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="btn btn-secondary">
      <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
      </a>
        <h2 style="color:white; font-size: 25px; font-weight:700">ADMIN SALES REPORT</h2>
    </nav>

    <div class="container my-5">
        <form action="Sales_Report.php?invoice_number=<?php echo $_GET['invoice_number'] ?? ''; ?>" method="POST" class="row justify-content-center g-3">
            <div class="col-md-4">
                <label for="d1" class="form-label"><strong>From:</strong></label>
                <input type="date" id="d1" name="d1" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="d2" class="form-label"><strong>To:</strong></label>
                <input type="date" id="d2" name="d2" class="form-control" required>
            </div>
            <div class="col-md-2 align-self-end">
                <button type="submit" name="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Search</button>
            </div>
        </form>

        <!-- ✅ Table Box Always Visible -->
        <div class="table-responsive mt-4">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Invoice No.</th>
                        <th>Customer ID</th>
                        <th>Medicines</th>
                        <th>Quantities</th>
                        <th>Total Amount</th>
                        <th>Total Profit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($data_available) {
                        while ($row = mysqli_fetch_array($select_query)) {
                            echo '<tr>
                                <td>' . htmlspecialchars($row['date']) . '</td>
                                <td>' . htmlspecialchars($row['invoice_number']) . '</td>
                                <td>' . htmlspecialchars($row['C_ID']) . '</td>
                                <td>' . htmlspecialchars($row['medicines']) . '</td>
                                <td>' . htmlspecialchars($row['quantities']) . '</td>
                                <td><i class="fa-solid fa-indian-rupee-sign"></i> ' . htmlspecialchars($row['total_amount']) . '</td>
                                <td><i class="fa-solid fa-indian-rupee-sign"></i> ' . htmlspecialchars($row['profit_amount']) . '</td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7" class="text-center" style="color:red; ">No Records Found</td></tr>';
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                    <th colspan="4">Total:</th>
                        <th>
                            <?php
                            if (isset($_POST['submit']) && !empty($d1) && !empty($d2)) {
                                $total_sql = "SELECT SUM(qty) AS total_quantity FROM invoicesales WHERE date BETWEEN '$d1' AND '$d2'";
                                $total_query = mysqli_query($con, $total_sql);
                                if ($total_query) {
                                    $row = mysqli_fetch_array($total_query);
                                    echo $row['total_quantity'] ?? 0;
                                }
                            } else {
                                echo "0"; // Default value
                            }
                            ?>
                        </th>
                        <th>
                            <?php
                            if (isset($_POST['submit']) && !empty($d1) && !empty($d2)) {
                                $amount_sql = "SELECT SUM(total_amount) AS total_amount FROM invoicesales WHERE date BETWEEN '$d1' AND '$d2'";
                                $amount_query = mysqli_query($con, $amount_sql);
                                if ($amount_query) {
                                    $row = mysqli_fetch_array($amount_query);
                                    echo '<i class="fa-solid fa-indian-rupee-sign"></i> ' . ($row['total_amount'] ?? 0);
                                }
                            } else {
                                echo '<i class="fa-solid fa-indian-rupee-sign"></i> 0';
                            }
                            ?>
                        </th>
                        <th>
                            <?php
                            if (isset($_POST['submit']) && !empty($d1) && !empty($d2)) {
                                $profit_sql = "SELECT SUM(profit_amount) AS profit_amount FROM invoicesales WHERE date BETWEEN '$d1' AND '$d2'";
                                $profit_query = mysqli_query($con, $profit_sql);
                                if ($profit_query) {
                                    $row = mysqli_fetch_array($profit_query);
                                    echo '<i class="fa-solid fa-indian-rupee-sign"></i> ' . ($row['profit_amount'] ?? 0);
                                }
                            } else {
                                echo '<i class="fa-solid fa-indian-rupee-sign"></i> 0';
                            }
                            ?>
                        </th>

                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
