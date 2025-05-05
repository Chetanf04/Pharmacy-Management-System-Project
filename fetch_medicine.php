<?php
include("Config2.php");

if (isset($_POST['bar_code'])) {
    $barcode = mysqli_real_escape_string($con, $_POST['bar_code']);

    $query = "SELECT MED_NAME FROM meds WHERE MED_ID = '$barcode'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['MED_NAME']; // Sends back Medicine Name
    } else {
        echo "No Medicine";
    }
}
?>
