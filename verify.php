<?php
require_once './includes/config.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$keyAccess = $_GET['key'];

$query = "SELECT * FROM attendees WHERE accessCode = '$keyAccess'";
$row_cnt = $result->num_rows;

$keyResult = $con->query($query);
$row_cnt = $keyResult->num_rows;
$rows = $keyResult->fetch_assoc();
                $userId = $rows['id'];
                $fullName = $rows['fullname'];
                $connectTo = $rows['connectTo'];
                $qrCode = $rows['qrCode'];
                $userStat = $rows['status'];
                $userAccess = $rows['accessCode'];
 
$eventQuery = $con->query("SELECT * FROM events WHERE id = '$connectTo'");
$eventRow = $eventQuery->fetch_assoc();
                $eventName = $eventRow['eventname'];
                $website = $eventRow['website'];
                $eventInfo = $eventRow['description'];
                $eventDate = $eventRow['eventdate'];

    
switch($userStat){
    case "Pending":
        $confirmButton = '<div class="btn-group" role="group">
                            <button type="button" class="btn btn-success btn-lg attend">Yes</button>
                          </div>

                          <div class="btn-group" role="group">
                             <button type="button" class="btn btn-danger btn-lg noAttend">No</button>
                          </div>';
        $caption = "Invitation details will be automatically downloaded on your device after confirmation. Manually save the invitation details on mobile devices.";
        $question = "Are you interested in going?";
                          break;
    default:
        $confirmButton = '<div class="btn-group" role="group">
                            <button type="button" class="btn btn-success btn-lg" disabled>Verified</button>
                          </div>

                          <div class="btn-group" role="group">
                             <button type="button" class="btn btn-default btn-lg" disabled>'.$userStat.'</button>
                          </div>';
        $caption = "Invitation already verified. View more details at:<br/><a class='link-cap' href='http://".$website."'>".$website."</a>";
        $question = "";
                          break;
}

mysqli_close($con);

$timestring = date('Y F d (D)', strtotime($eventDate));
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $eventName; ?></title>
    <link href='https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,400italic,300italic,300|Raleway:300,400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./public/css/animate.css">
    <link rel="stylesheet" type="text/css" href="./public/css/verify.css">
    
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="./public/js/html2canvas.js" type="text/javascript"></script>

  </head>
  <body>
      <div class="content">
          <?php if($row_cnt != 0){ ?>
          <div class="container wow fadeInUp delay-03s">
        <div class="row">
          <div class="logo text-center">          
            <h2><?php echo $eventName; ?></h2>
            <h4>Hi, <b><?php echo $fullName;?></b>! You have been invited.</h4>
          </div>
          
          
          <div class="subcription-info text-center">
                <br/>
            <img src="./public/images/qr/<?php echo $qrCode; ?>" alt="logo" width="100" class="logo-qr">
                <br/><br/>
            <h4><?php echo $question; ?></h4>
            <div id="choices" class="btn-group btn-group-justified" role="group" aria-label="...">
                <?php echo $confirmButton ?>
            </div>
            <br/>
            <p class="sub-p"><?php echo $caption; ?></p>
          </div>
        </div>
      </div>
      <?php }else{ echo "<div class='text-center'><h1>We cannot find this access code.</h1><h3>It must have been deleted or deactivated.</h3><br/>"; }; ?>
      <footer class="footer">
      <div class="container">
         <div class="row bort">

           <div class="copyright">
                © Copyright Guestlist Database. All rights reserved.
                <div class="credits">Powered by <a href="https://www.genwarp.com/">Genwarp Web Development</a></div>
           </div>

         </div>
      </div>
    </footer>
      </div>
<script type='text/javascript'>
$(document).ready(function() {
    
    $("#choices").on('click','.attend', function() {
        var userId = <?php echo $userId; ?>;
        var statData = "Attending";
        var postData = "userData="+userId+"&stat="+statData+"&postType=guestChoice";
        if(confirm("Confirm attendance?"))
            {
                $.ajax({
                    type: "POST",
                    url: "./includes/callback.php",
                    data: postData,
                     success: function(){
                        console.log('going processed');
                        $("#savethis").trigger("click");
                        location.reload();
                        },
                        error: function(data){
                        console.log(data);
                        }   
            });            
            }
        });
    
    $("#choices").on('click','.noAttend', function() {
        var userId = <?php echo $userId; ?>;
        var statData = "Not Going";
        var postData = "userData="+userId+"&stat="+statData+"&postType=guestChoice";
        if(confirm("Are you sure you don't want to go?"))
            {
                $.ajax({
                    type: "POST",
                    url: "./includes/callback.php",
                    data: postData,
                     success: function(){
                        console.log('processed. not going!');
                        location.reload();
                        },
                     error: function(data){
                        console.log(data);
                        }   
            });            
            }
        });
        
 
   $('#savethis').click(function(){

    html2canvas($('#imagesave'), 
    {
      onrendered: function (canvas) {
        var a = document.createElement('a');
        // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
        a.href = canvas.toDataURL();
        a.download = '<?php echo $eventName ?>-<?php echo $keyAccess ?>.png';
        a.click();
      },
      onclone: function(document) {
            hiddenDiv = document.getElementById("imagesave");
            hiddenDiv.style.display = 'block';
        }
    });
  });           
        
           
});
</script>

<div id="imagesave" align="center">
    <div style="visibility: none;">
    <div class="background-image"></div>
    <div class="logo text-center">          
            <h2><?php echo $eventName; ?></h2>
            <div><?php echo $eventInfo;?></div><div><?php echo $timestring;  ?></div>
            <h4>This is an invitation to:</h4>
                <h3><b><?php echo $fullName;?></b></h3>
    </div>
    <hr/>
    <div><img src="./public/images/qr/<?php echo $qrCode; ?>" alt="logo" width="200"></div><br/>
    <div>Universal Access: <?php echo $keyAccess; ?></div>
   
        
<br/>
           <div class="canvasFoot">
                For more information please visit us at <?php echo $website ?>
                <div class="credits">Powered by <a href="https://www.genwarp.com/">Genwarp Web Development</a></div>
           </div>

     </div>
   
</div>
<button id="savethis" style="display: none;"></button>
  </body>
</html>