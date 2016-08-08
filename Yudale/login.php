<?php
/* INCLUDE php functions */ include "includes/php_process/php_functions.php";

//CHECKS IF ALREADY LOGGED-IN
if (isset($_COOKIE["yudaleMobile"]))
    header("location:debts/debts.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Yudale</title>
    <?php include "includes/headers.php";?>
    <?php /*ADD TO HOME SCREEN SCRIPT*/ include "includes/scripts/add_to_home_screen.php";?>
    <script>
        <?php
        /*INCLUDE FULLSCREEN SCRIPT*/ include "includes/scripts/fullscreen_script.js";
        ?>
    </script>
    <style>
        /*PROLOAD ERROR BUTTON TO BACKGROUND*/
        #login_box { background: url(style/buttons/validate/error.png) no-repeat -9999px -9999px; }
    </style>
</head>

<body>
<div data-role="page" id="login">
    <script>
        <?php /***INCLUDE SCRIPT***/
            /*INCLUDE LOGIN VALIDATE SCRIPT*/
            echo "wrong_password = false;";
            if (isset($_SESSION['WrongPassword']) && $_SESSION['WrongPassword']==true)
                echo "wrong_password = true;";
            $_SESSION['WrongPassword']=false;

            include "php_process/login_validate.js";
        ?>
    </script>
    <?php /*INCLUDE MEMBERS PANEL*/ include "includes/panel_guests.php";?>
    <?php /*INCLUDE HEADER*/ include "includes/jqm_header.php";?>
    <div data-role="content">

        <span style="font-weight:
        bold; font-size: 20px">Please, log in:</span><br>
        <div id="login_box">
            <form id="login_form" name="login_form" method="post"  action="php_process/check_login.php"
                  onsubmit="return validateForm()" data-ajax="false">
               <label for="field_username">Username:</label>
               <input type="text" name="field_username" id="field_username" placeholder="Username" value="" data-clear-btn="true" data-theme="a">

                <label for="field_password">Password:</label>
                  <input type="password" name="field_password" id="field_password" value="" autocomplete="off" placeholder="Password"  data-clear-btn="true" data-theme="a">
                 <label for="submit_login"></label>

                 <button type="submit" id="submit_login" class="ui-shadow ui-btn ui-corner-all ui-mini">Submit</button>
            </form>

        <span id="error_msg_login" style="color: #dd4b39;"></span>
        </div>

        In order to gain access to the website, you must have a user.
        Registration is disabled. <br>
        For any request you can contact the
        <a id="lastlink" href="mailto:shalev444@gmail.com?Subject=Yudale%20Review" target="_top">
            admin</a>.

</div>
</body>
</html>