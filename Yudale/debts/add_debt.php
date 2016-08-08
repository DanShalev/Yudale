<?php /*VALIDATION REQUIRED PAGE*/
/* INCLUDE php functions */ include "../includes/php_process/php_functions.php";
/* INCLUDE validate_user */ include "php_process/validate_user.php"; //REDIRECT IF THERES NO COOKIE
$file_name = "add_debt"; //FOR PANEL_MEMBERS INCLUDE
?>

<!DOCTYPE html>
<html>
<head>
    <title>Yudale</title>
    <?php include "../includes/headers.php";?>
    <script>
        <?php
        /*INCLUDE FULLSCREEN SCRIPT*/ include "../includes/scripts/fullscreen_script.js";
        /*INCLUDE ADD DEBT VALIDATE SCRIPT*/ include "php_process/add_debt_validate.js";
        ?>

        function selectOther() { //ON SELECT TRIGGERED FUNCTIONS, HIDE & SHOW otherName field
            if (document.getElementById('select_user').value == 'other')
            {
                var otherName_field =  "<li class='ui-field-contain' id='other_name_li'>" +
                  "<label for='addDebt_other_name_field'>Other name:</label>" +
                  "<input type='text' name='addDebt_other_name_field' id='addDebt_other_name_field' value='' data-theme='a' placeholder='Name' data-clear-btn='true'>" +
                  "</li>";

                  $("#select_user_li").after(otherName_field);
                  $("#other_name_li").trigger("create");
                  $('ul').listview('refresh');
            } else {
                $("#other_name_li").remove();
                $('ul').listview('refresh');
            }
        }
    </script>
    <style>
        /*PROLOAD ERROR BUTTON TO BACKGROUND*/
        #add_debt_form { background: url(style/buttons/validate/error.png) no-repeat -9999px -9999px; }
    </style>
</head>
<body>

<div data-role="page" id="login">
    <?php /*INCLUDE MEMBERS PANEL*/ include "../includes/panel_members.php";?>
    <?php /*INCLUDE HEADER*/ include "debts_includes/jqm_editD_header.php";?>

    <div data-role="content">

        <span style="font-weight:bold; font-size: 20px">Add debt</span><br>
            <form id="add_debt_form" name="add_debt_form" method="post"  action="debts/php_process/process_add_debt.php"
                  data-ajax="false" onsubmit="return validateForm()">
                <?php //=========GROUP ONE================== ?>
                <ul data-role="listview" data-inset="true" data-theme="b">
                    <?php //LIST DIVIDER ?>
                    <li data-role="list-divider" data-theme="a">
                        <span style="font-weight: bold; font-size: 18px">Debt owner</span>
                    </li>
                    <?php //SELECT HORIZONTAL DEBT OWNER ?>
                    <li class="ui-field-contain">
                        <fieldset data-role="controlgroup" data-type="horizontal">
                            <legend>Debt owner:</legend>
                            <input type="radio" name="radio_debtOwner" id="radio_owe_to_me" value="2" data-theme="a">
                            <label id="radio1_addDebt" for="radio_owe_to_me">חייבים לי</label>
                            <input type="radio" name="radio_debtOwner" id="radio_owe_to_other" value="1" data-theme="a">
                            <label id="radio2_addDebt" for="radio_owe_to_other">חייב לאחרים</label>
                        </fieldset>
                    </li>
                    <?php //SELECT VERTICAL USER ?>
                    <li class="ui-field-contain" id="select_user_li">
                        <label for="select_user" class="select">Select user:</label>
                        <select name="select_user" id="select_user" data-theme="a" onchange="selectOther()">
                            <option value="choose">Choose...</option>
                            <optgroup label="Members">
                                <?php //SQL SCRIPT
                                if(!isset($con))
                                    include "../includes/php_process/db_connect.php";
                                $sql ="SELECT Name, User FROM users";
                                $result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));
                                //ASSIGN RESULTS TO ARRAY
                                while ($row = mysqli_fetch_array($result))
                                {
                                    if ($row['User'] == $_SESSION['username'] || $row['User']=='other')
                                        continue;
                                    echo "<option value='".$row['User']."'>".$row['Name']."</option>";
                                } ?>
                            </optgroup>
                            <optgroup label="Other">
                                <option value="other">Other</option>
                            </optgroup>
                        </select>
                    </li>
                </ul>

            <?php //=========GROUP TWO================== ?>
            <ul data-role="listview" data-inset="true" data-theme="b">
                <?php //LIST DIVIDER ?>
                <li data-role="list-divider" data-theme="a">
                    <span style="font-weight: bold; font-size: 18px">Debt details</span>
                </li>
                <?php //AMOUNT ?>
                <li class="ui-field-contain">
                    <label for="addDebt_amount_field">Amount:</label>
                    <input type="tel" name="addDebt_amount_field" id="addDebt_amount_field" value="" data-theme="a" placeholder="Amount" data-clear-btn="true">
                </li>
                <?php //CURRENCY ?>
                <li class="ui-field-contain" style="font-size: 20px">
                    <fieldset data-role="controlgroup" data-type="horizontal">
                        <legend>Curency:</legend>
                        <label id="currency1_addDebt" for="nis">₪</label>
                        <input type="radio" name="addDebt_currencySelect_field" id="nis" value="₪" data-theme="a" checked="checked">
                        <label id="currency2_addDebt" for="dollar">$</label>
                        <input type="radio" name="addDebt_currencySelect_field" id="dollar" value="$" data-theme="a">
                        <label id="currency3_addDebt" for="euro">€</label>
                        <input type="radio" name="addDebt_currencySelect_field" id="euro" value="€" data-theme="a">
                        <label id="currency4_addDebt" for="other_radioBtn">Other</label>
                        <input type="radio" name="addDebt_currencySelect_field" id="other_radioBtn" value="Other" data-theme="a">
                    </fieldset>
                </li>
                <?php //DATE ?>
                <li class="ui-field-contain">
                    <label for="addDebt_date_field">Date:</label>
                    <input type="date" name="addDebt_date_field" id="addDebt_date_field" value="<?php echo date('Y-m-d'); ?>" data-theme="a" placeholder="Date">
                </li>
                <?php //DETAILS ?>
                <li class="ui-field-contain">
                    <label for="addDebt_details_field">Details:</label>
                    <input type="text" name="addDebt_details_field" id="addDebt_details_field" value="" data-theme="a" placeholder="Details" data-clear-btn="true">
                </li>
            </ul>

                <span id="error_msg_addDebt" style="color: #dd4b39; margin-bottom: 20px"></span>
                <label for="submit_addDebt"></label>
                <button type="submit" id="submit_addDebt" class="ui-shadow ui-btn ui-corner-all ui-mini
                ui-btn-icon-left ui-icon-plus">Add</button>
        </form>

    </div>
</body>
</html>