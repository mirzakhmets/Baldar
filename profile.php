<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>User profile</title>
        <link rel="icon" type="image/jpeg" href="images/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script>
            var hash = null, id = null;
            
            function updateUserInformation() {
                var xhttp = new XMLHttpRequest();
                
                xhttp.open("GET", "updateuser.php?hash=" + hash + "&id=" + <?php echo $_GET["id"]; ?>
                        + "&name=" + document.getElementById("profileNameEditable").value
                        + "&comment=" + document.getElementById("profileCommentEditable").value);
                
                xhttp.send();
            }
            
            function profilePreviewSelectClicked() {
                if (document.getElementById("profilePreviewSelect").checked) {
                    document.getElementById("profileComment").style.display = "block";
                    document.getElementById("profileCommentEditable").style.display = "none";
                    document.getElementById("profileComment").innerHTML = document.getElementById("profileCommentEditable").value;
                } else {
                    document.getElementById("profileComment").style.display = "none";
                    document.getElementById("profileCommentEditable").style.display = "block";
                }
            }
            
            function addToFriends() {
                var xhttp = new XMLHttpRequest();
                
                xhttp.open("GET", "addfriend.php?hash=" + hash + "&id=" + <?php echo $_GET["id"]; ?>);
                
                xhttp.send();
            }
        </script>
    </head>
    <body>
        <?php include "db.php"; ?>
        <?php include "authentication.php"; ?>
        
        <center>
            <div id="profileMainView">
                <?php
                    if ($userInformation["id"] == $_GET["id"]) {
                        echo "Your name:";
                    } else {
                        echo "User name:";
                    }
                    
                    $profileUser = null;
                    
                    $result = $conn->query("select * from user a where a.id=" . $_GET["id"]);

                    if ($result != null && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $profileUser = $row;
                        }
                    } else {
                        die("<h3>User not registered</h3>");
                    }
                ?>
                
                <br>
                
                <div id="profileName"><h4><?php echo $profileUser["name"];?></h4></div>
                
                <input type="text" id="profileNameEditable" value="<?php echo $profileUser["name"]; ?>">
                
                <br>
                
                <br>
                
                <?php
                    if ($userInformation["id"] == $_GET["id"]) {
                        echo "Tell about yourself:";
                    } else {
                        echo "Information about user:";
                    }
                ?>
                
                <br>
                
                <div id="preview">
                    <input type="checkbox" id="profilePreviewSelect" onclick="profilePreviewSelectClicked();">
                    Preview
                </div>
                
                <br>
                
                <div id="profileComment"><?php echo $profileUser["comment"];?></div>
                
                <textarea id="profileCommentEditable" cols="60" rows="4"><?php echo $profileUser["comment"]; ?></textarea>
                
                <br>
                
                <br>
                
                <?php
                    if ($userInformation["id"] == $_GET["id"]) {
                        echo "<input type='button' value='Update information' onclick='updateUserInformation();'>";
                        
                        echo "<script>document.getElementById('profileName').style.display = 'none';</script>";
                        echo "<script>document.getElementById('profileComment').style.display = 'none';</script>";
                    } else {
                        echo "<input type='button' value='Add to friends' onclick='addToFriends();'>";
                        
                        echo "<script>document.getElementById('profileNameEditable').style.display = 'none';</script>";
                        echo "<script>document.getElementById('profileCommentEditable').style.display = 'none';</script>";
                        echo "<script>document.getElementById('profilePreviewSelect').click();</script>";
                        echo "<script>document.getElementById('preview').style.display = 'none';</script>";
                    }
                ?>
                
                <br>
            </div>
            
            <hr>
            
            <div id="connectionView">
                
                User friends:
                
                <br>
                
                <table>
                    <?php
                        $result = $conn->query(
                            "select * from user where id in "
                                . "(select userb from connection where usera=" . $profileUser["id"]
                                . " union select usera from connection where userb=" . $profileUser["id"] . ") and id != "
                                . $profileUser["id"]);
                        
                        if ($result != null && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr><td><a href='profile.php?hash=" . $hash . "&id=" . $row["id"] . "'>" . $row["name"] . "</a></td></tr>";
                            }
                        } else {
                            echo "User has no friends";
                        }
                    ?>
        
                </table>
            </div>            
        </center>
    </body>
</html>
