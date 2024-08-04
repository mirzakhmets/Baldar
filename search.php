<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Search</title>
        <link rel="icon" type="image/jpeg" href="images/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script>
            var hash = null, id = null;
            
            function searchButtonFormClicked() {
                document.location = "search.php?hash=" + hash
                    + "&type=" + document.getElementById("searchTypeForm").value
                    + "&what=" + document.getElementById("searchQueryForm").value;
            }
        </script>
    </head>
    <body>
        <?php include "db.php"; ?>
        <?php include "authentication.php"; ?>
        
        <?php
            $type = isset($_GET["type"]) ? $_GET["type"] : "";
            
            $what = isset($_GET["what"]) ? $_GET["what"] : "";
        ?>
        
        <center>
            Search:
            
            <select id="searchTypeForm">
                <option value="users" <?php if ($type == "users") echo "selected"; ?>>Users</option>
                <option value="messages" <?php if ($type == "messages" || $type == "") echo "selected"; ?>>Messages</option>
            </select>
            
            <input type="text" placeholder="Search string" id="searchQueryForm">
            
            <?php
                echo "<script>document.getElementById('searchQueryForm').value = '" . $what . "'</script>";
            ?>
            
            <input type="button" id="searchButtonForm" value="Search" onclick="searchButtonFormClicked();">
            
            <hr>
            
            <table>
                <?php
                    $result = null;
                
                    echo "<tr><td>User</td><td>Text</td></tr>";
                    
                    if ($type == "users") {
                        $result = $conn->query("select id, name, comment as text from user where instr(lower(comment), lower('" . $what . "')) > 0");
                    } else {
                        $result = $conn->query("select m.user as id, u.name, m.text from message m "
                                . " inner join user u on u.id = m.user where instr(lower(text), lower('" . $what . "')) > 0");
                    }
                    
                    if ($result != null && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td><a href='profile.php?hash=" . $hash . "&id=" . $row["id"] . "'>" . $row["name"] . "</a></td>"
                                    . "<td>" . $row["text"] . "</td></tr>";
                        }
                    }
                ?>
            </table>
        </center>
    </body>
</html>
