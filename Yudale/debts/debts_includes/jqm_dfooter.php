<?php /*GET NUMBER OF PENDING-ME DEBTS*/
if(!isset($con))
    include "../includes/php_process/db_connect.php";

$sum_search = 0; //FOR PANEL BUBBLE
//SEARCH 1: I OWE OTHER
$sum_debts2 = 0;
$sql ="SELECT * FROM debts where User='".$_SESSION['username']."'";
$search_result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));

while ($search_data = mysqli_fetch_array($search_result)) {
    if ($search_data['Hide_Owner'] == 1 || ($search_data['Verified_User']==0 && $search_data['Verified_Owner']==1)) { //HIDE OWNER = 1: DELETED BY USER
        $sum_search++;
        $sum_debts2++;
    }
}

//SEARCH 2: OTHER OWE ME
$sum_debts1 = 0;
$sql ="SELECT * FROM debts where Owe_To='".$_SESSION['username']."'";
$search_result2 = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));

while ($search_data2 = mysqli_fetch_array($search_result2)) {
    if ($search_data2['Hide_User'] == 1 || ($search_data2['Verified_User']==1 && $search_data2['Verified_Owner']==0)) {
        $sum_search++;
        $sum_debts1++;
    }
}

//CLOSE SQL CONNECTION
mysqli_close($con);
unset($con);
?>

<?php /*FOOTER*/?>
<div data-role="footer"  data-position="fixed" data-theme="a">
    <div data-role="navbar" data-iconpos="left">
        <ul>
            <li id="debt_tab">
                <a href="debts/debts.php" id="debt1" data-icon="arrow-d">
                    חייבים לי
                <?php //BUBBLE SEARCH NUMBER
                   if ($sum_debts1!=0) {
                        echo '<span class="footer_bubble ui-li-count">'.$sum_debts1.'</span>';
                } ?>
                </a>
            </li>
            <li id="debt_tab">
                <a href="debts/debts2.php" id="debt2" data-icon="arrow-u" data-prefetch>
                    חייב לאחרים
                    <?php //BUBBLE SEARCH NUMBER
                    if ($sum_debts2!=0) {
                        echo '<span class="footer_bubble ui-li-count">'.$sum_debts2.'</span>';
                    } ?>
                </a>
            </li>
        </ul>
    </div>
</div>