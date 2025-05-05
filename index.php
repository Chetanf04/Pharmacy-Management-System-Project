
<?php
error_reporting(1);
session_start();
include("Config.php");

if(isset($_SESSION['user_session'])){
  
  $invoice_number= invoice_number();
	header("location:mainpage.php?invoice_number=$invoice_number");
}


                 
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
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
        <nav class="header" style="width: 85%;">
            <a>MEDICURE</a><br>
            <a class="pharma_name">PHARMACY MANAGEMENT SYSTEM</a>
        </nav>
    </header>


  <div class="container" id="container">
    <!--Sign Up-->
      <div class="form sign-up-container">
        <form method="post" action="">
          <h1>LOGIN</h1>

          <!--icons-->
          <div class="social-container">
            <a href="#" class="social"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#" class="social"><i class="fa fa-google-plus" aria-hidden="true"></i> </a>
            <a href="#" class="social"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
          </div>

          <span>Use Pharmacist Account</span>

          <div class="input-field">
            <i class="fa fa-user"></i>
            <input type="text" id="uname1" name="uname1" placeholder="Username">
          </div>

          <div class="input-field">
            <i class="fa fa-lock"></i>
            <input type="password" id="pwd1" name="pwd1" placeholder="Password">
          </div>

          <a href="Pharma_Forgetpassword.php">Forgot Your Password</a>
          <button name="submit1" id="submit1">Sign In</button>

        </form>
      </div>

   <!--Sign Up-->
   <?php
   
include "Config.php";  // **Ensure Config.php has DB Connection**

function invoice_number() {  
    $chars = "09302909209300923";  
    srand((double)microtime() * 1000000);  
    $i = 1;  
    $pass = '';  

    while ($i <= 7) {  
        $num  = rand() % 10;  
        $tmp  = substr($chars, $num, 1);  
        $pass = $pass . $tmp;  
        $i++;  
    }  
    return  $pass;  
}

if (isset($_POST['submit1'])) {
  $uname1 = mysqli_real_escape_string($conn, $_POST['uname1']);
  $password1 = mysqli_real_escape_string($conn, $_POST['pwd1']);

  if ($uname1 != "" && $password1 != "") {
      // 🔄 Check E_USERNAME OR E_PHNO
      $sql = "SELECT E_ID, E_PASS, E_PHNO, E_USERNAME FROM emplogin 
              WHERE E_USERNAME='$uname1' OR E_PHNO='$uname1'";
      
      $result = $conn->query($sql);

      // ✅ Check for SQL Query Error
      if (!$result) {
          die("Error in Query: " . mysqli_error($conn)); 
      }

      $row = $result->fetch_assoc();

      // ✅ Check if Password Matches
      if ($row && $password1 === $row['E_PASS']) {  
          $_SESSION['user_session'] = $row['E_ID'];
          $_SESSION['employee_name'] = $row['E_USERNAME'];  
          $invoice_number = "CA-" . invoice_number();  
          header("location:Pharma_mainpage.php?invoice_number=$invoice_number");
          exit;
      } else {
          echo "<p style='color:red;'>Invalid username, phone number, or password!</p>";
      }
  }
}
?>



   <!--Sign In-->
      <div class="form sign-in-container">
        <form method="post" action="">
          <h1>LOGIN</h1>

          <!--icons-->
          <div class="social-container">
            <a href="#" class="social"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
            <a href="#" class="social"><i class="fa fa-google-plus" aria-hidden="true"></i> </a>
            <a href="#" class="social"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
          </div>

          <span>Use Admin Account</span>

          <!--Input Field-->

          <div class="input-field" >
            <i class="fa fa-user"></i>
            <input type="text" id="uname" name="uname" placeholder="Username">
          </div>

          <div class="input-field">
            <i class="fa fa-lock"></i>
            <input type="password" id="pwd" name="pwd" placeholder="Password">
          </div>

          <a style="color: blue;" href="Admin_Foregetpassword.php">Forgot Your Password</a>
          <button name="submit" id="submit">Sign In</button>
        </form>
      </div>
   <!--Sign In-->

   
   <?php

include "Config.php";  // Ensure Config.php has DB Connection

if (isset($_POST['submit'])) {
    $uname = $_POST['uname'];
    $password = $_POST['pwd'];

    if ($uname != "" && $password != "") {
        // Use Prepared Statement
        $sql = "SELECT * FROM admin WHERE A_USERNAME=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Verify plain text password
        if ($row && $password === $row['A_PASSWORD']) {  
          $_SESSION['user_session'] = (string) $row['ID']; // ✅ Using String Casting
            $_SESSION['admin_name'] = $row['A_USERNAME'];  
            $invoice_number = "CA-" . invoice_number(); // Ensure this function exists
            header("location:mainpage.php?invoice_number=$invoice_number");
            exit;
        } else {
            echo "<p style='color:red;'>Invalid username or password!</p>";
        }
    }

}
?>


   <!--overlay-->

    <div class="overlay-container">
      <div class="overlay">
       <div class="overlay-panel overlay-left">
        <h1>ADMIN..!</h1>
         <p>Enter Admin Personal Information & Use Admin Panel :</p>
         <img src="s1.png" style="height: 25rem; width: 30rem; padding-top: 5%;">
         <button class="btn" id="signIn">ADMIN LOGIN</button>
        </div>
 
       <div class="overlay-panel overlay-right">
        <h1>PHARMACIST..!</h1>
        <p>Enter Pharmacist Personal Information & Use Pharmacist Panel :</p>
         <img src="s3.png" style="height: 25rem; width: 30rem;">
         <button class="btn" id="signUp">PHARMACIST LOGIN</button>
        </div>
      </div>
    </div>
  </div>


  <script>

    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.querySelector('.container');

    signUpButton.addEventListener('click', () => {
      container.classList.add('right-panel-active');
    });

    signInButton.addEventListener('click', () => {
      container.classList.remove('right-panel-active');
    });
  </script>

</body>
<style>
  .container-background{
    background-image: url(Pharmacy_background.jpg);
  }
  </style>
</html>