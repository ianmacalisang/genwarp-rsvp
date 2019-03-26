<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
 
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
 
$con = new mysqli($server, $username, $password, $db);

if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
