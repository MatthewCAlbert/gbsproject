<?php
    $cred_path = $_SERVER['DOCUMENT_ROOT'].'/gbs-admin/include/servercred.php';
    require "$cred_path";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
?>