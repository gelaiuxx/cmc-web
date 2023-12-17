<?php
    include 'connection.php';

    if (isset($_POST['day'])) {
        $day = $_POST['day'];
    
        $sql_data = "SELECT appointments.day AS dayToday, COUNT(appointments.queue_no) AS slotsTaken 
        FROM appointments
        WHERE appointments.day = ? && stat = 'pending'";
    
        $stmt = mysqli_prepare($con, $sql_data);
        mysqli_stmt_bind_param($stmt, "s", $day);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
    
        if ($result) {
            $patient = mysqli_fetch_assoc($result);
            echo json_encode($patient);
        } else {
            echo json_encode(['error' => 'Error fetching patient data']);
        }
    
        mysqli_stmt_close($stmt);
        mysqli_close($con);
    } else {
        echo json_encode(['error' => 'Day parameter is not provided']);
    }