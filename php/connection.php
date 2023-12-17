<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "hospital_appointment_booking_system_db";

$con = mysqli_connect($host, $user, $password, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
