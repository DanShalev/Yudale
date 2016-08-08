<?php /*VALIDATION REQUIRED PAGE*/
/* INCLUDE php functions */ include "../includes/php_process/php_functions.php";
/* INCLUDE validate_user */ include "php_process/validate_user.php"; //REDIRECT IF THERES NO COOKIE
?>

<!DOCTYPE html>
<html>
<head>
    <title>Yudale</title>
    <?php include "../includes/headers.php";?>
    <script>
        <?php /*INCLUDE FULLSCREEN SCRIPT*/ include "../includes/scripts/fullscreen_script.js";?>
        <?php /*INCLUDE EDIT DEBT VALIDATE SCRIPT*/ include "php_process/edit_debt_validate.js"; ?>
        $( document ).ready(function() {
            $("#edit_debt_div").hide();
            $("#edit_button").click(function(){
                $("#edit_debt_div").toggle();
            });
        });
        /*var today2 = new Date();
        alert(today2);
        alert("<?php echo date('m/d/Y h:i:s a', time());?>");*/
    </script>
    <style>
        /*PROLOAD ERROR BUTTON TO BACKGROUND*/
        #edit_debt_div { background: url(style/buttons/validate/error.png) no-repeat -9999px -9999px; }
       /*BUTTONS CSS*/
        div#delete_button.ui-btn,
        div#confirm_button_div.ui-btn,
        a#edit_button.ui-btn
        {
            margin-right: 3px;
            padding-left: 35px;
            padding-right:5px;
        }
        .ui-icon-delete {
            padding-left: 33px;
            padding-right: 4px;
        }
    </style>
</head>

<body>
<?php
/****************CHECK DEBTS VIA DB**************************/
if(!isset($con))
    include "../includes/php_process/db_connect.php";
if (!isset($_GET['id']))
    die("<script>alert('ACCESS DENIED');</script>");
//SQL SCRIPT - VALIDATE DEBT ACCESS
$sql ="SELECT * FROM debts where PID='".$_GET['id']."'";
$result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));
    //ASSIGN RESULTS TO ARRAY
    $data = mysqli_fetch_array($result); //DATA = ROW OF DEBT DATA
    //CHECKS IF DEBT RELATED TO USER (DEFENDS EXPLOITING GET METHOD)
    if ($data['User'] != $_SESSION['username'] && $data['Owe_To'] != $_SESSION['username'])
        die("<script>alert('ACCESS DENIED');</script>");
//SQL SCRIPT - GET OTHER USER DETAILS
if ($data['User'] == $_SESSION['username'])
    $sql2 ="SELECT * FROM users where User='".$data['Owe_To']."'";
else
    $sql2 ="SELECT * FROM users where User='".$data['User']."'";

$result2 = mysqli_query($con, $sql2) or die("ERROR: ".mysqli_error($con));
$data2 = mysqli_fetch_array($result2);
    //GET NAME IN CASE DEBT->Other
    if ($data2['User']=='other')
        $sql_name = $data['Other_Name']; //Other name is in DEBTS table
    else
        $sql_name = $data2['Name']; //Members name are in USERS table

//CHECKS IF DEBT RELATED TO USER (IF USER HAD DELETED DEBT) (DEFENDS EXPLOITING GET METHOD)
if ( ($data['User'] == $_SESSION['username'] && $data['Hide_User'] == 1)
    || ($data['User'] != $_SESSION['username']) && $data['Hide_Owner'] == 1)
    die("<script>alert('ACCESS DENIED');</script>");
/****************PRINT EDIT DEBT SCREEN - DEBT HEADER**************************/ ?>
<div data-role="page" id="debt1">
    <?php /*INCLUDE HEADER*/ include "debts_includes/jqm_editD_header.php";?>
    <?php /*INCLUDE MEMBERS PANEL*/ include "debts_includes/panel_dmembers.php";?>
    <div data-role="content">
        <span style="font-weight:bold; font-size: 20px">Edit debt</span><br>

        <ul data-role="listview" data-inset="true">
            <li data-icon="false">
                <img src="<?php echo $base_href."users/pictures/".$data2['Image URL']; ?>">
                <img src="<?php
                echo $base_href."style/buttons/debts_status/";
                //CHECKS DEBT STATUS
                if ($data['User'] == $_SESSION['username']) //User gave money to other
                {
                    if($data['Hide_Owner']==1)
                        echo "declined.gif";
                    else if ($data['Verified_User']==1 && $data['Verified_Owner']==1)
                        echo "confirmed.gif";
                    else if ($data['Verified_User']==0 && $data['Verified_Owner']==1)
                        echo "pending_me.gif";
                    else if ($data['Verified_User']==1 && $data['Verified_Owner']==0)
                        echo "pending_user.gif";
                } else /*Other gave money to user*/ {
                    if($data['Hide_User']==1)
                        echo "declined.gif";
                    else if ($data['Verified_User']==1 && $data['Verified_Owner']==1)
                        echo "confirmed.gif";
                    else if ($data['Verified_User']==1 && $data['Verified_Owner']==0)
                        echo "pending_me.gif";
                    else if ($data['Verified_User']==0 && $data['Verified_Owner']==1)
                        echo "pending_user.gif";
                } ?>" class="debt_status">

                <h2><?php echo $sql_name;?></h2>
                <p><strong><?php echo $data['Amount'];?></strong><?php
                    echo $data['Currency'];
                    if ($data['Comment']!='') //IF COMMENT IS EMPTY, DELETE (,)
                        echo ",&nbsp;".$data['Comment']; ?>
                <p class="ui-li-aside" id="debtSummary_date"><?php echo $data['Date'];?></p>
            </li>
        </ul>
<?php /****************PRINT EDIT TEXT**************************/
    //////////////////////IN CASE OF DELETED DEBT
    if ($data['Hide_Owner'] == 1 || $data['Hide_User'] == 1)
    {
    echo "<span style='font-weight:bold; font-size: 20px; color: red;'>";
    echo $data2['Name']." has deleted the debt.</span><br>";
    echo "<br><strong>What would you like to do?</strong><br>"; ?>
       <script>
           $(document).ready(function() {
               //DISABLE CONFIRM BUTTON
               /*$("#confirm_button_div").attr("class", function(i,origText) {
                   return origText + " ui-state-disabled";
               });*/ //DISABLE CONFIRM BUTTON
               $("#confirm_button_div").hide(); //HIDE CONFIRM BUTTON
               document.getElementById("edit_button").innerText='Resend';
               document.getElementById("submit_editDebt").innerText='Resend';
           });
       </script>
    <?php
        $_SESSION['resend_debt'] = true;
    }
    //////////////////////IN CASE OF RESENDED DEBT
    else if (($data['del_user'] == 1 && $data['User'] == $_SESSION['username'])
        || ($data['del_owner'] == 1 && $data['Owe_To'] == $_SESSION['username']))
    {
    echo "<span style='font-weight:bold; font-size: 20px; color: red;'>";
    echo $data2['Name']." resend a debt you have deleted.</span><br>";
    echo "<br>He might have edited debt details. For more information check the log-file.<br>";
    echo "You probably have some unresolved issues. ";
    echo "Maybe you should give him a call?<br><br>";
    echo "<strong>What would you like to do?</strong><br>";
    //$_SESSION['resend_debt'] = true;
    }
    else {
    //////////////////////NORMAL EDITING BUTTONS
    if (($data['User'] == $_SESSION['username'] && $data['Verified_User'] == 1)
         || ($data['User'] != $_SESSION['username'] && $data['Verified_Owner'] == 1))
    {   ////DISABLE CONFIRM BUTTONS ?>
        <script>
            $(document).ready(function() {
                //DISABLE CONFIRM BUTTON
                $("#confirm_button_div").attr("class", function(i,origText) {
                    return origText + " ui-state-disabled";
                });
            });
        </script>
        <?php
    }
        ////IF EDITED MESSAGE
    if (($data['User'] == $_SESSION['username'])&&($data['edit_user']==1)
        || ($data['Owe_To'] == $_SESSION['username'])&&($data['edit_owner']==1))
    { ?>
        <span style='font-weight:bold; font-size: 20px; color: green;'>
        <?php echo $data2['Name']?> has edited the debt.</span><br>
        <br><span style='font-size: 20px; font-weight: bold;'>Previous debt details:<br></span>

        <ul data-role="listview" data-inset="true" data-theme="f">
            <li data-icon="false">
                <img src="<?php echo $base_href."users/pictures/".$data2['Image URL']; ?>">

                <h2><?php echo $sql_name;?></h2>
                <p><strong><?php echo $data['Old_Amount'];?></strong><?php
                    echo $data['Old_Currency'];
                    if ($data['Old_Comment']!='') //IF COMMENT IS EMPTY, DELETE (,)
                        echo ",&nbsp;".$data['Old_Comment']; ?>
                <p class="ui-li-aside" id="debtSummary_date"><?php echo $data['Old_Date'];?></p>
            </li>
        </ul>

        <span style='font-size: 15px;'>Edit number: <strong><?php echo $data['Edit_Num']?></strong></span><br>
        <br>For more information check the log-file.<br>
    <?php }
        }

       /****************PRINT BUTTONS **************************/ ?>
        <form method="post" action="debts/php_process/process_confirm_debt.php" data-ajax="false">
            <div id="confirm_button_div" class="ui-input-btn ui-btn ui-btn-d ui-btn-inline ui-corner-all ui-icon-check ui-btn-icon-left">
                Confirm
                <input name="confirm_button" type="submit" data-enhanced="true" value="<?php echo $_GET['id'] ?>">
            </div>
        </form>
        <a href="#" id="edit_button" class="ui-btn ui-btn-e ui-btn-inline ui-corner-all ui-icon-edit ui-btn-icon-left">Edit</a>
        <form method="post" action="debts/php_process/process_delete_debt.php" data-ajax="false">
            <div id="delete_button" class="ui-input-btn ui-btn ui-btn-c ui-btn-inline ui-corner-all ui-icon-delete ui-btn-icon-left">
                Delete
                <input name="delete_button" type="submit" data-enhanced="true" value="<?php echo $_GET['id'] ?>">
            </div>
        </form>

