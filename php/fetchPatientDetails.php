<?php
include 'connection.php';

$patientId = isset($_GET['patientId']) ? $_GET['patientId'] : '';

$sql = "SELECT * FROM patients WHERE patient_id = $patientId";
$result = $con->query($sql);

if ($result && $result->num_rows > 0) {
    $patientDetails = $result->fetch_assoc();
    echo json_encode($patientDetails);
} else {
    echo json_encode(array());
}

// Close the database connection
$con->close();
?>
