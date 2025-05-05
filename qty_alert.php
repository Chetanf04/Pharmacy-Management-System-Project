<!-- Code madhe database set nhiy -->

<?php
session_start();
if (!isset($_SESSION['user_session'])) {
    header("location:index.php");
}
include("Config2.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Medicine Stock</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    padding: 20px;
}
.stock {
    background:rgb(241, 246, 250);
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}
h3 {
    color: white;
    text-align: center;
    background-color: #333333;
    height: 60px;
    padding: 15px;
}

.table-responsive {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: white;
}
.form-control {
    width: 40%;
    margin: 0 auto 15px;
    text-align: center;
}

.table thead th {
background-color: black; 
color: white !important;
}
    </style>

</head>
<body>
<a style="margin: 0" href="mainpage.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="btn btn-secondary">
<i class="fa-solid fa-arrow-left"></i> Back to Dashboard
</a>

<div class="container" style="margin-top:20px;">
    <div class="stock" >
        <h3>MEDICINES OUT OF STOCK</h3>
        <hr>

        <input type="text" id="name_med"  class="form-control" onkeyup="med_name()" placeholder="Search For Medicine Names" title="Type in a name">

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table2">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Available</th>
                        <th style="background: #c53f3f;">Expiry</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("Config2.php");
                    $quantity = 10;

                    $select_sql = "SELECT meds.MED_NAME, meds.MED_QTY, meds.Sell_type, meds.selling_price, purchase.EXP_DATE 
                                FROM meds 
                                INNER JOIN purchase ON meds.MED_ID = purchase.MED_ID 
                                WHERE meds.MED_QTY <= '$quantity'";

                    $result = mysqli_query($con, $select_sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) :
                    ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['MED_NAME']); ?></td>
                                <td><font color="red"><?php echo htmlspecialchars($row['MED_QTY'] . " (" . $row['Sell_type'] . ")"); ?></font></td>
                                <td><?php echo htmlspecialchars($row['EXP_DATE']); ?></td>
                                <td><?php echo htmlspecialchars($row['selling_price']); ?></td>
                            </tr>
                        <?php endwhile;
                    } else { ?>
                        <tr>
                            <td colspan="4" class="text-center" style="color: red;">No Record Found</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function med_name() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("name_med");
        filter = input.value.toUpperCase();
        table = document.getElementById("table2");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0]; 
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

</body>
</html>
