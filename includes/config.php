<?php
define('DB_SERVER', '192.185.19.9');
define('DB_USERNAME', 'andyware_heroku');
define('DB_PASSWORD', 'ilm10998');
define('DB_NAME', 'andyware_rsvp');
 
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>