<?php
/****************PRINT EDIT FIELDS**************************/
/***********************************************************/?>
        <div id="edit_debt_div">
            <form id="edit_debt_form" name="edit_debt_form" method="post"  action="debts/php_process/process_edit_debt.php"
                  data-ajax="false" onsubmit="return validateForm()">
                <ul data-role="listview" data-inset="true" data-theme="b">
                    <?php //LIST DIVIDER ?>
                    <li data-role="list-divider" data-theme="a">
                        <span style="font-weight: bold; font-size: 18px">Debt details</span>
                    </li>
                    <?php //AMOUNT ?>
                    <li class="ui-field-contain">
                        <label for="editDebt_amount_field">Amount:</label>
                        <input type="tel" name="editDebt_amount_field" id="editDebt_amount_field" value="<?php echo $data['Amount']?>" data-theme="a" placeholder="Amount">
                    </li>
                    <?php //CURRENCY ?>
                    <li class="ui-field-contain" style="font-size: 20px">
                        <fieldset data-role="controlgroup" data-type="horizontal">
                            <legend>Curency:</legend>
                            <label id="currency1_editDebt" for="nis">₪</label>
                            <input type="radio" name="editDebt_currencySelect_field" id="nis" value="₪" data-theme="a"
                                <?php if ($data['Currency']== '₪') echo "checked='checked'"?>>
                            <label id="currency2_editDebt" for="dollar">$</label>
                            <input type="radio" name="editDebt_currencySelect_field" id="dollar" value="$" data-theme="a"
                                <?php if ($data['Currency']== '$') echo "checked='checked'"?>>
                            <label id="currency3_editDebt" for="euro">€</label>
                            <input type="radio" name="editDebt_currencySelect_field" id="euro" value="€" data-theme="a"
                                <?php if ($data['Currency']== '€') echo "checked='checked'"?>>
                            <label id="currency4_editDebt" for="other_radioBtn">Other</label>
                            <input type="radio" name="editDebt_currencySelect_field" id="other_radioBtn" value="Other" data-theme="a"
                                <?php if ($data['Currency']== 'Other') echo "checked='checked'"?>>
                        </fieldset>
                    </li>
                    <?php //DATE ?>
                    <li class="ui-field-contain">
                        <label for="editDebt_date_field">Date:</label>
                        <input type="date" name="editDebt_date_field" id="editDebt_date_field" value="<?php
                        /*CHANGE DATE FORMAT FOR DISPLAY*/
                            //Replace day.month.year to year-month-day
                        list($day, $month, $year) = explode(".", $data['Date']);
                        $data['Date'] = "$year-$month-$day";
                        echo $data['Date'];
                        ?>" data-theme="a" placeholder="Date">
                    </li>
                    <?php //DETAILS ?>
                    <li class="ui-field-contain">
                        <label for="editDebt_details_field">Details:</label>
                        <input type="text" name="editDebt_details_field" id="editDebt_details_field" value="<?php echo $data['Comment'];?>" data-theme="a" placeholder="Details">
                    </li>
                </ul>

                <span id="error_msg_editDebt" style="color: #dd4b39; margin-bottom: 20px"></span>
                <label for="submit_editDebt"></label>
                <button type="submit" name="submit_edit_button" id="submit_editDebt" class="ui-shadow ui-btn ui-corner-all ui-mini"
                    value="<?php echo $_GET['id'] ?>">Submit</button>
            </form>
        </div>

    </div>
</div>
</body>
</html>