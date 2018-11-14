<?php
include_once './config.php';
require_once './plugin/qrcode/qrlib.php';

function getRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}
function sanitize($input) {
    $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@',        // Strip multi-line comments
    '#<\?.*?(\?>|$)#s'                  //Strip php tags   
  );
    $output = strip_tags(preg_replace($search, '', $input));
    return $output;
  }
if($_GET['postType'] === 'event'){
    
    $evntName = sanitize($_POST['event-name']);
    $modeName = sanitize($_POST['mod-fullname']);
    $modeUser = sanitize($_POST['mod-username']);
    $modePass = sanitize($_POST['mod-password']);
    $apiAccess = md5(getRandomString());
    
    $hashPass = password_hash($modePass, PASSWORD_DEFAULT);
    
    $queryUser = "INSERT INTO admin (username,password,fullname)
                    VALUES ('$modeUser','$hashPass','$modeName')";
    $insertUser = mysqli_query($con, $queryUser);             
    if($insertUser){
        $lastId = mysqli_insert_id($con);
        $queryEvent = "INSERT INTO events (eventname,referredFrom)
                        VALUES ('$evntName','$lastId')";
        $insertEvent = mysqli_query($con, $queryEvent);
            if ($insertEvent){
                $lastEventId = mysqli_insert_id($con);
                $insertApi = "INSERT INTO api (apiKey,fromUser, fromEvent)
                        VALUES ('$apiAccess','$lastId','$lastEventId')";
                 $insertFinalKey =  mysqli_query($con, $insertApi);    
                 header("location: ../dashboard?view=0");
            }else{
                echo ('event query error');
                echo error_reporting(E_ALL);
            }
    }else {
    echo ('uni query error');
    echo error_reporting(E_ALL);
    }
mysqli_close($con);  
}

if($_GET['postType'] === 'attendee'){
    
    
    $guestName = sanitize($_POST['guest-fullname']);
    $guestConnect = sanitize($_POST['guest-connect']);
    $guestReferred = sanitize($_POST['guest-referred']);
    $guestAccess = getRandomString();
    $guestQr = $guestAccess.".png";
    $guestEmail = sanitize($_POST['guest-email']);   
    
    $queryGuest = "INSERT INTO attendees (fullname,accessCode,qrCode,connectTo,referredFrom,email)
                    VALUES ('$guestName','$guestAccess','$guestQr','$guestConnect','$guestReferred','$guestEmail')";
    
    $insertGuest = mysqli_query($con, $queryGuest);
    if($insertGuest){
        
        $tempDir = '../public/images/qr/';
        $codeContents = 'https://rsvp.genwarp.com/verify?key='.$guestAccess; 
        $fileName = $guestAccess.'.png'; 
        $pngAbsoluteFilePath = $tempDir.$fileName; 
 
        
        if (!file_exists($pngAbsoluteFilePath)) { 
                QRcode::png($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_L, 3);
               
                header("location: ../dashboard?view=0");
                
                
            } else { 
                echo 'File already generated! We can use this cached file to speed up site on common codes!'; 
                echo '<hr />'; 
            }
    }else{
        echo "Error adding data...";
    }
    
mysqli_close($con);
}

