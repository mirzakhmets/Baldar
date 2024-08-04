<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$id = null;

$hash = null;

$userInformation = null;

if (isset($_POST["hash"])) {
    $hash = $_POST["hash"];
} else {
    $hash = $_GET["hash"];
}

//if (!isset($_GET["hash"])) {
if ($hash == null) {
    die("<h3>You're not authorized. <a href='login.php'>Login</a></h3>");
}

$result = $conn->query("select * from user a where a.hash='" . $_GET["hash"] . "'");

if ($result != null && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<script>hash = '" . $row["hash"] . "';</script>\n";
        
        $id = $row["id"];
        
        echo "<script>id = $id;</script>\n";
    }
} else {
    die("<h3>You're not authorized. <a href='login.php'>Login</a></h3>");
}

$result = $conn->query("select * from user where id=$id");

if ($result != null && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $userInformation = $row;
    }
}

?>
