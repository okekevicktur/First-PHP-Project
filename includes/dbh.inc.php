<?php
 $dbServerName = "localhost";
 $dbUsername = "root";
 $dbPassword = "";
 $dbDatabase = "biolife";


 $conn = mysqli_connect( $dbServerName, $dbUsername, $dbPassword, $dbDatabase);

 if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
 }