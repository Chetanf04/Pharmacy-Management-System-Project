<!-- Code madhe database set nhiy -->
<?php
session_start();
if (!isset($_SESSION['user_session'])) {
    header("location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Expiry Alert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        function med_name() {
            var input = document.getElementById("name_med");
            var filter = input.value.toUpperCase();
            var table = document.getElementById("table1");
            var tr = table.getElementsByTagName("tr");
            for (var i = 1; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    tr[i].style.display = td.innerHTML.toUpperCase().indexOf(filter) > -1 ? "" : "none";
                }
            }
        }
    </script>
</head>
<body>
<a style="margin: 15px;" href="mainpage.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" class="btn btn-secondary">
<i class="fa-solid fa-arrow-left"></i> Back to Dashboard
</a>
    <div class="container mt-4">
        <div class="alert alert-warning text-center" style="background-color: #333; color:white">
            <h4>MEDICINES GOING TO EXPIRE</h4>
        </div>
        <center>
        <input type="text" id="name_med" style="width: 300px; text-align:center" class="form-control mb-3" onkeyup="med_name()" placeholder="Search For Medicine Names">
        </center>
        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
            <table class="table table-bordered table-hover" id="table1">
                <thead class="table-dark">
                    <tr>
                        <th>Medicine</th>
                        <th style="background: #c53f3f;">Expiry</th>
                        <th>Available</th>
                        <th>Cost</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("Config2.php");

                    $date = date('Y-m-d');    
                    $inc_date = date("Y-m-d", strtotime("+6 month", strtotime($date))); 

                    $select_sql = "SELECT meds.MED_NAME, meds.MED_QTY, meds.Sell_type, meds.selling_price, 
                                        purchase.EXP_DATE 
                                FROM meds 
                                INNER JOIN purchase ON meds.MED_ID = purchase.MED_ID 
                                WHERE purchase.EXP_DATE <= '$inc_date' 
                                ORDER BY purchase.EXP_DATE ASC";

                    $result = mysqli_query($con, $select_sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) :
                    ?> 
                        <tr>
                            <td><?php echo htmlspecialchars($row['MED_NAME']); ?></td>
                            <td class="text-danger"><strong><?php echo htmlspecialchars($row['EXP_DATE']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['MED_QTY'] . " (" . $row['Sell_type'] . ")"); ?></td>
                            <td><?php echo htmlspecialchars($row['selling_price']); ?></td>
                            <td><?php echo htmlspecialchars($row['selling_price'] * $row['MED_QTY']); ?></td>
                        </tr>
                    <?php 
                        endwhile;
                    } else { ?>
                        <tr>
                            <td colspan="5" class="text-center" style="color: red;">No Record Found</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
<style>
    .container {
    background:rgb(241, 246, 250);
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    margin-top: 3px;
}
</style>
</html>
