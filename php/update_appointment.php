<?php
    include_once("connection.php");

    $retVal = "Update failed.";
    $isValid = true;
    $status = 400;

    $appointment_id = trim($_POST['appointment_id']);
    $patient_name = trim($_POST['patient_name']);
    $category = trim($_POST['category']);
    $date_sched = trim($_POST['date_sched']);
    $stat = trim($_POST['stat']);

    // Update records
    if($isValid){
        try {
            $stmt = $con->prepare("UPDATE appointments SET stat = '$stat' WHERE appointment_id = '$appointment_id'");
            $stmt->execute();
            $stmt->close();
            $status = 200;
            $retVal = "Patient is successfully updated.";
        } catch (Exception $e) {
            $retVal = $e->getMessage();
        }
    }

    $myObj = array(
        'status' => $status,
        'message' => $retVal  
    );

    $myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
    echo $myJSON;
?>