<?php if($status == 1){ ?>
<div class="jumbotron">
  <p>All data and access codes for your guests will appear in this dashboard. QR codes are automatically generated.</p>
  <div class="btn btn-primary btn-lg" data-toggle="modal" data-target="#guestModal"><i class="fa fa-address-book-o" aria-hidden="true"></i> Start Adding an Invite</div>
  <button class="btn btn-info btn-lg" data-toggle="modal" data-target="#uploadCard"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Event Details</button>
</div>
<br/>
<div id="paginate" >
<?php getGlobalBody(); ?>
</div>

<?php }else {
    echo "I am admin";
}
?>
<hr/>
<div align = "center"><?php include_once './views/footer.php'; ?></div>