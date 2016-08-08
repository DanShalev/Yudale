<?php /*VALIDATION REQUIRED PAGE*/
/* INCLUDE php functions */ include "includes/php_process/php_functions.php";
/* INCLUDE validate_user */ include "php_process/validate_user.php"; //REDIRECT IF THERES NO COOKIE
?>

<!DOCTYPE html>
<html>
<head>
    <title>Yudale</title>
    <?php include "includes/headers.php";?>
    <script>
        <?php
        /*INCLUDE FULLSCREEN SCRIPT*/ include "includes/scripts/fullscreen_script.js";
        ?>
    </script>
    <style>
        /*PROLOAD ERROR BUTTON TO BACKGROUND*/
        #account_settings_box { background: url(style/buttons/validate/error.png) no-repeat -9999px -9999px; }
    </style>
</head>

<body>
<div data-role="page" id="login">
    <script>
        <?php /***INCLUDE SCRIPT***/
    //INCLUDE ACCOUNT SETTINGS VALIDATE SCRIPT
    echo "var wrong_currPassword = false;";
    echo "var passwordChanged = false;";
    if (isset($_SESSION['WrongCurrPass']) && $_SESSION['WrongCurrPass']==true)
        echo "wrong_currPassword = true;";
    if (isset($_SESSION['passwordChanged']) && $_SESSION['passwordChanged']==true)
        echo "passwordChanged = true;";
    $_SESSION['WrongCurrPass']=false;
    $_SESSION['passwordChanged']=false;

    include "php_process/account_settings_validate.js"; ?>
    </script>
    <?php /*INCLUDE MEMBERS PANEL*/ include "includes/panel_members.php";?>
    <?php /*INCLUDE HEADER*/ include "includes/jqm_header.php";?>
    <div data-role="content">
        <span style="font-weight:
        bold; font-size: 20px">Account settings</span><br>
        <div id="account_settings_box">
            <span style="font-weight: bold; font-size: 18px">Change Password</span>
            <form id="account_settings_form" name="account_settings_form" method="post"  action="php_process/process_account_details.php"
             onsubmit="return validateForm()" data-ajax="false">

                <div class="ui-field-contain">
                    <label for="field_currPassword">Current password:</label>
                    <input type="password" name="field_currPassword" id="field_currPassword" autocomplete="off" placeholder="Current password" value="" data-clear-btn="true" data-theme="a">
                </div>
                <div class="ui-field-contain">
                  <label for="field_newPassword">New password:</label>
                  <input type="password" name="field_newPassword" id="field_newPassword" value="" autocomplete="off" placeholder="New password" data-clear-btn="true" data-theme="a">
                </div>
                <div class="ui-field-contain">
                    <label for="field_newPassword2">Retype new password:</label>
                    <input type="password" name="field_newPassword2" id="field_newPassword2" value="" autocomplete="off" placeholder="Retype new password" data-clear-btn="true" data-theme="a">
                </div>

                <label for="submit_login"></label>
                <button type="submit" id="submit_login" class="ui-shadow ui-btn ui-corner-all ui-mini">Submit</button>
            </form>

            <span id="error_msg" style="color: #dd4b39;"></span>
        </div>

        More details will be editable in future versions.
</div>

    <div data-role="popup" id="successPopup" data-overlay-theme="b" data-theme="b" data-dismissible="false" style="max-width:370px;">
        <div data-role="header" data-theme="a">
            <h1>Account Settings</h1>
        </div>
        <div role="main" class="ui-content">
            <img src="style/buttons/validate/success.png" alt="success_icon" class="success_icon">
            <span style="color: green; font-weight: bold;">Account settings successfully changed</span>
            <div style="text-align: center; padding-top: 10px">
                <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back">Continue</a>
            </div>
        </div>
    </div>
</body>
</html>