<?php

define("HOST", "localhost");     // The host you want to connect to.
define("USER", "root");    // The database username.
define("PASSWORD", "@p0lIo1!");    // The database password.
define("DATABASE", "abtf_new");    // The database name.
define("SITENAME", "ABTF Test Website");


define("SESSIONLIFETIME",3600);


$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
mysqli_set_charset($mysqli,"utf8");
if ($mysqli->connect_error) {
    header("Location: ../error.php?err=Unable to connect to MySQL");
    exit();
}