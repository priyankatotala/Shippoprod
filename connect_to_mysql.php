<?php
$servername = "localhost";
$username = "root";
$password = "Primus666!!";
$db = "proj";

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    die("Connection Error: " . mysqli_connect_error());
}
