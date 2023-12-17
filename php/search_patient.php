<?php
include_once("connection.php");


$searchTerm = $_POST['searchTerm'];

$sql = "SELECT a.*, patients.first_name, patients.last_name 
        FROM appointments a
        INNER JOIN patients ON a.patient_id = patients.patient_id
        WHERE stat = 'Done'
        AND (
            patients.first_name LIKE '%$searchTerm%' 
            OR patients.last_name LIKE '%$searchTerm%' 
            OR a.day LIKE '%$searchTerm%' 
            OR a.category LIKE '%$searchTerm%'
        )";
        
$result = mysqli_query($con, $sql);

$response = [];

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = [
                'appointmentId' => $row['appointment_id'],
                'patient_name' => $row['first_name'] . ' ' . $row['last_name'],
                'type' => $row['category'],
                'schedule' => $row['day'],
                'status' => $row['stat'],
            ];
        } 
    } 
} else {
    $response[] = ['error' => 'Error executing the query: ' . mysqli_error($con)];
}

echo json_encode($response);
?>