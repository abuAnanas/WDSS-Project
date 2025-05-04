<?php
/* Code adapted from databaseConfig.php from BrightSpace Software Engineering & Testing Lecture 4 */

$servername = "localhost"; 
$username = "root"; 
$password = "toor";
$dbname = "custombuilt"; 

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Database Connection Successful<br/><br/>";
}
?>
