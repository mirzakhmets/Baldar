<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Messages</title>
        <link rel="icon" type="image/jpeg" href="images/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script>
            var hash = null, id = null, what = null;
            
            function messagePreviewButtonClicked() {
                if (document.getElementById("messagePreviewButton").checked) {
                    document.getElementById("messagePreview").style.display = "block";
                    document.getElementById("messageText").style.display = "none";
                } else {
                    document.getElementById("messagePreview").style.display = "none";
                    document.getElementById("messageText").style.display = "block";
                }
                
                document.getElementById("messagePreview").innerHTML = document.getElementById("messageText").value;
            }
            
            function getWhat() {
                what = document.getElementById("whatFormValue").value;
            }
            
            function pageSelectClicked() {
                var page = parseInt(document.getElementById("pageNumber").value);
                
                getWhat();
                
                document.location = "message.php?hash=" + hash
                        + (what != null && what != "" ? "&what=" + what : "")
                        + (page != null && page != '' ? "&page=" + page : "");
            }
            
            function pagePrevSelectClicked() {
                var page = parseInt(document.getElementById("pageNumber").value);

                getWhat();

                document.location = "message.php?hash=" + hash
                        + (what != null && what != "" ? "&what=" + what : "")
                        + (page != null && page > 0 ? "&page=" + (page - 1) : "");
            }
            
            function pageNextSelectClicked() {
                var page = parseInt(document.getElementById("pageNumber").value);

                getWhat();

                document.location = "message.php?hash=" + hash
                        + (what != null && what != "" ? "&what=" + what : "")
                        + (page != null ? "&page=" + (page + 1) : "");
            }
            
            function newMessageClicked() {
                var xhttp = new XMLHttpRequest();
                
                xhttp.onreadystatechange = function() {
                    document.location.reload();
                };
                
                xhttp.open("GET", "newmessage.php?hash=" + hash + "&text=" + document.getElementById("messageText").value);
                
                xhttp.send();
            }
        </script>
    </head>
    <body>
        <?php include "db.php"; ?>
        <?php include "authentication.php"; ?>
        <?php include "settings.php"; ?>
        
        <?php
            $hash = $_GET["hash"];
            
            $what = isset($_GET["what"]) ? $_GET["what"] : "";
            
            $page = isset($_GET["page"]) ? $_GET["page"] : "";
            
            if ($page == null) {
                $page = 0;
            }
            
            echo "<script>what = '" . $what . "';</script>";
        ?>
        
        <center>
            <div id="messageList">
                New message:

                <br>
                
                <input type="checkbox" id="messagePreviewButton" onclick="messagePreviewButtonClicked();"> Preview
                
                <br>
                
                <div id="messagePreview" style="display:none"></div>
                
                <textarea id="messageText" cols="60" rows="4"></textarea>
                
                <br>
                
                <input type="button" id="newMessage" onclick="newMessageClicked();" value="Создать">
                
                <hr>
                
                <input type="button" value="<<" id="pagePrevSelect" onclick="pagePrevSelectClicked();">
                <input type="text" value="<?php echo $page == null || $page == '' ? 0 : $page; ?>" id="pageNumber">
                <input type="button" value=">>" id="pageNextSelect" onclick="pageNextSelectClicked();">
                <select id="whatFormValue">
                    <option value="all" <?php if ($what == "all") echo "selected"; ?>>All</option>
                    <option value="friends" <?php if ($what == "friends") echo "selected"; ?>>Friends</option>
                    <option value="" <?php if ($what == "") echo "selected"; ?>>Mine</option>
                </select>
                <input type="button" value="Select" id="pageSelect" onclick="pageSelectClicked();">
                
                <br>
                
                <?php
                    $result = null;
                    
                    if ($what == "all") {
                        $result = $conn->query("select u.id, u.name, m.text from message m"
                                . " inner join user u on m.user = u.id "
                                . " order by m.id desc "
                                . " limit " . $MESSAGE_PAGE_COUNT . " offset " . ($MESSAGE_PAGE_COUNT * $page));
                    } else if ($what == "friends") {
                        $result = $conn->query("select u.id, u.name, m.text from message m"
                                . " inner join user u on m.user = u.id "
                                . " where m.user in (select usera from connection where userb=" . $id . ""
                                . " union select userb from connection where usera=" . $id . ")"
                                . " order by m.id desc "
                                . " limit " . $MESSAGE_PAGE_COUNT . " offset " . ($MESSAGE_PAGE_COUNT * $page));
                    } else {
                        $result = $conn->query("select u.id, u.name, m.text from message m"
                                . " inner join user u on m.user = u.id "
                                . " where u.id = " . $id
                                . " order by m.id desc "
                                . " limit " . $MESSAGE_PAGE_COUNT . " offset " . ($MESSAGE_PAGE_COUNT * $page));
                    }
                    
                    if ($result != null && $result->num_rows > 0) {
                        echo "<table>";
                        echo "<tr><td>User</td><td>Message</td></tr>";
                        
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            
                            echo "<td>";
                            
                            echo "<a href='profile.php?hash=" . $hash . "&id=" . $row["id"] . "'>" . $row["name"] . "</a>";
                            
                            echo "</td>";
                            
                            echo "<td>";
                            
                            echo $row["text"];
                            
                            echo "</td>";
                            
                            echo "</tr>";
                        }
                        
                        echo "</table>";
                    }
                ?>
                
            </div>            
        </center>
    </body>
</html>
