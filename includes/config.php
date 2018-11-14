<?php
define('DB_SERVER', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');
 
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>