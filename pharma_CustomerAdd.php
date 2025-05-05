<?php
include "Config.php";

if (isset($_POST['cid'])) {
    $id = mysqli_real_escape_string($conn, $_POST['cid']);
    $fname = mysqli_real_escape_string($conn, $_POST['cfname']);
    $lname = mysqli_real_escape_string($conn, $_POST['clname']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $phno = mysqli_real_escape_string($conn, $_POST['phno']);
    $mail = mysqli_real_escape_string($conn, $_POST['emid']);

    $checkQuery = "SELECT * FROM customer WHERE c_id = $id";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "<script>
                document.getElementById('message').innerHTML = '<p style=\"color:red;\">Customer ID already exists!</p>';
              </script>";
    } else {
        $sql = "INSERT INTO customer VALUES ($id, '$fname', '$lname', $age, '$sex', $phno, '$mail')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    document.getElementById('message').innerHTML = '<p style=\"color:green;\">Customer successfully added!</p>';
                  </script>";
        } else {
            echo "<script>
                    document.getElementById('message').innerHTML = '<p style=\"color:red;\">Error! Check details.</p>';
                  </script>";
        }
    }
}

$conn->close();
?>
