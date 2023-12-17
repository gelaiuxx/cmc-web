<?php
include 'connection.php';

$appointmentId = isset($_GET['appointmentId']) ? $_GET['appointmentId'] : '';

$sqlAppointment = "SELECT CONCAT(patients.first_name, ' ', patients.last_name) AS patient_name,
                   patients.birthdate, patients.phone_number, appointments.queue_no,
                   appointments.category, appointments.day, appointments.day,
                   appointments.chief_complaint, appointments.stat
            FROM appointments
            JOIN patients ON appointments.patient_id = patients.patient_id
            WHERE appointments.appointment_id = $appointmentId";

$resultAppointment = $con->query($sqlAppointment);

if ($resultAppointment && $resultAppointment->num_rows > 0) {
    $row = $resultAppointment->fetch_assoc();
?>
 
  <h1 style="color: var(--primary); font-size: 28px;"><strong>Queue No.:</strong> <?php echo $row['queue_no']; ?></h1>
    <br>
    <p><strong>Name:</strong> <?php echo $row['patient_name']; ?></p>
    <p><strong>Date of Birth:</strong> <?php echo $row['birthdate']; ?></p>
    <p><strong>Phone Number:</strong> <?php echo $row['phone_number']; ?></p>
    <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
    <p><strong>Appointment Date:</strong> <?php echo $row['day']; ?></p>
    <p><strong>Chief Complaint:</strong> <?php echo $row['chief_complaint']; ?></p>
  


            <button class="download-button" onclick="saveAsImage()">Save as image</button>
 
<?php
} else {
    echo "<p>No appointment details found</p>";
}

// Close the database connection
$con->close();
?>