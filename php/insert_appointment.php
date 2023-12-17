<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientId = $_POST['patientId'];
    $category = $_POST['category'];
    $appointmentDate = $_POST['appointmentDate'];
    $chiefComplaint = $_POST['chiefComplaint'];
    $time = $_POST['time'];

    $user_id = $_SESSION["user_id"];

    $response = [];

    $sqlInsert = "INSERT INTO appointments (patient_id, category, day, cheif_complaint, stat, time, user_id)
        VALUES ('$patientId', '$category', '$appointmentDate', '$chiefComplaint', 'Pending', '$time', $user_id)";

    if ($con->query($sqlInsert) === TRUE) {
        $appointment_id = $con->insert_id;

        $sqlFetch = "SELECT
        a.queue_no,
        a.category,
        p.first_name,
        p.last_name,
        a.day 
    FROM
        appointments a
    JOIN
        patients p ON a.patient_id = p.patient_id
    WHERE
        a.appointment_id = $appointment_id";


        $result = $con->query($sqlFetch);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();


            $additionalData = [
                'success' => true,
                'appointmentId' => $appointment_id,
                'queueNumber' => $row['queue_no'],
                'category' => $row['category'],
                'patientName' => $row['first_name'] . ' ' . $row['last_name'],
                'appointmentDate' => $row['day']
            ];

            // Output the additional data as JSON
            echo json_encode($additionalData);
        } else {
            // Output an error message as JSON
            echo json_encode(['error' => 'No additional data found']);
        }
    } else {
        // Output the error message directly
        echo json_encode(['success' => false, 'message' => 'Error adding appointment: ' . $con->error]);
    }

    // Close the database connection
    $con->close();
} else {
    // Handle invalid request method
    echo json_encode(['error' => 'Invalid request method']);
}
