<?php
/* INCLUDE php functions */ include "../../includes/php_process/php_functions.php";

if(!isset($con))
    include "../../includes/php_process/db_connect.php";

//PROCESS FORM DATA
$own_who = $_POST['radio_debtOwner']; //EITHER 1(I OWE SOMEONE) OR 2 (SOMEONE OWE ME)
$user_select = $_POST['select_user'];

//FIELDS VARIABLES
$amount=$_POST['addDebt_amount_field'];
$currency = $_POST['addDebt_currencySelect_field'];
$date = $_POST['addDebt_date_field'];
$details = $_POST['addDebt_details_field'];
if (isset($_POST['addDebt_other_name_field']))
    $other_input = $_POST['addDebt_other_name_field'];

//PROTECT SQL INJECTION
$amount=check_data($amount, $con);
$currency=check_data($currency, $con);
$date=check_data($date, $con);
$details=check_data($details, $con);
if (isset($other_input))
    $other_input = check_data($other_input, $con);

/*CHANGE DATE FORMAT BACK FOR STORAGE*/
    //Replace year-month-day to day.month.year
list($year, $month, $day) = explode("-", $date);
$date = "$day.$month.$year";

//SET OWNER OF DEBT
if ($own_who == 1) //EITHER 1(I OWE SOMEONE)
{
    $user = $_SESSION['username'];
    $oweTo = $user_select;
    if (isset($other_input))
        $oweTo = 'other';

    $verified_User = 1;
    $verified_Owner = 0;
} else { //OR 2 (SOMEONE OWE ME)
    $user = $user_select;
    if (isset($other_input))
        $user = 'other';
    $oweTo = $_SESSION['username'];

    $verified_User = 0;
    $verified_Owner = 1;
}

//SQL SCRIPT
if (isset($other_input))
{
    $sql ="INSERT INTO debts (User, Owe_To,Other_Name,Amount,Currency,Date,Comment,Verified_User,Verified_Owner)
       VALUES ('$user', '$oweTo','$other_input', '$amount','$currency','$date', '$details','1','1')";
} else {
    $sql ="INSERT INTO debts (User, Owe_To,Amount,Currency,Date,Comment,Verified_User,Verified_Owner)
       VALUES ('$user', '$oweTo', '$amount','$currency','$date', '$details','$verified_User','$verified_Owner')";
}

mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));

//PRINT TO LOGFILE
$lf_user = $user;
$lf_oweTo = $oweTo;
if ($user == 'other')
    $lf_user = $other_input;
else if ($oweTo == 'other')
    $lf_oweTo = $other_input;

printLogfile($user, $_SESSION['username'], "add", $lf_user, $lf_oweTo,
    $amount, $currency, $date, $details,
    "null", "null", "null", "null");
printLogfile($oweTo, $_SESSION['username'], "add", $lf_user, $lf_oweTo,
    $amount, $currency, $date, $details,
    "null", "null", "null", "null");

//CLOSE CONNECTION
mysqli_close($con);
unset($con);

//REDIRECT PAGE
if ($user == $_SESSION['username'])
    header("location:../debts2.php");
else
    header("location:../debts.php");
?>