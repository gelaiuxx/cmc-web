<?php
include_once("connection.php");


$user_id = $_SESSION['user_id'];

$sql = "SELECT a.*, p.first_name, p.last_name,
               DATE_FORMAT(a.time, '%h:%i %p') AS formatted_time
        FROM appointments a
        INNER JOIN patients p ON a.patient_id = p.patient_id
        WHERE stat = 'Done' AND a.user_id = $user_id  
        ORDER BY a.day DESC";

$result = mysqli_query($con, $sql);

$response = [];

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = [
                'appointmentId' => $row['appointment_id'],
                'patient_name' => $row['first_name'] . ' ' . $row['last_name'],
                'type' => $row['category'],
                'schedule' => $row['day'] . ' ' . $row['formatted_time'],
                'status' => $row['stat'],
            ];
            
        }

    }
}
echo json_encode($response);
?>
