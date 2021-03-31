<!DOCTYPE html>
<html>
    <head>
      <title>HMS Hospitals</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
    </head>
    <body>
       <div class="header">
       
          <div class="header-left">
          
          <a href="login.php">Home</a>

          </div>

          <div class = "header-right">
          <?php
                if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
          ?>
          <a href="login.php">Log in</a>
                <?php }
            else { ?>
            <a href="logout.php">Log Out</a>
          <?php }?>

            </div>
            
      </div>