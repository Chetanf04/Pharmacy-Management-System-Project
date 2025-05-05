<?php
session_start();

if (!isset($_SESSION['user_session'])) {
    header("location:index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!--Library-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        function Clickheretoprint() {
            var disp_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,";
            disp_setting += "scrollbars=yes,width=700,height=400,left=100,top=25";
            var content_value = document.getElementById("content").innerHTML;

            var docprint = window.open("", "", disp_setting);
            docprint.document.open();
            docprint.document.write('<html><head><title>Print Invoice</title></head><body onload="self.print()">');
            docprint.document.write(content_value);
            docprint.document.write('</body></html>');
            docprint.document.close();
            docprint.focus();
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <a href="Pharma_mainpage.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Sales
            </a>
            <button onclick="Clickheretoprint()" class="btn btn-danger">
                <i class="bi bi-printer"></i> Print
            </button>
        </div>

        <div id="content">
            <div class="text-center mb-4">
                <h1 class="fw-bold">MEDICURE</h1>
                <hr>
            </div>

            <?php 

            $invoice_number = $_GET['invoice_number'];
            $date = $_POST['date'];
            $paid_amount = $_POST['paid_amount'];
            ?>

            <h3>Invoice Number: <span class="text-primary"><?php echo $invoice_number; ?></span></h3>
            <p><strong>Date:</strong> <?php echo $date; ?></p>
           
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Customer ID</th>
                        <th>Medicine</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("Config2.php");

                    $select_sql = "SELECT * FROM on_hold WHERE invoice_number = '$invoice_number'";
                    $select_query = mysqli_query($con, $select_sql);

                    while ($row = mysqli_fetch_array($select_query)) :
                    ?>
                    <tr>
                        <td><?php echo $row['C_ID']; ?></td>
                        <td><?php echo $row['medicine_name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['qty'] ; ?></td>
                        <td><?php echo $row['cost']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                    </tr>
                    <?php endwhile; ?>

                    <tr>
                        <td colspan="5" class="text-end fw-bold">Total:</td>
                        <td>
                            <?php
                            $total_sql = "SELECT SUM(amount) AS total_amount FROM on_hold WHERE invoice_number = '$invoice_number'";
                            $total_query = mysqli_query($con, $total_sql);
                            $total_row = mysqli_fetch_assoc($total_query);
                            $amount = $total_row['total_amount'];
                            echo '<i class="fa-solid fa-indian-rupee-sign"></i> ' . $amount;
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="5" class="text-end fw-bold">Paid Amount:</td>
                        <td><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo $paid_amount; ?></td>
                    </tr>

                    <tr>
                        <td colspan="5" class="text-end fw-bold">Change Amount:</td>
                        <td><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo $paid_amount - $amount; ?></td>
                    </tr>
                </tbody>
            </table>

            <form method="POST" action="Pharma_save_invoice.php">
                <input type="hidden" name="paid_amount" value="<?php echo $paid_amount; ?>">
                <input type="hidden" name="invoice_number" value="<?php echo $invoice_number; ?>">
                <input type="hidden" name="date" value="<?php echo $date; ?>">
                <button type="submit" class="btn btn-success">Submit and Make New Sales</button>
            </form>
        </div>
    </div>
</body>
</html>