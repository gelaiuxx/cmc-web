<?php 
    include_once("connection.php");
    
    $retVal = "";
    $isValid = true;
    $status = 400;

    $firstName = ucwords(trim($_REQUEST['first_name']));
    $lastName = ucwords(trim($_REQUEST['last_name']));
    $birthdate = ($_REQUEST['date']);
    $sex = strtolower($_REQUEST['sex']);
    $tel = ($_REQUEST['tel']);
    $email = trim($_REQUEST['email']);
    $role = "";
    $password = trim($_REQUEST['password']);
    $confirmpassword = trim($_REQUEST['confirm_password']);

    // Check fields are empty or not
    if ($firstName == "" || $lastName == "" || $birthdate == "" || $sex == "" || $tel == "" || $email == "" || $password == "" || $confirmpassword == "" ) {
        $isValid = false;
        $retVal = "Please fill all fields.";
    }

    //check sex
    if($sex != "male" && $sex !="female"){
        $isValid =false;
        $retVal = "Please input valid sex";
    }

    //check phone number
    if (!preg_match('/^0\d{10}$/', $tel)) {
        $isValid = false;
        $retVal = "Please input valid phone number.";
    }

    // Check if confirm password matching or not
    if($isValid && ($password != $confirmpassword) ){
        $isValid = false;
        $retVal = "Password doesn't match.";
    }

    // Check if email is valid or not
    if ($isValid && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
        $retVal = "Invalid email.";
    }

    // Check if email already exists
    if($isValid){
        $stmt = $con->prepare("SELECT * FROM users WHERE email =?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if($result->num_rows > 0){
            $isValid = false;
            $retVal = "Email already exists.";
        }
    }


    if($isValid){
        $role = 'user-only';
        $insertSQL = "INSERT INTO users (first_name, last_name, birthdate, sex, phone_number, email, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insertSQL);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ssssssss", $firstName, $lastName, $birthdate, $sex, $tel, $email, $password, $role);
        $stmt->execute();
        $stmt->close();
        $retVal = "Account created successfully.";
        unset($_SESSION['user_email']);
        $status = 200;
    }
    


    $myObj = array(
        'status' => $status,
        'message' => $retVal  
    );
    $myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
    echo $myJSON;
?>

