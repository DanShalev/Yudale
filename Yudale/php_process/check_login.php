<?php
include "../includes/php_process/db_connect.php";
/* INCLUDE php functions */ include "../includes/php_process/php_functions.php";

//----------------------PROCESS FORM DATA--------------------------------
//PROCESS FORM DATA
$username=$_POST['field_username'];
$password=$_POST['field_password'];

//PROTECT SQL INJECTION (CLEAR DATA BEFORE SQL SCRIPT)
$username=check_data($username, $con);
$password=check_data($password, $con);

//ENCRYPT PASSWORD USING md5()
$password = md5($password);

//----------------------SQL SCRIPT--------------------------------
$sql ="SELECT * FROM users where User='$username'
and Password='$password'";
$result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));

//CHECKS LOGIN DETAILS VIA DATABASE
$count=mysqli_num_rows($result);

if($count==1){
    setcookie("yudaleMobile", md5("yudale".$username), time()+60*60*24*30, "/");
    header("location:../debts/debts.php");
} else {
    session_start();
    $_SESSION['WrongPassword']=true;
    header("location:../login.php");
}

mysqli_close($con);
?>