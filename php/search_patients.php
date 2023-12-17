<?php
include_once("connection.php");

$searchKey = $_POST['searchKey'];

$sql = "SELECT 
        a.*, 
        p.*
        FROM appointments a
        INNER JOIN patients p ON a.patient_id = p.patient_id
        WHERE a.stat='Done' 
        AND (p.first_name LIKE '%$searchKey%' 
            OR p.last_name LIKE '%$searchKey%' 
            OR p.phone_number LIKE '%$searchKey%' 
            OR p.barangay LIKE '%$searchKey%'
            OR p.municipality LIKE '%$searchKey%'
            OR p.province LIKE '%$searchKey%'
            OR a.chief_complaint LIKE '%$searchKey%')
        GROUP BY p.patient_id";

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
} else {
    $response[] = ['error' => 'Error executing the query: ' . mysqli_error($con)];
}

echo json_encode($response);
?>
