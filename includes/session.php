<?php
session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ./");
  exit;
}
$username = $_SESSION['username'];
$viewLint = $_GET['view'];

$queryData = "SELECT * FROM admin WHERE username = '$username'";
if ($result = $con->query($queryData)) {
    while ($row = $result->fetch_assoc()) {
        $fullname = $row['fullname'];
        $status = $row['status'];
        $userId = $row['id'];
    }
}
$eventsHandler = "SELECT * FROM events WHERE referredFrom = '$userId'";
    if ($eventsHandlerResult = $con->query($eventsHandler)) {
    while ($eventRow = $eventsHandlerResult->fetch_assoc()) {
        $eventName = $eventRow['eventname'];
        $eventId = $eventRow['id'];
        $eventInfo = $eventRow['description'];
        $eventSite = $eventRow['website'];
        $eventDate = $eventRow['eventdate'];
        }
}
$apiHandler = "SELECT * FROM api WHERE fromUser = '$userId' AND fromEvent = '$eventId'";
    if ($apiHandlerResult = $con->query($apiHandler)) {
    while ($apiRow = $apiHandlerResult->fetch_assoc()) {
        $apiKey = $apiRow['apiKey'];
        }
}
switch($status){
    case 0:
        $userStat = "Administrator";
        break;
    case 1:
        $userStat = "Event Organizer";
        break;
    default:
        echo "Not Applicable";
        break;
}
?>