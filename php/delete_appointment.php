<?php
    include_once("connection.php");

    $retVal = "Delete failed.";
    $status = 400;

    $appointment_id = trim($_REQUEST['appointment_id']);

    try {
        $stmt = $con->prepare("DELETE FROM appointments WHERE appointment_id = $appointment_id");
        $stmt->execute();
        $stmt->close();
        $status = 200;
        $retVal = "Appointment successfully deleted.";
    } catch (Exception $e) {
        $retVal = $e->getMessage();
    }

    $myObj = array(
        'status' => $status,
        'message' => $retVal
    );

    $myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
    echo $myJSON;
?>