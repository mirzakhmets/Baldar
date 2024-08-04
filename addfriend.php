<?php

include "db.php";
include "authentication.php";

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

if ($userInformation["id"] != null && $userInformation["id"] == $_GET["id"]) {
    die("");
}

$result = $conn->query("insert into connection(usera, userb) values(" . $userInformation["id"] . ", " . $_GET["id"] . ")");

?>
