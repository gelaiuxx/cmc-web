<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "hospital_appointment_booking_system_db";

// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

// Fetch dependent data from the database
$sql = "SELECT * FROM patients WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Check if there are dependents
    if (mysqli_num_rows($result) > 0) {
        // Loop through each dependent record
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            $dob = new DateTime($row['birthdate']);
            $today = new DateTime();
            $age = $dob->diff($today)->y;
            $sex = $row['sex'];
            $patientId = $row['patient_id'];

            // Output HTML for each dependent
            echo '<div class="dependent-card">';
            echo "<p>Name: $name</p>";
            echo "<p>Age: $age</p>";
            echo "<p>Sex: $sex</p>";
            echo '<button class="btn make-appointment-btn" data-patient-id="' . $row['patient_id'] . '">Make Appointment</button>';
            echo '</div>';
        }
    } else {
        echo '<img src="../../imgs/noDependents.png" alt="No dependents image">';
     
    }

    mysqli_free_result($result);
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
