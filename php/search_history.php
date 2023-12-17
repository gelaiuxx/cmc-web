<?php
include_once("connection.php");

$user_id = $_SESSION['user_id'];
$searchTerm = $_POST['searchTerm'];

$sql = "SELECT a.*, patients.first_name, patients.last_name 
        FROM appointments a
        INNER JOIN patients ON a.patient_id = patients.patient_id
        WHERE stat = 'Done' AND a.user_id = $user_id
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
    } else {
        $response[] = [
            'appointmentId' =>'',
            'patient_name' =>'',
            'type' => '',
            'schedule' => '<img src="../../imgs/noresult.png" alt="No dependents image">',
            'status' => '',
        ];
    }
} else {
    $response[] = ['error' => 'Error executing the query: ' . mysqli_error($con)];
}

echo json_encode($response);
?>
