<?php /*GET NUMBER OF PENDING-ME DEBTS*/
if(!isset($con)){
    if(isset($file_name) && $file_name=="add_debt")
        include "../includes/php_process/db_connect.php";
    else
        include "includes/php_process/db_connect.php";
}

$sum_search = 0;
//SEARCH 1: I OWE OTHER
$sql ="SELECT * FROM debts where User='".$_SESSION['username']."'";
$search_result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));

while ($search_data = mysqli_fetch_array($search_result)) {
    if ($search_data['Hide_Owner'] == 1 || ($search_data['Verified_User']==0 && $search_data['Verified_Owner']==1)) //HIDE OWNER = 1: DELETED BY USER
        $sum_search++;
}

//SEARCH 2: OTHER OWE ME
$sql ="SELECT * FROM debts where Owe_To='".$_SESSION['username']."'";
$search_result2 = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));

while ($search_data2 = mysqli_fetch_array($search_result2)) {
    if ($search_data2['Hide_User'] == 1 || ($search_data2['Verified_User']==1 && $search_data2['Verified_Owner']==0))
        $sum_search++;
}

//CLOSE SQL CONNECTION
mysqli_close($con);
unset($con);
?>

<?php /*Panel - Members*/?>
<div data-role="panel" id="main_panel" data-position-fixed="true" data-display="push">
    <ul data-role="listview" data-inset="true" data-divider-theme="a">
        <li data-icon="false"><a  id="panel_username" href="#main_panel" data-rel="close">
                <img src="<?php echo $base_href."users/pictures/".$_SESSION['image_url'] ?>">
                <h2><?php echo $_SESSION['name'] ?></h2></a>
        </li>
    </ul>

    <ul data-role="listview" data-inset="true" data-divider-theme="a">
        <li data-role="list-divider">Debts</li>

           <li><a href="<?php echo $base_href ?>debts/debts.php" data-ajax="false" class="ui-btn ui-icon-edit ui-btn-icon-left">
                   Debts<?php //BUBBLE SEARCH NUMBER
                   if ($sum_search!=0) {
                       echo '<span class="ui-li-count">'.$sum_search.'</span>';
                   } ?>
               </a></li>

          <li><a href="<?php echo $base_href ?>log-file.php" class="ui-btn ui-icon-search ui-btn-icon-left">
                  Log File</a></li>

        <li data-role="list-divider">Account</li>
         <li><a href="<?php echo $base_href ?>account_settings.php" class="ui-btn ui-icon-gear ui-btn-icon-left">
                 Account Settings</a></li>
          <li><a data-ajax="false" href="<?php echo $base_href ?>php_process/logout.php" class="ui-btn ui-icon-back ui-btn-icon-left">
                  Log Out</a></li>

        <li data-role="list-divider">About</li>
          <li><a href="<?php echo $base_href ?>about.php" class="ui-btn ui-icon-info ui-btn-icon-left">
                  About</a></li>
    </ul>
</div>
