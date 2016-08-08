<?php
include "../includes/php_process/db_connect.php";
/* INCLUDE php functions */ include "../includes/php_process/php_functions.php";

//PROCESS FORM DATA
$currPass=$_POST['field_currPassword'];
$newPassword=$_POST['field_newPassword'];

//PROTECT SQL INJECTION
//  CLEAR DATA BEFORE SQL SCRIPT
$currPass=check_data($currPass, $con);
$newPassword=check_data($newPassword, $con);

//ENCRYPT PASSWORD USING md5()
$currPass = md5($currPass);
$newPassword = md5($newPassword);

//SQL SCRIPT
session_start();
$sql ="SELECT * FROM users WHERE User='".$_SESSION['username']."'
and Password='$currPass'";

$result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));
//CHECKS LOGIN DETAILS VIA DATABASE
$count=mysqli_num_rows($result);

if($count==1){
    //SQL CHANGE PASSWORD SCRIPT
    $sql ="UPDATE users SET Password='$newPassword' WHERE User ='".$_SESSION['username']."'";

    $result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));
    header("location:../account_settings.php");
    $_SESSION['passwordChanged']=true;
} else {
    $_SESSION['WrongCurrPass']=true;
    header("location:../account_settings.php");
}

mysqli_close($con);
?>