<?php
/* INCLUDE php functions */ include "../../includes/php_process/php_functions.php";

if(!isset($con))
    include "../../includes/php_process/db_connect.php";

//PROCESS FORM DATA
$pid = $_POST['confirm_button'];

//CONNECT TO DB & GET PID(DEBT) DATA
$sql ="SELECT * FROM debts where PID='".$pid."'";
$result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));
$data = mysqli_fetch_array($result);

$Verified_User = $data['Verified_User'];
$Verified_Owner = $data['Verified_Owner'];
$edit_user = 0;
$edit_owner = 0;


//CHECKS WHO GAVE MONEY TO WHO
if ($data['User'] == $_SESSION['username']) //User gave money to other
{
    $Verified_User = 1;
    $edit_user = 0;
} else //Other gave money to user
{
    $Verified_Owner = 1;
    $edit_owner = 0;
}
//SQL SCRIPT
$sql ="UPDATE debts SET Verified_User = '$Verified_User',
       Verified_Owner = '$Verified_Owner', edit_user='$edit_user', edit_owner='$edit_owner'
       WHERE PID ='$pid'";

mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));


//PRINT TO LOGFILE
printLogfile($data['User'], $_SESSION['username'], "confirm", $data['User'], $data['Owe_To'],
    $data['Amount'], $data['Currency'], $data['Date'], $data['Comment'],
    "null", "null", "null", "null");
printLogfile($data['Owe_To'], $_SESSION['username'], "confirm", $data['User'], $data['Owe_To'],
    $data['Amount'], $data['Currency'], $data['Date'], $data['Comment'],
    "null", "null", "null", "null");


//CLOSE SQL CONNECTION
mysqli_close($con);
unset($con);

//REDIRECT PAGE
if ($data['User'] == $_SESSION['username'])
    header("location:../debts2.php");
else
    header("location:../debts.php");
?>