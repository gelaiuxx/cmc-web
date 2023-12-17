<?php
include_once("connection.php");

$sql = "SELECT 
        appointments.*, 
        patients.*
        FROM appointments
        INNER JOIN patients ON appointments.patient_id = patients.patient_id
        GROUP BY patients.patient_id";

$result = mysqli_query($con, $sql);

$response = [];
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = [
                'name' => $row['first_name'] . ' ' . $row['last_name'],
                'birthdate' => $row['birthdate'],
                'sex' => $row['sex'],
                'phone' => $row['phone_number'],
                'barangay' => $row['barangay'],
                'municipality' => $row['municipality'],
                'province' => $row['province'],
                'type' => $row['chief_complaint'],
            ];
        }
    } 
}
echo json_encode($response);
?>