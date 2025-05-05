
<?php
include "Config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pid = mysqli_real_escape_string($conn, $_POST['pid']);
    $sid = mysqli_real_escape_string($conn, $_POST['sid']);
    $mid = mysqli_real_escape_string($conn, $_POST['mid']);
    $qty = mysqli_real_escape_string($conn, $_POST['pqty']);
    $cost = mysqli_real_escape_string($conn, $_POST['pcost']);
    $pdate = mysqli_real_escape_string($conn, $_POST['pdate']);
    $mdate = mysqli_real_escape_string($conn, $_POST['mdate']);
    $edate = mysqli_real_escape_string($conn, $_POST['edate']);

    $checkQuery = "SELECT * FROM purchase WHERE P_ID = $pid";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "Error! Record already exists.";
    } else {
        $sql = "INSERT INTO purchase (P_ID, SUP_ID, MED_ID, P_QTY, P_COST, PUR_DATE, MFG_DATE, EXP_DATE) 
                VALUES ($pid, $sid, $mid, '$qty', '$cost', '$pdate', '$mdate', '$edate')";

        if (mysqli_query($conn, $sql)) {
            echo "✅ Purchase added successfully!";
        } else {
            echo "Error! Check details.";
        }
    }
    $conn->close();
}
?>