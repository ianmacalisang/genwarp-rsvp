<?php
require_once './includes/config.php';
require_once './includes/session.php';
require_once './includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
<title>Guestlist Database</title>
<meta name="Description" content="This is a private Guestlist Cloud Database for Genwarp Web Development clients. Mainly used for weddings and special events.">
<meta charset="UTF-8">
<meta content="width=device-width,initial-scale=1" name="viewport">
<link href="./favicon.ico" rel="shortcut icon">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="./public/css/main.css" type="text/css">

<script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="./public/js/html2canvas.js" type="text/javascript"></script>

</head>
<body>
    
<div class="customHead"><?php include_once './views/header.php'; ?></div>
<div class="goModals"><?php include_once './views/modals.php'; ?></div>
<div class="container"><?php include_once './views/body-container.php'; ?></div>


<script type='text/javascript'>
$(document).ready(function() {
    $("#paginate").on('click','.more', function() {
        var last_record = $(this).attr('id');
        var reference = '<?php echo $viewLint; ?>';
        var eventId = <?php echo $eventId; ?>;
        var userId = <?php echo $userId; ?>;
        var postData = "userData="+userId+"&eventData="+eventId+"&ref="+reference+"&last_record=" +last_record+"&postType=viewMore";
        $.ajax({
            type: "POST",
            url: "./includes/callback.php",
            data: postData,
            beforeSend: function() {
                var exhtml = $('#more').html();
                $('.more').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Fetching Data');
            },
            success: function(html) {
                $('.more').remove();
                $('#records').append(html);
            }
        });
    });
    
    $('#paginate').on('click','.deleteGuest',function(){
        event.stopPropagation()
        var element = $(this);
        var del_id = element.attr("id");
        var info = 'id='+del_id+'&postType=deleteGuest';
            if(confirm("Are you sure you want to delete this guest?"))
            {
                $.ajax({
                    type: "POST",
                    url: "./includes/callback.php",
                    data: info,
                     success: function(){
                        console.log('guest deleted');
                        },
                     error: function(data){
                        console.log(data);
                        }   
            });
            $(this).parents("#showGuest").fadeOut();            
            }
        return false;
    });
    
    $("#optionTabs").on('click','.deleteAll', function() {
        var eventId = <?php echo $eventId; ?>;
        var userId = <?php echo $userId; ?>;
        var postData = "userData="+userId+"&eventData="+eventId+"&postType=modDeleteAll";
        if(confirm("Are you sure you want to delete all record?"))
            {
                $.ajax({
                    type: "POST",
                    url: "./includes/callback.php",
                    data: postData,
                     success: function(){
                        console.log('all deleted');
                        },
                     error: function(data){
                        console.log(data);
                        }   
            });
            $("#paginate").fadeOut();   
            $("#viewSelector").slideUp();         
            }
        }); 
        
        $("#optionTabs").on('click','.resetStatus', function() {
        var eventId = <?php echo $eventId; ?>;
        var userId = <?php echo $userId; ?>;
        var postData = "userData="+userId+"&eventData="+eventId+"&postType=resetAllStatus";
        if(confirm("Reset all status to Pending?"))
            {
                $.ajax({
                    type: "POST",
                    url: "./includes/callback.php",
                    data: postData,
                     success: function(){
                        console.log('reset complete');
                        location.reload();
                        },
                     error: function(data){
                        console.log(data);
                        }   
            });           
            }
        }); 
        
        $('#paginate').on('click','.editStatusSingle',function(){
        event.stopPropagation()
        var element = $(this);
        var del_id = element.attr("id");
        var stat = $(this).html();
        var info = 'id='+del_id+'&statusEdit='+stat+'&postType=editSingle';
            if(confirm("Change the status of this guest to "+stat+"?"))
            {
                $.ajax({
                    type: "POST",
                    url: "./includes/callback.php",
                    data: info,
                     success: function(data){
                        console.log(data);
                        },
                     error: function(data){
                        console.log(data);
                        }   
            });   
            $(this).closest(".panel-footer").find("#panelStatView").html(stat);       
            }
        return false;
    }); 
    
  
         $('#paginate').on('click','button.showInfo', function(ev){
             ev.preventDefault();
             var uid = $(this).data('id');
             $.get('./includes/callback?postType=showInfo&userId=' + uid, function(html){
                 $('#showInfo .cardView').html(html);
                 $('#showInfo').modal('show', {backdrop: 'static'});
                 $('.cardView').attr('id', 'renderThis'+uid)
                 $('.downloadNow').attr('id', uid);
             });
         });
         
         $('#showInfo').on('click', '.downloadNow',function(){
             var rid = $(this).attr('id');
             html2canvas($('#renderThis'+rid), 
                {
                    onrendered: function (canvas) 
                    {
                    var a = document.createElement('a');
                    a.href = canvas.toDataURL();
                    a.download = '<?php echo $eventName ?>-'+rid+'.png';
                    a.click();
                    }
                });
        });      
                   
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
<script src="./public/js/custom.js" type="text/javascript"></script>

</body>
</html>