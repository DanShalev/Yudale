<?php
/* INCLUDE php functions */ include "../../includes/php_process/php_functions.php";

if(!isset($con))
    include "../../includes/php_process/db_connect.php";

//PROCESS FORM DATA
$amount=$_POST['editDebt_amount_field'];
$currency = $_POST['editDebt_currencySelect_field'];
$date = $_POST['editDebt_date_field'];
$details = $_POST['editDebt_details_field'];
$pid = $_POST['submit_edit_button'];

//PROTECT SQL INJECTION
$amount=check_data($amount, $con);
$currency=check_data($currency, $con);
$date=check_data($date, $con);
$details=check_data($details, $con);
$pid=check_data($pid, $con);

/*CHANGE DATE FORMAT BACK FOR STORAGE*/
// Replace year-month-day to day.month.year
list($year, $month, $day) = explode("-", $date);
$date = "$day.$month.$year";

    //GET DATA BEFORE EDITING (FOT LATER INSERT AS OLD DATA)
    $sql ="SELECT * FROM debts where PID='".$pid."'";
    $result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));
    $oldData = mysqli_fetch_array($result);

    $old_amount = $oldData['Amount'];
    $old_currency = $oldData['Currency'];
    $old_date = $oldData['Date'];
    $old_comment = $oldData['Comment'];
    $edit_num = $oldData['Edit_Num'];
    //EDIT NUM++
    $edit_num++;

//CHECKS WHO GAVE MONEY TO WHO
if ($oldData['User']=='other' || $oldData['Owe_To']=='other') //VERIFIED OTHER
{
    $Verified_User = 1;
    $Verified_Owner = 1;
    $del_user = 0;
    $del_owner = 0;
}
else if ($oldData['User'] == $_SESSION['username']) //User gave money to other
{
    $Verified_User = 1;
    $Verified_Owner = 0;
    $del_user = 0;
    $del_owner = 1; //SHOWS OWNER A DELETE MESSAGE (RESENDED DEBT)
}
else //Other gave money to user
{
    $Verified_User = 0;
    $Verified_Owner = 1;
    $del_user = 1; //SHOWS USER A DELETE MESSAGE (RESENDED DEBT)
    $del_owner = 0;
}

//SQL SCRIPT
$sql ="UPDATE debts SET Amount='$amount', Currency='$currency',
       Date='$date', Comment='$details', Old_Amount='$old_amount',
       Old_Currency='$old_currency', Old_Date='$old_date', Old_Comment='$old_comment',
       Edit_Num = '$edit_num',Verified_User = '$Verified_User', Verified_Owner = '$Verified_Owner'";

//CHANGE EDIT COLUMN
if ($oldData['User'] == $_SESSION['username']) //User gave money to other
    $sql = $sql.", edit_user = '0', edit_owner ='1'";
else //Other gave money to user
    $sql = $sql.", edit_user = '1', edit_owner ='0'";

//IF RE_EDITED - DELETE Hide_User/Owner & INFORM HIM.
$lf_action = "edit";
if(isset($_SESSION['resend_debt'])) {
    $sql = $sql.", Hide_User = '0', Hide_Owner ='0', del_user = '$del_user', del_owner = '$del_owner' ";
    $lf_action = "resend";

}
$sql = $sql." WHERE PID ='$pid'";
mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));



//PRINT TO LOGFILE
if ($oldData['User'] == 'other')
    $lf_user = $oldData['Other_Name'];
else
    $lf_user = $oldData['User'];

if ($oldData['Owe_To'] == 'other')
    $lf_oweTo = $oldData['Other_Name'];
else
    $lf_oweTo = $oldData['Owe_To'];

printLogfile($oldData['User'], $_SESSION['username'], $lf_action, $lf_user, $lf_oweTo,
    $amount, $currency, $date, $details,
    $old_amount, $old_currency, $old_date, $old_comment);

printLogfile($oldData['Owe_To'], $_SESSION['username'], $lf_action, $lf_user, $lf_oweTo,
    $amount, $currency, $date, $details,
    $old_amount, $old_currency, $old_date, $old_comment);

//CLOSE SQL CONNECTION
mysqli_close($con);
unset($con);
if(isset($_SESSION['resend_debt']))
    unset($_SESSION['resend_debt']);

//REDIRECT PAGE
if ($oldData['User'] == $_SESSION['username'])
    header("location:../debts2.php");
else
    header("location:../debts.php");
?>