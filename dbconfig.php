<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "STUDENTS";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, 8443);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}