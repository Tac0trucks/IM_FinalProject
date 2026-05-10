<?php
$servername = "localhost";
$username = "root"; 
$password = "admin";     
$dbname = "cit_university_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// If you see nothing when loading this, the connection was successful!
?>