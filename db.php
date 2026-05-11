<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "admin"; // Make sure this is your Workbench password!
$dbname = "cit_university_db";

// THIS IS THE IMPORTANT LINE:
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>