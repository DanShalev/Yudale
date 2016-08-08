<?php
//DESTROY COOKIE
setcookie("yudaleMobile", "", time()-3600, "/");
//DESTROY SESSION
session_start();
session_destroy();
//RELOCATING...
header("location:../login.php");
?>