if($_POST['postType'] === 'deleteGuest'){
 
        $id = $_POST['id'];
        
        $unlinkQr = "SELECT * FROM attendees WHERE id = '$id'";
        if ($unlinkResult = $con->query($unlinkQr)) {
            while ($row = $unlinkResult->fetch_assoc()) {
                $qr = $row['qrCode'];
            }
        $unlinkPath = '../public/images/qr/'.$qr;
        if (unlink($unlinkPath)) {
                $delete = "DELETE FROM attendees WHERE id='$id'";
                $con->query($delete); 
            } else {
            echo 'fail';
            } 
        }
    
mysqli_close($con);
}
if($_POST['postType'] === 'viewMore'){
    if (isset($_POST['last_record']) && $_POST['last_record'] != '') {
        $lastid = $_POST['last_record'];
        $ref =$_POST['ref'];
        $eventId =$_POST['eventData'];
        $userId =$_POST['userData'];
        
        switch($ref){
        case 0:
        $globalQuery = "SELECT * FROM attendees WHERE id < '$lastid' AND connectTo = '$eventId' AND referredFrom = '$userId' ORDER BY id DESC LIMIT 6";    
        break;
        case 1:
        $globalQuery = "SELECT * FROM attendees WHERE id < '$lastid' AND status = 'Pending' AND connectTo = '$eventId' AND referredFrom = '$userId' ORDER BY id DESC LIMIT 6";    
        break;
        case 2:
        $globalQuery = "SELECT * FROM attendees WHERE id < '$lastid' AND status = 'Attending' AND connectTo = '$eventId' AND referredFrom = '$userId' ORDER BY id DESC LIMIT 6";    
        break;
        case 3:
        $globalQuery = "SELECT * FROM attendees WHERE id < '$lastid' AND status = 'Not Going' AND connectTo = '$eventId' AND referredFrom = '$userId' ORDER BY id DESC LIMIT 6";    
        break;
        default:
        echo 'error';
        break;
        }
        
        if ($globalResult = $con->query($globalQuery)) {
            while ($globalRow = $globalResult->fetch_assoc()) {
                $attendId = $globalRow['id'];
                $attendName = $globalRow['fullname'];
                $attendStat = $globalRow['status'];
                $attendQr = $globalRow['qrCode'];
                $attendCode = $globalRow['accessCode'];
                $attendEmail = $globalRow['email'];
        
    ?>
    
    
    
        <div class="panel panel-default" id="showGuest">
            <div class="panel-body">
                <div class="media">
                    
                    <div class="media-body">
                        <h4 class="media-heading"><b><?php echo $attendName; ?></b></h4>
                        <p><b>Email:</b> <?php if($attendEmail == NULL){echo 'No email provided';}else{echo $attendEmail;} ?><br/><b>Access Code:</b> 
                            <br/><h4><span class="label label-default"><?php echo $attendCode; ?></span></h4</p>
                    </div>
                    
                    <div class="media-right">
                        <img class="media-object" src="./public/images/qr/<?php echo $attendQr; ?>" alt="QR Code">
                    </div>
                    
                </div>
            </div>
            <div class="panel-footer" align="right"> 
                <div class="btn-group" role="group" aria-label="download">
                    <button type="button" class="btn btn-default showInfo" data-id="<?php echo $attendId; ?>"><i class="fa fa-download" aria-hidden="true"></i> Download</button>
                </div>                      
               <!-- Split button -->
                <div class="btn-group">
                    <button type="button" id='panelStatView' class="btn btn-info" disabled><?php echo $attendStat ?></button>
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Change Status</span>
                        </button>
                    <ul class="dropdown-menu" id="panelEditStatus">
                        <li><a href="javascript:void(0)" class="editStatusSingle" id="<?php echo $attendId ?>">Pending</a></li>
                        <li><a href="javascript:void(0)" class="editStatusSingle" id="<?php echo $attendId ?>">Attending</a></li>
                        <li><a href="javascript:void(0)" class="editStatusSingle" id="<?php echo $attendId ?>">Not Going</a></li>
                     </ul>
                </div>
                <button type="button" class="btn btn-danger deleteGuest" id="<?php echo $attendId ?>"><i class="fa fa-user-times" aria-hidden="true"></i> Delete</button>
<!-- split end -->         
            </div>
        </div>

    <?php  
    $last_record = $attendId;      
        }
        echo '<div align="center"><button class="more btn btn-primary btn-block" id="' . $last_record . '">Fetch more data</button></div>';   
    }else{
        echo "Error";
    }
        
    }else {
    echo '<div align="center"><button class="more btn btn-primary btn-block" id="' . $last_record . '" disabled>No data found</button></div>';
}
mysqli_close($con);   
}
if($_POST['postType'] === 'modDeleteAll'){
    $userId = $_POST['userData'];
    $eventId = $_POST['eventData'];
    
    $delAll = "DELETE FROM attendees WHERE connectTo = '$eventId' AND referredFrom ='$userId'";
    $unlinkFile = "SELECT qrCode FROM attendees WHERE connectTo = '$eventId' AND referredFrom ='$userId'";

    $fileGet = $con->query($unlinkFile);
    while($Filerow = $fileGet->fetch_array()) {
        $fileArray = $Filerow['qrCode'];
        
        $delFile = unlink("../public/images/qr/".$fileArray);
        
    }
       
    if($delFile){
        $clearAllUser = $con->query($delAll);
    }else{
        echo "error deleting";
    }
    mysqli_close($con); 
}
if($_POST['postType'] === 'guestChoice'){
    $userid = $_POST['userData'];
    $statUp = $_POST['stat'];
    
    $query = "UPDATE attendees SET status = '$statUp' WHERE id = '$userid'";
    $update = $con->query($query);
    $update;
    
mysqli_close($con); 
}
if($_GET['postType'] === 'editCard'){
    
    $eventId = $_POST['cardConnect'];
    $eventInfo = sanitize($_POST['event-decription']);
    $eventSite = sanitize($_POST['event-site']);
    $eventName = sanitize($_POST['event-name']);
    
    $eventDate = date('Y-m-d', strtotime($_POST['event-date']));
      
    $updateQuery = "UPDATE events SET eventname = '$eventName', description = '$eventInfo', eventdate = '$eventDate', website = '$eventSite' WHERE id = '$eventId'";
    $result = $con->query($updateQuery);
    if ($result) {
        header("location: ../dashboard?view=0");
        echo 'update success';
    }else{
        echo 'update error';
    }
    
mysqli_close($con); 
}
if($_POST['postType'] === 'resetAllStatus'){
    $userId = $_POST['userData'];
    $eventId = $_POST['eventData'];
    
    $resetAll = "UPDATE attendees SET status = 'Pending' WHERE connectTo = '$eventId' AND referredFrom ='$userId'";

    $resetAllUser = $con->query($resetAll);
    
    if($resetAllUser){
        echo 'SUCCESS';
    }else{
        echo "ERROR";
    }
mysqli_close($con); 
}
if($_POST['postType'] === 'editSingle'){
    
    $userId = $_POST['id'];
    $status = $_POST['statusEdit'];
  
    
    $edit = "UPDATE attendees SET status = '$status' WHERE id ='$userId'";

    $editUser = $con->query($edit);
    
    if($editUser){
        echo $status;
    }else{
        echo "ERROR";
    }
mysqli_close($con); 
}
if($_GET['postType'] === 'showInfo'){
    
    $userId = $_GET['userId'];
    $query = "SELECT * FROM attendees WHERE id = '$userId'";
    $userInfo = $con->query($query);
    $userRow = $userInfo->fetch_assoc();
        $userName = $userRow['fullname'];
        $qrCode = $userRow['qrCode'];
        $accessCode = $userRow['accessCode'];
?>       
        <div align="center" class="infoCard">
            <br/>
            <div class="infoCardHeader"><h3><?php echo $userName; ?></h3></div>
            <div class="infoCardBody">
                <h5>YOU ARE CORDIALLY INVITED!</h5>
                <img src="./public/images/qr/<?php echo $qrCode; ?>" />
                <h5>POINT YOUR CAMERA</h5>
                <h6>ACCESS: <?php echo $accessCode; ?></h6>
                <br/>
            </div>
            <br/>
        </div>
<?php    
mysqli_close($con); 
}
?>