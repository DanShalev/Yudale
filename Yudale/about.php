<?php /*VALIDATION/NON-VALIDATION REQUIRED PAGE*/
/* INCLUDE php functions */ include "includes/php_process/php_functions.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Yudale</title>
    <?php include "includes/headers.php";?>
    <script>
        <?php /*INCLUDE FULLSCREEN SCRIPT*/ include "includes/scripts/fullscreen_script.js";?>
    </script>
</head>

<body>
<div data-role="page" id="about">
    <?php /*INCLUDE CHOOSE PANEL*/ include "php_process/choose_panel.php";?>
    <?php /*INCLUDE HEADER*/ include "includes/jqm_header.php";?>

    <div data-role="content">
    <span style="font-weight:bold; font-size: 20px">About</span><br>
        <div id="padding_box">
            This website was designed and build by <strong>Name</strong>.<br><br>
            <strong>Versions:</strong>
            <div data-role="collapsible" class="collapsible_arrow"
                 data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d">
                <h4>Yudale version 1.0</h4>
                <b>Relese date:</b> January 2014
                <ul>
                    <li>First version released, may have some bugs and errors in it.</li>
                </ul>
            </div>
            <div data-role="collapsible" class="collapsible_arrow"
                 data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d">
                <h4>Yudale version 1.1</h4>
                <b>Relese date:</b> January 2014
                <ul>
                    <li>Dropdown menu added.</li>
                    <li>Not yet suitable for iPhone & Android (soon).</li>
                </ul>
            </div>
            <div data-role="collapsible" class="collapsible_arrow"
                 data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d">
                <h4>Yudale version 2.0 (Mobile)</h4>
                <b>Relese date:</b> March 2014
                <ul>
                    <li>Now suitable for iPhone & Android!</li>
                </ul>
            </div>
            <br>For any comments & requests,<br>
            I am reachable at
            <a href="mailto:mail.com?Subject=Yudale%20Review" target="_top">
                mail@gmail.com</a><br><br>
        </div>
    </div>


</div>
</body>
</html>