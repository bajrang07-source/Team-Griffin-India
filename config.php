<?php
$host = 'localhost';   
$User = 'root';        
$Password = '';          
$Name = 'team_griffin'; 

$conn = new mysqli($host, $User, $Password, $Name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
