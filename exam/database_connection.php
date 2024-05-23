<?php
    // Connection details
    $host = "localhost";
    $user = "ishimwe";
    $pass = "222005870";
    $database = "online_debt_managment_course_platform";

    // Creating connection
    $connection = new mysqli($host, $user, $pass, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }