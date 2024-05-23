<?php
function db_conn()
{
    $servername = "localhost";
    $username = "u899200555_tuition_manage";
    $password = "Tuition_Manage1";
    $dbname = "u899200555_tuition_manage";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
