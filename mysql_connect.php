<?php
define("servername" , "localhost");
define("username" , "root");
define("password" ,"");
define("db" , "student-grade-db");
// Create connection
  $conn = new mysqli(servername, username, password,db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
