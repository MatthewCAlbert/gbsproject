<?php
    date_default_timezone_set('Asia/Jakarta');
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gbsmoneydb";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    unset($servername,$username,$password,$dbname);