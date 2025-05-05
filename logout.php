<?php
include('Config2');
session_start();
session_destroy(); // all session data Distroy
header("Location: mainpage.php"); // Redirect to main page
exit();
?>
