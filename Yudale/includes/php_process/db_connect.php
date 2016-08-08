<?php
//SQL LOGIN DETAILS
$SQLhost = "localhost";
$SQLusername = "root";
$SQLpassword = "password";
$SQLdb_name = "yudale";
//Connect to SQL SERVER
$con = mysqli_connect($SQLhost, $SQLusername, $SQLpassword, $SQLdb_name) or
die("ERROR: ".mysqli_connect_error());
//SET utf-8
mysqli_query($con,"SET NAMES 'utf8'");
?>