<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
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
            
            <div id="authenticationForm">
                <form method="POST" action="login.php">
                    <input type="text" name="name" placeholder="User name">
                    <br>
                    <br>
                    <input type="password" placeholder="Password" name="password">
                    <br>
                    <br>
                    <input type="submit" value="Login">
                </form>
            </div>
            
            <hr>
            
            If you're new user <a href="register.php">Register</a>
            
            <?php include "db.php"; ?>
            
            <?php
                $result = $conn->query("select * from user a where a.name='" . (isset($_POST["name"]) ? $_POST["name"] : "") . "' and a.password='" . (isset($_POST["password"]) ? $_POST["password"] : "") . "'");
                
                if ($result != null && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<script>hash = '" . $row["hash"] . "';</script>\n";
                    }
                }
            ?>
            
            <script>
                if (hash != null) {
                    document.getElementById("authenticationForm").innerHTML = "<h3>You're not authorized</h3>";
                    
                    document.location="main.php?hash=" + hash;
                }
            </script>
            
            <?php
                $conn->close();
            ?>
        </center>
    </body>
</html>
