<div class="panel panel-default">
  <div class="panel-body">
     
    <h4><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo $fullname; ?></h4>
    <div><span class="label label-info"><?php echo $userStat; ?></span></div> 
    
  </div>
</div>
    
<div id="reload">
<?php
if($status == 0){
    statusAdmin();
}else{
    statusOrganizer();
}
?>
</div>