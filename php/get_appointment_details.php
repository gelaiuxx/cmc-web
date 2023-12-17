<?php
// Assuming you have a database connection established
$host = "localhost";
$username = "root";
$password = "";

$dbname = "hospital_appointment_booking_system_db";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Function to fetch appointment details from the database
    function getAppointmentDetails($appointmentId, $pdo)
    {
        $query = "SELECT a.appointment_id, a.queue_no, a.patient_id, a.category, 
        a.day, a.cheif_complaint, a.stat, a.user_id, p.first_name, p.middle_name, p.last_name, , p.birthdate
  FROM appointments a
  INNER JOIN patients p ON a.patient_id = p.patient_id
  WHERE a.appointment_id = :appointmentId";


        $statement = $pdo->prepare($query);
        $statement->bindParam(':appointmentId', $appointmentId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // Get the appointment ID from the query parameters
    $appointmentId = isset($_GET['appointmentId']) ? intval($_GET['appointmentId']) : 0;

    if ($appointmentId > 0) {
        $appointmentDetails = getAppointmentDetails($appointmentId, $pdo);

        if ($appointmentDetails) {
            // Return the result as JSON
            header('Content-Type: application/json');
            echo json_encode($appointmentDetails);
        } else {
            // Return an error message if the appointment is not found
            echo json_encode(array('error' => 'Appointment not found.'));
        }
    } else {
        // Return an error message if the appointment ID is not provided
        echo json_encode(array('error' => 'Appointment ID not provided.'));
    }
} catch (PDOException $e) {
    // Output any PDO exceptions for debugging
    echo json_encode(array('error' => 'Database error: ' . $e->getMessage()));
}
