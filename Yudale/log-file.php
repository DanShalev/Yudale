<?php /*VALIDATION/NON-VALIDATION REQUIRED PAGE*/
/* INCLUDE php functions */ include "includes/php_process/php_functions.php"; ?>
<?php
//***PHP LOCAL FUNCTIONS***
function monthName($num) {
    switch ($num) {
        case "1":
            return "January";
        case "2":
            return "February";
        case "3":
            return "March";
        case "4":
            return "April";
        case "5":
            return "May";
        case "6":
            return "June";
        case "7":
            return "July";
        case "8":
            return "August";
        case "9":
            return "September";
        case "10":
            return "October";
        case "11":
            return "November";
        case "12":
            return "December";
    }
}

//***SET COLOR SWITCH***
$color = false;
if (isset($_POST['color_select'])) {
    $color_input = $_POST['color_select'];
    if ($color_input == 1) {
        $color = true;
        //SET COOKIE FOR FUTURE REFERENCE
        setcookie("yudaleLogfileColor", "1", time()+60*60*24*30, "/");
    } else //DELETE COOKIE
        setcookie("yudaleLogfileColor", "0",  time()-3600, "/");
} else if (isset($_COOKIE["yudaleLogfileColor"])) {
    if ($_COOKIE['yudaleLogfileColor'] == "1")
        $color = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Yudale</title>
    <?php include "includes/headers.php";?>
    <style>
        /*PROLOAD ROTATE ICON TO BACKGROUND*/
        #device_orientation { background: url(style/buttons/rotate/rotate.png) no-repeat -9999px -9999px; }
    </style>
</head>

<body>
<div data-role="page" id="about">
<script>
    <?php /*INCLUDE FULLSCREEN SCRIPT*/ include "includes/scripts/fullscreen_script.js";?>
    /*ADD CLASSES FOR COLLAPSIBLE & LISTVIEW STYLE
     COLLAPSIBLE CLASS: collapsible_middle & collapsible_bottom
     LISTDIVIDER: listdivider_top*/
    $(document).ready(function(){
        $("#collapsible_set_logfile")
            .find("[data-role='collapsible']")
            .addClass("collapsible_middle");
        $("#collapsible_set_logfile")
            .find("[data-role='collapsible']")
            .last().removeClass("collapsible_middle")
            .addClass("collapsible_bottom");
        $("#collapsible_set_logfile")
            .find(".listdivider_logfile:first")
            .addClass("listdivider_top");
    });
    //COLOR SWITCH SCRIPT
    function colorSubmit() {
        document.getElementById("color_form").submit();
    }
</script>

    <?php /*INCLUDE CHOOSE PANEL*/ include "php_process/choose_panel.php";?>
    <?php /*INCLUDE HEADER*/ include "includes/jqm_header.php";?>

    <div data-role="content">
        <span style="font-weight:bold; font-size: 20px">Log File</span><br>
        <?php //COLOR SWITCH ?>
        <form id="color_form" method="post" action="log-file.php">
            <div style="float: right; padding: 5px">
                <select name="color_select" id="color_select" data-role="slider"
                        data-theme="g" onchange="colorSubmit()">
                    <option value="0">None</option>
                    <option value="1" <?php
                    if ($color == true)
                        echo 'selected=""';
                    ?>>Color</option>
                </select>
            </div>
        </form>

        <div id="padding_box">
            Log file is contains history of action taken on all of your debts.
            <br><br>
            <div id="device_orientation"></div>
            <script>
                if (window.orientation == 0 || window.orientation == 180) {
                    document.getElementById("device_orientation").innerHTML =
                        "<img src='style/buttons/rotate/rotate.png' alt='rotate_icon' class='rotate_icon'>" +
                            "<span style='color: red;'><strong>It's recommended to view this page in landscape mode.</strong></span><br>";
                }
                $(window).bind('orientationchange', function() {
                    if (window.orientation == 0 || window.orientation == 180) {
                        document.getElementById("device_orientation").innerHTML =
                            "<img src='style/buttons/rotate/rotate.png' alt='rotate_icon' class='rotate_icon'>" +
                                "<span style='color: red;'><strong>It's recommended to view this page in landscape mode.</strong></span><br>";
                    } else {
                        document.getElementById("device_orientation").innerHTML =
                            "";
                    }
                });
            </script>
            <div id="collapsible_set_logfile" data-role="collapsible-set" class="collapsible_plus" data-theme="a" data-content-theme="a">
                <div data-role="listview" data-inset="true" data-filter="true">
            <?php   /****************************XML*************************/
                    /*PARSE XML USER DATA AND DISPLAY LOGFILE*/
                    //LOAD USER XML FILE
                    $xml=simplexml_load_file("users/logfiles/".$_SESSION['username'].".xml");
                    //GET USERNAME ARRAY[][]
                    if(!isset($con))
                        include "includes/php_process/db_connect.php";
                    $sql ="SELECT User,Name FROM users";
                    $result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));

                    $usernames = array();
                    $i = 0;
                    while ($data = mysqli_fetch_array($result))
                    {
                        $usernames[$i] = array($data['User'],$data['Name']);
                        $i++;
                    }

                    mysqli_close($con);
                    unset($con);
            //*****************************PRINT ROW***********************
                    $first_time = true;
                    $empty_logfile = true;
                    $debts_array = array_reverse($xml->xpath('debt'));
                    foreach($debts_array as $debt) //FOR EVERY <debt>
                    {
                        $empty_logfile = false;
                  //=====================PRINT LIST DIVIDER============
                        //SWITCH: THEME
                            //DEFULT THEME
                        $collapsible_theme = "";
                        $listdivider_class = "listdivider_logfile ui-li-divider ui-bar-b ui-first-child ui-last-child";
                        $listdivider_year_style = "background-color: #8fac3d";
                        $listdivider_month_style = "background-color: #c1d45e";
                            //COLOR THEME
                        if ($color==true){
                            $listdivider_year_style = "background-color: #8fac3d";
                            $listdivider_month_style = "background-color: #c1d45e";
                            switch ($debt->action) {
                                case "delete":
                                    $collapsible_theme = ' data-theme="c" data-content-theme="c"';
                                    break;
                                case "confirm":
                                    $collapsible_theme = ' data-theme="d" data-content-theme="d"';
                                    break;
                                case "edit":
                                    $collapsible_theme = ' data-theme="e" data-content-theme="e"';
                                    break;
                                case "resend":
                                    $collapsible_theme = ' data-theme="e" data-content-theme="e"';
                                    break;
                                case "add":
                                    $collapsible_theme = ' data-theme="h" data-content-theme="h"';
                                    break;
                            }
                        }
                        //CALCULATE LISTDIVIDER POSITIONING
                        if($first_time == true) {
                            $xml_month = (int)$debt->date->month;
                            $xml_year = (int)$debt->date->year;

                            echo "<div class='".$listdivider_class."' style='".$listdivider_year_style."'>".$xml_year."</div>"; //YEAR
                            echo "<div class='".$listdivider_class."' style='".$listdivider_month_style."'>".monthName($xml_month)."</div>"; //MONTH
                            $first_time = false;
                        } else if ($xml_year == (int)$debt->date->year && $xml_month > (int)$debt->date->month) {
                            $xml_month = (int)$debt->date->month;
                            echo "<div class='".$listdivider_class."' style='".$listdivider_month_style."'>".monthName($xml_month)."</div>"; //MONTH
                        } else if ($xml_year > (int)$debt->date->year) {
                            $xml_year = (int)$debt->date->year;
                            $xml_month = (int)$debt->date->month;
                            echo "<div class='".$listdivider_class."' style='".$listdivider_year_style."'>".$xml_year."</div>"; //YEAR
                            echo "<div class='".$listdivider_class."' style='".$listdivider_month_style."'>".monthName($xml_month)."</div>"; //MONTH
                        }

                  //=====================PRINT COLLAPSIBLE============
                        //PRINT DIV THEME
                        echo '<div data-role="collapsible"'.$collapsible_theme.'>';
                        //PRINT HEADING
                        echo "<h4 style='font-weight: normal; color: green'>
                                 <span style='font-weight: normal'>";
                        //GET USERNAME FROM <user>
                        for($i=0; count($usernames) > $i;$i++) {
                            if ($debt->action_user == $usernames[$i][0]) {
                                echo $usernames[$i][1]." ";
                            }
                        }
                        //SWITCH: ACTION
                        /*
                         * ACTION MENUAL:
                         * 1. delete = deleted
                         * 2. add = added
                         * 3. confirm = confirmed
                         * 4. edit = edited
                         * 5. resend = resend deleted*/
                        switch ($debt->action) {
                            case "delete":
                                echo "deleted";
                                break;
                            case "add":
                                echo "added";
                                break;
                            case "confirm":
                                echo "confirmed";
                                break;
                            case "edit":
                                echo "edited";
                                break;
                            case "resend":
                                echo "resend deleted";
                                break;
                        } //ECHO ACTION
                        echo " debt (<strong>".$debt->details->amount."</strong>".$debt->details->currency.")</span>";
                        echo "<span style='float: right; font-weight: normal'><strong>";
                        echo $debt->date->day.".".$debt->date->month.".".$debt->date->year;
                        echo "</strong> | ";
                        echo $debt->date->time;
                        echo "</span></h4>";

                        //PRINT CONTENT
                            //USER OWE TO OTHER USER
                        $checked = false;
                        for($i=0;count($usernames) > $i;$i++) {
                            if ($debt->user == $usernames[$i][0]) {
                                echo $usernames[$i][1]." ";
                                $checked = true;
                            }
                        }
                        if ($checked == false)
                            echo $debt->user." ";
                        $checked = false;
                        echo " owe to ";
                        for($i=0;count($usernames) > $i;$i++) {
                            if ($debt->owe_to == $usernames[$i][0]) {
                                echo $usernames[$i][1].".<br>";
                                $checked = true;
                            }
                        }
                        if ($checked == false)
                            echo $debt->owe_to.".<br>";

                            //INNER CONTENT
                        if(!isset($debt->old_details))
                        {
                            echo "<b>Amount:</b> ".$debt->details->amount.$debt->details->currency."<br>";
                            echo "<b>Date:</b> ".$debt->details->debt_date."<br>";
                            if(isset($debt->details->debt_details))
                                echo "<b>Details:</b> ".$debt->details->debt_details."<br>";
                        } else {
                            echo '<span style="text-decoration: underline"><b>NEW DEBT</b></span><br>';
                            echo "<em><b>&nbsp;&nbsp;&nbsp;Amount:</b> ".$debt->details->amount.$debt->details->currency."<br>";
                            echo "<b>&nbsp;&nbsp;&nbsp;Date:</b> ".$debt->details->debt_date."<br>";
                            if(isset($debt->$debt->details->debt_details))
                                echo "<b>&nbsp;&nbsp;&nbsp;Details:</b> ".$debt->details->debt_details."<br>";
                            echo "</em><br>";

                            echo '<span style="text-decoration: underline"><b>PREVIOUS DEBT</b></span><br>';
                            echo "<em><b>&nbsp;&nbsp;&nbsp;Amount:</b> ".$debt->old_details->old_amount.$debt->old_details->old_currency."<br>";
                            echo "<b>&nbsp;&nbsp;&nbsp;Date:</b> ".$debt->old_details->old_debt_date."<br>";
                            if(isset($debt->old_details->old_debt_details))
                                echo "<b>&nbsp;&nbsp;&nbsp;Details:</b> ".$debt->old_details->old_debt_details."<br>";
                            echo "</em>";
                        }
                        echo '</div>';
                    } ?>
                </div>
            </div>

            <?php //CHECKS IF LOG-FILE IS EMPTY
            if ($empty_logfile == true)
                echo "<ul data-role='listview' data-inset='true'><li data-role='list-divider' data-theme='f'>Logfile is empty</li></ul>"
            ?>
        </div>

    </div>
</div>
</body>
</html>