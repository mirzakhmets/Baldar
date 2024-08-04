<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Main page</title>
        <link rel="icon" type="image/jpeg" href="images/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script>
            var hash = null, id = null;
        </script>
    </head>
    <body>
        <?php include "db.php"; ?>
        <?php include "authentication.php"; ?>
        
        <center>
            <img src="images/Logo.jpg">
            
            <br>
            
            <br>
            
            <hr>
            
            <div id="profile">
                <iframe id="profileFrame" width="100%" height="320" src="profile.php?hash=<?php echo $hash . "&id=" . $userInformation["id"]; ?>">
                </iframe>
            </div>
            
            <div id="message">
                <iframe id="messageFrame" width="100%" height="320" src="message.php?hash=<?php echo $hash; ?>">
                </iframe>
            </div>
            
            <div id="search">
                <iframe id="searchFrame" width="100%" height="320" src="search.php?hash=<?php echo $hash; ?>">
                </iframe>
            </div>
            
        </center>
    </body>
</html>
