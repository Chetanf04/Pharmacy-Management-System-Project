

<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $newpassword = md5($_POST['newpassword']);
    $sql = "SELECT Email FROM tbladmin WHERE Email=:email and MobileNumber=:mobile";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        $con = "UPDATE tbladmin SET Password=:newpassword WHERE Email=:email and MobileNumber=:mobile";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();
        echo "<script>alert('Your Password was successfully changed');</script>";
    } else {
        echo "<script>alert('Email ID or Mobile No is invalid');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacist Forgot Password</title>
    <link rel="stylesheet" href="mainpage.css">

    <!--Library-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--Google Font-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


</head>
<body class="container-background">
    <header class="header">
        <a href class="logo">
            <img src="Medicure_logo.png" alt="Medicure Logo">
        </a>
        <nav class="header" style="width: 90%;">
            <a>MEDICURE</a><br>
            <a class="pharma_name" style="text-decoration: none;">PHARMACY MANAGEMENT SYSTEM</a>
        </nav>
    </header>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <script type="text/javascript">
        function valid() {
            if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                alert("New Password and Confirm Password do not match!!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>

<body>
<div class="row">
            
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Reset Pharmacist Password</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" name="chngpwd" onSubmit="return valid();">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-Mail" name="email" required="true" type="email">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Mobile Number" name="mobile" maxlength="10" pattern="[0-9]+" required="true" type="text">
                                </div>
                                <div class="form-group">
                                   
                                    <input class="form-control" type="password" placeholder="New Password"  name="newpassword" required="true">
                                </div>
                                <div class="form-group">
                                   <input class="form-control" type="password" placeholder="Confirm Password"  name="confirmpassword" required="true">
                                </div>
                                <div class="checkbox">
                                    

<label>
    <a href="index.php">Already have an account</a></label>
                                </div>

                                <!-- Change this to a button or input when using this as a form -->
                               
                                <input type="submit" value="submit" class="btn btn-lg btn-success btn-block" name="submit" >
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</body>
<style>
  .container-background{
    background-image: url(Pharmacy_background.jpg);
  }
  /* General Styles */
body {
    background: linear-gradient(to right, #1E3C72, #2A5298);
    font-family: 'Poppins', sans-serif;
    color: black;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Centering the Form */
.row {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Title Styling */
.logo-margin strong {
    display: block;
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
    letter-spacing: 1px;
    color: #ffffff;
    font-size: 28px;
}

/* Panel Styling */
.login-panel {
    background: #f9f9f9;
    padding: 45px;
    border-radius: 15px;
    box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.4);
    width: 550px;
    text-align: center;
    color: #222;
}

.panel-heading {
    background: #333;
    color: white;
    padding: 18px;
    font-size: 24px;
    font-weight: bold;
    border-radius: 15px 15px 0 0;
    box-shadow: inset 0px -4px 10px rgba(0, 0, 0, 0.2);
}

/* Input Fields */
.form-group input {
    width: 100%;
    padding: 10px 25px;
    margin: 14px 0;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: 0.3s ease-in-out;
}

.form-group input:focus {
    border-color: #333;
    outline: none;
    box-shadow: 0px 0px 12px rgba(255, 102, 0, 0.5);
}

/* Submit Button */
.btn-success {
    background: green;
    border: none;
    padding: 10px;
    font-size: 18px;
    cursor: pointer;
    border-radius: 10px;
    transition: 0.3s;
    width: 100%;
    font-weight: bold;
}

.btn-success:hover {
    background: #333;
}

/* Links */
.checkbox a {
    color: blue;
    text-decoration:line;
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 10px;
}

.checkbox a:hover {
    text-decoration: underline;
}
  </style>
</html>
