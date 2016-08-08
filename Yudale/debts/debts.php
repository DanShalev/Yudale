<?php /*VALIDATION REQUIRED PAGE*/
/* INCLUDE php functions */ include "../includes/php_process/php_functions.php";
/* INCLUDE validate_user */ include "php_process/validate_user.php"; //REDIRECT IF THERES NO COOKIE
?>

<!DOCTYPE html>
<html>
<head>
    <title>Yudale</title>
    <?php /*HEADER (META TAGS)*/ include "../includes/headers.php";?>
    <?php /*ADD TO HOME SCREEN SCRIPT*/ include "../includes/scripts/add_to_home_screen.php";?>
    <script>
        <?php /*INCLUDE NAVBAR SCRIPT*/ include "debts_includes/navbar_script.js";?>
        <?php /*INCLUDE FULLSCREEN SCRIPT*/ include "../includes/scripts/fullscreen_script.js";?>
    </script>
</head>

<body>
<?php /*INCLUDE DEBT HEADER*/ include "debts_includes/jqm_dheader.php";?>
<?php /*INCLUDE DEBT FOOTER*/ include "debts_includes/jqm_dfooter.php";?>

<div data-role="page" id="debt1">
    <?php /*INCLUDE MEMBERS PANEL*/ include "debts_includes/panel_dmembers.php";?>

    <div data-role="content">

        <ul data-role="listview" data-inset="true">

        <?php
        /****************CHECK DEBTS VIA DB**************************/
        if(!isset($con))
            include "../includes/php_process/db_connect.php";
        $sql ="SELECT * FROM debts where Owe_To='".$_SESSION['username']."'";
        $result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));

        //mysqli_data_seek($result, 0);
        $count_debts=0;
        while ($data = mysqli_fetch_array($result))
        {
            //BREAKS LOOP IF USER HIDED(DELETED) DEBT
            if ($data['Hide_Owner'] == 1)
                continue;
            $count_debts++;
            //SYNC WITH Users TABLE (Get full name, etc)
            $sql2 ="SELECT * FROM users where User='".$data['User']."'";
            $result2 = mysqli_query($con, $sql2) or die("ERROR: ".mysqli_error($con));
            $data2 = mysqli_fetch_array($result2);
            if ($data2['User']=='other')
                $sql_name = $data['Other_Name']; //Other name is in DEBTS table
            else
                $sql_name = $data2['Name']; //Members name are in USERS table
            //==============PRINT DATA================== ?>

            <li data-icon="false"><a href="<?php echo $base_href?>debts/edit_debt.php?id=<?php echo $data['PID']?>" data-ajax="false">
                    <img src="<?php echo $base_href."users/pictures/".$data2['Image URL']; ?>">

                    <img src="<?php
                    echo $base_href."style/buttons/debts_status/";
                    //CHECKS DEBT STATUS
                    if($data['Hide_User']==1)
                        echo "declined.gif";
                    else if ($data['Verified_User']==1 && $data['Verified_Owner']==1)
                        echo "confirmed.gif";
                    else if ($data['Verified_User']==1 && $data['Verified_Owner']==0)
                        echo "pending_me.gif";
                    else if ($data['Verified_User']==0 && $data['Verified_Owner']==1)
                        echo "pending_user.gif";
                    ?>" class="debt_status">

                    <h2><?php echo $sql_name;?></h2>
                    <p><strong><?php echo $data['Amount'];?></strong><?php
                        echo $data['Currency'];
                        if ($data['Comment']!='') //IF COMMENT IS EMPTY, DELETE (,)
                            echo ",&nbsp;".$data['Comment']; ?>
                    <p class="ui-li-aside" id="debtSummary_date"><?php echo $data['Date'];?></p>
                </a></li>
            <?php
            }
        if ($count_debts == 0)  //NO RECORDS
            echo "<li data-role='list-divider' data-theme='f'>No debts</li>";
        ?>
        </ul>

    </div>
</div>

</body>
</html>
<?php
mysqli_close($con);
unset($con);
?>