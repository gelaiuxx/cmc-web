<?php
include_once("connection.php");

$user_id = $_SESSION['user_id'];

$sql = "SELECT appointments.*, patients.first_name, patients.last_name,
               DATE_FORMAT(appointments.time, '%h:%i %p') AS formatted_time
        FROM appointments
        INNER JOIN patients ON appointments.patient_id = patients.patient_id
        WHERE appointments.user_id = $user_id
        LIMIT 10";


$result = mysqli_query($con, $sql);

$response = [];

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = [
                'patient_name' => $row['first_name'] . ' ' . $row['last_name'],
                'type' => $row['category'],
                'schedule' => $row['day']. ' ' . $row['formatted_time'],
                'status' => $row['stat'],
            ];
        }
    }
}

echo json_encode($response);
