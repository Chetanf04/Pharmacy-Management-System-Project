<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<style>
        .btn-primary {
            width: 160px !important;
        }
        .row {
            margin-left: 100px;
            justify-content: center;
        }
        .form-label {
            font-size: 18px;
            font-weight: 800;
        }
				.text-end{
					font-size: 18px;
					font-weight: 600;
				}
        .head { 
            display: flex;
            align-items: center;
            justify-content: center;
            background: #525050;
            padding: 10px 20px;
            color: white;
            font-weight: 300;
            position: relative;
            height: 80px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            margin-bottom: 20px;
        }
        .head a {
            position: absolute;
            left: 20px;
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
</head>

<body class="bg-light">
<nav class="head">
    <a href="mainpage.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back To Dashboard
    </a>
    <h2>TRANSACTION REPORTS</h2>
</nav>

<div class="container my-4">
    <div class="card p-4 shadow">
        <form action="" method="post" class="row g-3">
            <div class="col-md-4">
                <label for="start" class="form-label">Start Date:</label>
                <input type="date" name="start" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="end" class="form-label">End Date:</label>
                <input type="date" name="end" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <input type="submit" name="submit" value="View Records" class="btn btn-primary w-100">
            </div>
        </form>
    </div>
</div>

<div class="container">
    <?php
    include "Config.php";
    
    $start = "";
    $end = "";
    $pamt = 0;
    $samt = 0;
    $profits = 0;

    if (isset($_POST['submit'])) {
        $start = $_POST['start'];
        $end = $_POST['end'];
        
        $res = mysqli_query($conn, "SELECT P_AMT('$start','$end') AS PAMT") or die(mysqli_error($conn));
        $pamt = mysqli_fetch_array($res)['PAMT'];
        
        $res = mysqli_query($conn, "SELECT S_AMT('$start','$end') AS SAMT") or die(mysqli_error($conn));
        $samt = mysqli_fetch_array($res)['SAMT'];
        
        $profits = number_format($samt - $pamt, 2);
    }
    ?>

    <!-- Purchase Transactions Table -->
    <div class="card mt-4 p-4 shadow">
        <h4 class="mb-3">PURCHASE TRANSACTIONS:</h4>
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>Purchase ID</th>
                    <th>Supplier ID</th>
                    <th>Medicine ID</th>
                    <th>Quantity</th>
                    <th>Date of Purchase</th>
                    <th>Cost of Purchase ( <i class="fa-solid fa-indian-rupee-sign"></i> )</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p_id, sup_id, med_id, p_qty, p_cost, pur_date FROM purchase WHERE pur_date >= '$start' AND pur_date <= '$end'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['p_id']}</td>
                            <td>{$row['sup_id']}</td>
                            <td>{$row['med_id']}</td>
                            <td>{$row['p_qty']}</td>
                            <td>{$row['pur_date']}</td>
                            <td>{$row['p_cost']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr class="table-secondary">
                    <td colspan="5" class="text-end">Total</td>
                    <td><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo $pamt; ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Sales Transactions Table -->
    <div class="card mt-4 p-4 shadow">
        <h4 class="mb-3">SALES TRANSACTIONS:</h4>
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>Sale ID</th>
                    <th>Customer ID</th>
                    <th>Employee ID</th>
                    <th>Date</th>
                    <th>Sale Amount ( <i class="fa-solid fa-indian-rupee-sign"></i> )</th>
                </tr>
            </thead>
            <tbody>
    <?php
    $sql = "SELECT id, C_ID, e_id, date, total_amount FROM invoicesales WHERE date >= '$start' AND date <= '$end'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['C_ID']}</td>
                <td>{$row['e_id']}</td>
                <td>{$row['date']}</td>
                <td>{$row['total_amount']}</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
    }
    ?>
</tbody>
<tfoot>
    <tr class="table-secondary">
        <td colspan="4" class="text-end">Total</td>
        <td><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo number_format($samt, 2); ?></td>
    </tr>
</tfoot>
        </table>

    <!-- Profit Calculation -->
    <div class="card mt-4 p-4 shadow text-center">
        <h4>Transaction Amount</h4>
        <p class="h5"><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo $profits; ?></p>
    </div>
</div>

</body>
</html>
