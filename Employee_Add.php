<?php
include "Config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escaping inputs for security
    $id = mysqli_real_escape_string($conn, $_POST['eid']);
    $fname = mysqli_real_escape_string($conn, $_POST['efname']);
    $lname = mysqli_real_escape_string($conn, $_POST['elname']);
    $bdate = mysqli_real_escape_string($conn, $_POST['ebdate']);
    $age = mysqli_real_escape_string($conn, $_POST['eage']);
    $sex = mysqli_real_escape_string($conn, $_POST['esex']);
    $etype = mysqli_real_escape_string($conn, $_POST['etype']);
    $jdate = mysqli_real_escape_string($conn, $_POST['ejdate']);
    $sal = mysqli_real_escape_string($conn, $_POST['esal']);
    $phno = mysqli_real_escape_string($conn, $_POST['ephno']);
    $mail = mysqli_real_escape_string($conn, $_POST['e_mail']);
    $epass = mysqli_real_escape_string($conn, $_POST['e_pass']);

    // 1️⃣ Insert into employee table
    $sql_employee = "INSERT INTO employee (E_ID, E_FNAME, E_LNAME, BDATE, E_AGE, E_SEX, E_TYPE, E_JDATE, E_SAL, E_PHNO, E_MAIL)
                     VALUES ($id, '$fname', '$lname', '$bdate', $age, '$sex', '$etype', '$jdate', $sal, '$phno', '$mail')";

    if (mysqli_query($conn, $sql_employee)) {
        echo "✅ Employee added successfully!\n";

        // 2️⃣ Insert into emplogin table
        $sql_login = "INSERT INTO emplogin (E_ID, E_USERNAME, E_PHNO, E_PASS)
                      VALUES ($id, '$fname', '$phno', '$epass')";

        if (mysqli_query($conn, $sql_login)) {
            echo "✅ Employee login created successfully!";
        } else {
            echo "❌ Error in emplogin table: " . mysqli_error($conn);
        }

    } else {
        echo "❌ Error in employee table: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
