<?php
session_start();

if(isset($_SESSION['username'])){
  header("location: ./dashboard?view=0");
  exit;
}
?>
<?php require_once './includes/config.php'; ?>
<?php require_once './includes/login.php'; ?>
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
</head>
<body>
<?php include_once "./views/login.php" ?> 

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
<script src="./public/js/custom.js" type="text/javascript"></script>   
</body>
</html>