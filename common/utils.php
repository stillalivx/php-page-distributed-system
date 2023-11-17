<?php

const URL = "http://rh-master.com/";

function conn_database() {
    $servername = "localhost";
    $username = "repl";
    $password = "pass";
    $dbname = "RH";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}