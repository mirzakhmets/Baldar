<?php

include "db.php";
include "authentication.php";

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$result = $conn->query("insert into message(user, text) values(" . $userInformation["id"] . ", '" . $_GET["text"] . "')");

echo $result;

?>
