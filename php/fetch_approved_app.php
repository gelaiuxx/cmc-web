<?php
include_once("connection.php");

$today = date("Y-m-d");
$yesterday = date("Y-m-d", strtotime("-1 day"));
$tomorrow = date("Y-m-d", strtotime("+1 day"));
$nextDay = date("Y-m-d", strtotime("+3 day"));


$sql = "SELECT 
        appointments.*, 
        patients.first_name, 
        patients.last_name 
        FROM appointments
        INNER JOIN patients 
        ON appointments.patient_id = patients.patient_id
        WHERE stat = 'approved' AND day = '$nextDay' ";

$result = mysqli_query($con, $sql);

$response = [];
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = [
                'appointment_id' =>$row['appointment_id'],
                'patient_name' => $row['first_name'] . ' ' . $row['last_name'],
                'type' => $row['category'],
                'schedule' => $row['day'],
                'stat' => $row['stat'],
            ];
        }
    } 
}

echo json_encode($response);
?>