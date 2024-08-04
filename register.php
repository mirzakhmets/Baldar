<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registration</title>
        <link rel="icon" type="image/jpeg" href="images/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script>
            var hash = null, id = null;
        </script>
    </head>
    <body>
        <center>
            <img src="images/Logo.jpg">
            
            <br>
            
            <br>
            
            <hr>
            
            <div id="registrationForm">
                <form method="POST" action="register.php">
                    <input type="text" name="name" placeholder="User name">
                    <br>
                    <br>
                    <input type="password" placeholder="Password" name="password">
                    <br>
                    <br>
                    <input type="submit" value="Register">
                </form>
            </div>
            
            <?php include "db.php"; ?>
            
            <?php
                if (isset($_POST["name"]) && isset($_POST["password"]) && $_POST["name"] != "") {
                    $result = $conn->query("select * from user a where a.name='" . $_POST["name"]. "'");

                    if ($result != null && $result->num_rows > 0) {
                        echo "<h3>User already registered</h3>";
                    } else {
                        $hash = generateRandomString();
                        $result = $conn->query("insert into user(name, password, hash) values('" . $_POST["name"] . "', '" . $_POST["password"] . "', '" . $hash . "')");

                        if ($result === TRUE) {
                            echo "<script>hash = '" . $hash . "';</script>";
                        } else {

                        }
                    }
                }
            ?>
            
            <script>
                if (hash != null) {
                    document.getElementById("registrationForm").innerHTML = "<h3>You're registered</h3>";
                    
                    document.location="main.php?hash=" + hash;
                }
            </script>
            
            <?php
                $conn->close();
            ?>
        </center>
    </body>
</html>
