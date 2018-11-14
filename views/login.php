<div class="container">
        
        <div class="col-md-10 col-md-offset-1 main" >
        <div class="col-md-6 left-side" >
        <h3><i class="fa fa-database" aria-hidden="true"></i> GUESTLIST DATABASE</h3>
        <p>This is a private Guestlist Cloud Database for Genwarp Web Development clients. Mainly used for weddings and special events.</p>
        <br>


        </div><!--col-sm-6-->
        
        <div class="col-md-6 right-side">
        <h3>Client Credential</h3>
        
<!--Form with header-->
<div class="form">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="guestSubmit">

        <div class="form-group" <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label for="form2">Username</label>
            <input type="text" name="username" value="<?php echo $username; ?>" id="form2" class="form-control input-lg">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>

        <div class="form-group" <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label for="form4">Password</label>
            <input type="password" name="password" id="form4" class="form-control input-lg">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <br/>
        <div class="text-xs-center">
            <button id="submitButton" type="submit" class="btn btn-primary"><i class="fa fa-lock" aria-hidden="true"></i> Start Using this Platform</button>
        </div>

 </form>
</div>
<!--/Form with header-->

        </div><!--col-sm-6-->
        
        
        </div><!--col-sm-8-->
        
</div><!--container-->