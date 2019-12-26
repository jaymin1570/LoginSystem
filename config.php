<?php
/*
this file contains database configure assuming you are running mysql 
using user "root"  and password ""
*/

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'login');

// try connecting to the Database..

$conn = mysqli_connect('localhost', 'root', '', 'login');

// check connection

if ($conn == false) {
    dir('Error : can not connect');
}
?>
