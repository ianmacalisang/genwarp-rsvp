<?php
if($status == 0){ ?>

<!-- Create Event Mode -->
  <div class="modal fade" id="eventModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-database" aria-hidden="true"></i> Add an Event to Database</h4>
        </div>
        <div class="modal-body">
          
          <form action="./includes/callback.php?postType=event" method ="POST" id="eventSubmit">
            <div align="right"><h4>Event Details</h4></div>
            <div class="form-group">
                <label for="event-name" class="control-label">Event Name:</label>
                <input placeholder="Minimum of 6 characters" type="text" pattern=".{6,}" class="form-control" name="event-name" id="event-name" required>
            </div>
            <div align="right"><h4>Moderator Credential</h4></div>
            <div class="form-group">
                <label for="mod-fullname" class="control-label">Full Name:</label>
                <input placeholder="Minimum of 6 characters" type="text" pattern=".{6,}" class="form-control" name="mod-fullname" id="mod-fullname" required>
            </div>
            <div class="form-group">
                <label for="mod-username" class="control-label">Username:</label>
                <input placeholder="Minimum of 6 characters" type="text" pattern=".{6,}" class="form-control" name="mod-username" id="mod-username" required>
            </div>
            <div class="form-group">
                <label for="mod-password" class="control-label">Password:</label>
                <input placeholder="Minimum of 6 characters" type="password" pattern=".{6,}" class="form-control" name="mod-password" id="mod-password" required>
            </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
        </div>
        </form>
      </div>
     <!-- Modal content-->
    </div>
  </div>
<!-- Create Event Mode -->
<?php
}else{
?>
<!-- Create guest Mode -->
  <div class="modal fade" id="guestModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-database" aria-hidden="true"></i> Add a Guest to your Database</h4>
        </div>
        <div class="modal-body">
        <form action="./includes/callback.php?postType=attendee" method ="POST" id="guestSubmit">
            <h3><?php echo $eventName; ?></h3>
            <h5>This is an automated form. Just put the full name of your guest and the system will create a <b>unique QR access code</b> for you. This code can be used by a developer on his preferences.</h5>
            <h5><b>Insertions:</b> <br/> - QR code generator <br/> - Guest status (Can be updated from your website) </h5>
            <br/>
            
            <div align="right"><h4><b>Guest Credential</b></h4></div>
            <div class="form-group">
                <label for="guest-fullname" class="control-label">Full Name:</label>
                <input placeholder="Enter the fullname of your guest (eg. Mr. & Mrs. Doe)" type="text" pattern=".{6,}" class="form-control" name="guest-fullname" id="guest-fullname" required>
            </div>
            
            <div class="form-group">
                <label for="guest-email" class="control-label">Email Address:</label>
                <input placeholder="This is used if you want to send email to this invite(Optional)" type="email" class="form-control" name="guest-email" id="guest-email">
            </div>
           
            
            <input type="hidden" name="guest-connect" value="<?php echo $eventId; ?>"/>
            <input type="hidden" name="guest-referred" value="<?php echo $userId; ?>"/>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
        </div>
        </form>
      </div>
     <!-- Modal content-->
    </div>
  </div>
<!-- Create guest Mode -->
<?php } ?>

<!-- Upload invitation -->
<div class="modal fade" id="uploadCard" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-database" aria-hidden="true"></i> Update your invitation Card</h4>
        </div>
        <div class="modal-body">
        <form action="./includes/callback.php?postType=editCard" method ="POST" id="cardSubmit">

            <h5>Add additional information on your event. This information will be automatically download to your client's device once status has been set to "Attending".</h5>
            <div class="form-group">
                <label for="event-name" class="control-label">Event Name:</label>
                <input placeholder="Enter new name (eg. John Doe Party)" type="text" pattern=".{6,}" class="form-control" name="event-name" id="event-name" value="<?php echo $eventName; ?>">               
            </div>
            
            <div class="form-group">
                <label for="event-decription" class="control-label">Event Description:</label>
                <textarea placeholder="Add short description (420 characters)" type="text" pattern=".{6,420}" class="form-control" name="event-decription" id="event-decription"><?php echo $eventInfo ?> </textarea>            
            </div>
            
            <div class="form-group">
                <label for="event-date" class="control-label">Event Date:</label>
                <input type="date" class="form-control" name="event-date" id="event-date" placeholder="yyyy/mm/dd"> </input>            
            </div>
            
            <div class="form-group">
                <label for="event-site" class="control-label">Website:</label>
                <input type="text" pattern=".{6,420}" class="form-control" name="event-site" id="event-site" placeholder="www.sample.com" value="<?php echo $eventSite ?>"> </input>            
            </div> 
            <input type="hidden" name="cardConnect" value="<?php echo $eventId; ?>"/>       
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="cardButton">Submit</button>
        </div>
        
        </form>
      </div>
     <!-- Modal content-->
    </div>
  </div>
<!-- Upload invitation -->


<div class="modal fade" tabindex="-1" role="dialog" id="showInfo">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Card Information</h4>
      </div>
      <div class="modal-body">
          <div>
              <h4>Card Usage:</h4>
              <ul>
                  <li>If you have a designer he/she can use this image into whatever design intended.</li>
                  <li>The design at the front of your card will be created at your end.</li>
              </ul>
          </div>
          <div class="cardView"></div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary downloadNow"><i class="fa fa-download" aria-hidden="true"></i> Download as PNG</button>
      </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

