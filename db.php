<?php
    $servername = "sql304.infinityfree.com";
    $username = "if0_35613251";
    $password = "gP6F1UrgMJx54";
    $dbname = "if0_35613251_baldar";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Error connecting to database: " . $conn->connect_error);
    }
    
    function generateRandomString($length = 32) {
        /*
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
        */
        return bin2hex(random_bytes($length / 2));
    }
?>