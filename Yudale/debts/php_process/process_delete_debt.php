<?php
/* INCLUDE php functions */ include "../../includes/php_process/php_functions.php";

if(!isset($con))
    include "../../includes/php_process/db_connect.php";

//PROCESS FORM DATA
$pid=$_POST['delete_button']; //DELETE BUTTON VALUE = PID

//CONNECT TO DB $ GET PID(DEBT) DATA
$sql ="SELECT * FROM debts where PID='".$pid."'";
$result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));
$data = mysqli_fetch_array($result);
$Hide_User = $data['Hide_User'];
$Hide_Owner = $data['Hide_Owner'];

//CHECKS WHO GAVE MONEY TO WHO
if ($data['User'] == $_SESSION['username']) //User gave money to other
{
    $new_Hide_User = 1;
    $new_Hide_Owner = $data['Hide_Owner'];

    $Verified_User = 1;
    $Verified_Owner = 0;
}
else //Other gave money to user
{
    $new_Hide_Owner = 1;
    $new_Hide_User = $data['Hide_User'];

    $Verified_User = 0;
    $Verified_Owner = 1;
}

//CHECKS IF SHOULD DELETE OR JUST HIDE
if (($new_Hide_Owner == 1 && $new_Hide_User == 1)|| $data['User']=='other' || $data['Owe_To']=='other')
    $sql ="DELETE FROM debts where PID='$pid'";
else
    $sql ="UPDATE debts SET Verified_User='$Verified_User', Verified_Owner='$Verified_Owner', Hide_User='$new_Hide_User', Hide_Owner='$new_Hide_Owner'
           WHERE PID ='$pid'";

//  SQL SCRIPT
mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));


//PRINT TO LOGFILE
if ($data['User'] == 'other')
    $lf_user = $data['Other_Name'];
else
    $lf_user = $data['User'];

if ($data['Owe_To'] == 'other')
    $lf_oweTo = $data['Other_Name'];
else
    $lf_oweTo = $data['Owe_To'];

printLogfile($data['User'], $_SESSION['username'], "delete", $lf_user, $lf_oweTo,
    $data['Amount'], $data['Currency'], $data['Date'], $data['Comment'],
    "null", "null", "null", "null");
printLogfile($data['Owe_To'], $_SESSION['username'], "delete", $lf_user, $lf_oweTo,
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