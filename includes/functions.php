<?php 
function statusAdmin(){
    global $con; 
    echo '<div class="list-group">';
        echo '<a href="#" class="list-group-item">View All Events <span class="badge">';
                $countEvent = 'SELECT * FROM events';
                $eventResult = $con->query($countEvent);
                $printEvent = mysqli_num_rows($eventResult);
                    if($printEvent > 0){
                        echo $printEvent;
                    }else{
                        echo '0';
                    };
        echo  '</span></a>';
        echo '<a href="#" class="list-group-item">View All Organizers <span class="badge">';
                $countUsers = 'SELECT * FROM admin';
                $userResult = $con->query($countUsers);
                $printUser = mysqli_num_rows($userResult);
                    if($printUser > 0){
                        echo $printUser;
                    }else{
                        echo '0';
                    };
        echo '</span></a>';
    echo '</div>';

} 

function statusOrganizer(){
    global $con, $userId, $eventId, $viewLint, $apiKey, $eventName, $eventInfo, $eventSite, $eventDate; 
    echo '<div class="list-group" id="viewSelector">' ?>
        <a href="./dashboard?view=0" class="list-group-item <?php if($viewLint == 0){echo "active"; }else{ echo "";} ?>">View All Guest <span class="badge">
        <?php
                $allQuery = "SELECT * FROM attendees WHERE connectTo = '$eventId' AND referredFrom = '$userId' AND connectTo = '$eventId'";
                $allResult = $con->query($allQuery);
                $allPrint = mysqli_num_rows($allResult);
                    if($allPrint > 0){
                        echo $allPrint;
                    }else{
                        echo '0';
                    };
        ?>           
        </span></a>
        <a href="./dashboard?view=1" class="list-group-item <?php if($viewLint == 1){echo "active"; }else{ echo "";} ?>">Pending <span class="badge">
        <?php        
                $pendQuery = "SELECT * FROM attendees WHERE status = 'Pending' AND referredFrom = '$userId' AND connectTo = '$eventId'";
                $pendResult = $con->query($pendQuery);
                $printPend = mysqli_num_rows($pendResult);
                    if($printPend > 0){
                        echo $printPend;
                    }else{
                        echo '0';
                    };
        ?>           
        </span></a>
        <a href="./dashboard?view=2" class="list-group-item <?php if($viewLint == 2){echo "active"; }else{ echo "";} ?>">Attending <span class="badge">
        <?php       
                $attendQuery = "SELECT * FROM attendees WHERE status = 'Attending' AND referredFrom = '$userId' AND connectTo = '$eventId'";
                $attendResult = $con->query($attendQuery);
                $printAttend = mysqli_num_rows($attendResult);
                    if($printAttend > 0){
                        echo $printAttend;
                    }else{
                        echo '0';
                    };
        ?>            
        </span></a>
        <a href="./dashboard?view=3" class="list-group-item <?php if($viewLint == 3){echo "active"; }else{ echo "";} ?>">Not Going <span class="badge">
        <?php        
                $notQuery = "SELECT * FROM attendees WHERE status = 'Not Going' AND referredFrom = '$userId' AND connectTo = '$eventId'";
                $notResult = $con->query($notQuery);
                $printNot = mysqli_num_rows($notResult);
                    if($printNot > 0){
                        echo $printNot;
                    }else{
                        echo '0';
                    };
                    
        echo '</span></a>';
        
    echo '</div>';
?>
    <div class="list-group" id="optionTabs">
        <a href="#" class="list-group-item disabled"><i class="fa fa-cog" aria-hidden="true"></i> Options</a>
        <a href="javascript:void(0)" onclick="printExternal();" class="list-group-item"><i class="fa fa-print" aria-hidden="true"></i> Print all Data</a>
        <a href="javascript:void(0)" class="list-group-item resetStatus"><i class="fa fa-user-o" aria-hidden="true"></i> Reset all Status</a>  
        <a href="javascript:void(0)" class="list-group-item deleteAll"><i class="fa fa-times" aria-hidden="true"></i> Clear all Record</a>    
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-info-circle" aria-hidden="true"></i> Usage:</div>
        <div class="panel-body">
            <b>API Key:</b>
            <span class="label label-success pull-right">Active</span>
            <br/><?php echo $apiKey; ?>
            <hr/>
            <b>Event Handler:</b>
            <span class="label label-success pull-right">Active</span>
            <br/><?php echo $eventName; ?><br/>
            <h6><?php echo $eventInfo ?></h6>
            <h6><?php echo date('Y F d (D)', strtotime($eventDate)) ?></h6>
            <hr/>
            <b>Instruction:</b><br/>
            Give the API key to a Genwarp web developer for website insertion.           
            
        </div>
    </div>
<?php
}
function statusHeader(){
    global $status;
    if($status == 0){
        echo '<div data-toggle="modal" data-target="#eventModal" type="button" class="btn btn-primary navbar-btn"><b><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> Start Creating an Event</b></div>';
    }
    if($status == 1){
        echo '<div data-toggle="modal" data-target="#guestModal" type="button" class="btn btn-primary navbar-btn"><b><i class="fa fa-user-plus" aria-hidden="true"></i> Add Invite</b></div>';

    }
}

function getGlobalBody(){
    global $con, $eventId, $userId, $viewLint;
    
    switch($viewLint){
        case 0:
        $globalQuery = "SELECT * FROM attendees WHERE connectTo = '$eventId' AND referredFrom = '$userId' ORDER BY id DESC LIMIT 6";    
        break;
        case 1:
        $globalQuery = "SELECT * FROM attendees WHERE status = 'Pending' AND connectTo = '$eventId' AND referredFrom = '$userId' ORDER BY id DESC LIMIT 6";    
        break;
        case 2:
        $globalQuery = "SELECT * FROM attendees WHERE status = 'Attending' AND connectTo = '$eventId' AND referredFrom = '$userId' ORDER BY id DESC LIMIT 6";    
        break;
        case 3:
        $globalQuery = "SELECT * FROM attendees WHERE status = 'Not Going' AND connectTo = '$eventId' AND referredFrom = '$userId' ORDER BY id DESC LIMIT 6";    
        break;
        default:
        $globalQuery = "SELECT * FROM attendees WHERE connectTo = '$eventId' AND referredFrom = '$userId' ORDER BY id DESC LIMIT 6";    
        break;
    }
    
    $statusLabel = "";
  
    
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
        $allQuery = "SELECT * FROM attendees WHERE connectTo = '$eventId' AND referredFrom = '$userId' AND connectTo = '$eventId'";
                $allResult = $con->query($allQuery);
                $allPrint = mysqli_num_rows($allResult);
        if($allPrint > 6){
        echo '<button class="more btn btn-block btn-primary" id="' . $last_record . '">Fetch Data</button>';
        }else{
            echo "";
        }
        echo "<span id='records'></span>";
    }else{
        echo "No Data Available";
    }
}
?>