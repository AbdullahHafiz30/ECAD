<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ecad";

$conn =  mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    echo 'Error:' . mysqli_connect_error();
}
?>
