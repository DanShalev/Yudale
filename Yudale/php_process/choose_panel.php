<?php
/*CHOOSE MENU! (THERE IS ALSO DEBT PAGE,
all due to problem finding absolute include path*/

/*ONLY MEMBERS+NON MEMBERS (PAGE THAT IS BOTH, like Account Setting)
SHOULD INCLUDE THIS FILE*/

if (!isset($_COOKIE["yudaleMobile"])) //CHECKS IF THERE IS A COOKIE
    /* INCLUDE guest panel */ include "includes/panel_guests.php";
else if(isset($_SESSION['username']) && isset($_SESSION['name'])
    && isset($_SESSION['image_url'])) { //CHECKS IF THERE ARE SESSIONS
    /* INCLUDE members panel */ include "includes/panel_members.php";
}
else { //COOKIE & SESSIONS ARE UNSET
    //CONNECT TO DB, $con - mysqli_connect();
    include 'includes/php_process/db_connect.php'; //NEEDS EDITING AND ABSOLUTE PATH
    //SQL SCRIPT (users - name of a table)
    $sql ="SELECT * FROM users where Cookie='".$_COOKIE['yudaleMobile']."'";
    $result = mysqli_query($con, $sql) or die("ERROR: ".mysqli_error($con));
    //CHECKS IF COOKIE VALUE IS TRUE - HACK PROTECT
    $count=mysqli_num_rows($result); //COUNT HOW MANY ROWS OF RESULTES: 0 - NO RESULTES, 1 - ONE MATCH
    $data = mysqli_fetch_array($result);
    if($count==0){
        die("<script>alert('Hacking, are we? FUCK OFF');</script>"); //NOT SHOWING, JUST REDIRECTING
        //header('location:'.$base_href.'login.php');
    } else { //IN CASE THERE IS A COOKIE BUT NO SESSION - FIND SESSIONS
        //ASSAIGN SQL_DATA TO VARIABLES
        $_SESSION['username'] = $data['User'];
        $_SESSION['name'] = $data['Name'];
        $_SESSION['image_url'] = $data['Image URL'];

        mysqli_close($con);
        //Reload page
        header('Location: '.$_SERVER['PHP_SELF']);

        //Session in destroyed when browser is called/user logs out.
    }
}
?>