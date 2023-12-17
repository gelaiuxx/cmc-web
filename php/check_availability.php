<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_date = $_POST['appointmentDate'];
    // $category = $_POST['category'];


    $response = [];

    $sqlCountAppointments = "SELECT COUNT(*) AS appointmentCount FROM appointments WHERE day = '$appointment_date'";
    $resultCount = $con->query($sqlCountAppointments);

    // $sqlCountAppointments = "SELECT COUNT(*) AS appointmentCount FROM appointments WHERE day = '$appointment_date' AND category = '$category'";
    // $resultCount = $con->query($sqlCountAppointments);

    if ($resultCount && $rowCount = $resultCount->fetch_assoc()) {
        $dailyLimit = 10;

        if ($rowCount['appointmentCount'] >= $dailyLimit) {
            echo json_encode(['success' => false, 'message' => 'Sorry, our appointments for this date are all booked. Kindly refer to the table and select an alternative date. Thank you!']);
            exit;
        } else {
            echo json_encode(['success' => true]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error counting appointments']);
    }

    $con->close();
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
