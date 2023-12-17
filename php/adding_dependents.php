<?php
include_once("connection.php");
$retVal = "";
$isValid = true;
$status = 400;

// Get form data
$firstName = ucwords(trim($_REQUEST['firstName']));
$lastName = ucwords(trim($_REQUEST['lastName']));
$middleName = ucwords(trim($_REQUEST['middleName']));
$extensionName = ucwords(trim($_REQUEST['extensionName']));

$dob = htmlspecialchars(trim($_REQUEST['dob']));
$civilStatus = ucwords(trim($_REQUEST['civilStatus']));
$sex = ucwords(trim($_REQUEST['sex']));
$religion = ucwords(trim($_REQUEST['religion']));
$nationality = ucwords(trim($_REQUEST['nationality']));
$occupation = ucwords(trim($_REQUEST['occupation']));
$cellphoneNumber = ucwords(trim($_REQUEST['cellphoneNumber']));
$houseLotNo = ucwords(trim($_REQUEST['houseLotNo']));
$street = ucwords(trim($_REQUEST['street']));
$province = ucwords(trim($_REQUEST['province']));
$city = ucwords(trim($_REQUEST['city']));
$barangay = ucwords(trim($_REQUEST['barangay']));
$postalCode = ucwords(trim($_REQUEST['postalCode']));
$spouseName = ucwords(trim($_REQUEST['spouseName']));
$spouseAddress = ucwords(trim($_REQUEST['spouseAddress']));
$fathersName = ucwords(trim($_REQUEST['fathersName']));
$motherMaidenName = ucwords(trim($_REQUEST['motherMaidenName']));

$user_id = $_SESSION['user_id'];


// Check for empty fields
if (empty($firstName) || empty($lastName) || empty($occupation) || empty($fathersName) || empty($religion) || empty($motherMaidenName) || empty($nationality) || empty($dob) || empty($sex) || empty($civilStatus) || empty($cellphoneNumber) || empty($houseLotNo) || empty($street) || empty($province) || empty($city) || empty($barangay) || empty($postalCode)) {
    $isValid = false;
    $retVal = "Please fill all required fields.";
}

// Check phone number
if (!preg_match('/^0\d{10}$/', $cellphoneNumber)) {
    $isValid = false;
    $retVal = "Please input valid phone number.";
}

if (!$isValid) {
    $status = 400;
    $response = array(
        'status' => $status,
        'error_message' => $retVal
    );
} else {
    $sql = "INSERT INTO patients (first_name, middle_name, last_name, extension_name, birthdate, sex, civil_status, postal_code, religion, nationality, occupation, phone_number, house_no, street, barangay, municipality, province, spouse_name, spouse_address, fathers_name, mothers_maiden_name, createdAt, updatedAt, deletedAt, user_id)
    VALUES ('$firstName', '$middleName', '$lastName', '$extensionName', '$dob', '$sex', '$civilStatus', '$postalCode', '$religion', '$nationality', '$occupation', '$cellphoneNumber', '$houseLotNo', '$street', '$barangay', '$city', '$province', '$spouseName', '$spouseAddress', '$fathersName', '$motherMaidenName', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '0000-00-00 00:00:00', $user_id)";

    $stmt = $con->prepare($sql);

    if ($stmt->execute()) {
        $status = 200;
        $retVal = "New dependents record added";
    }

    $stmt->close();

    $response = array(
        'status' => $status,
        'message' => $retVal
    );
}

echo json_encode($response);