<?php
    include_once("connection.php");

    $retVal = "";
    $isValid = true;
    $status = 400;
    $data = [];

    $email = trim($_REQUEST['email']);
    $password = trim($_REQUEST['password']);

  // Check fields are empty or not
    if($email == '' || $password == ''){
        $isValid = false;
        $retVal = "Please fill all fields.";
    }

  // Check if email is valid or not
    if ($isValid && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
        $retVal = "Invalid email.";
    }

  // Check if email already exists
    if ($isValid) {
    $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $obj = mysqli_fetch_object($result);
    $stmt->close();
    if ($result->num_rows > 0) {
        $isPassword = password_verify($password, $obj->password);
        if ($isPassword == true) {
            $status = 200;
            $data = $obj;
            $_SESSION['user_id'] = $obj->user_id;
            $_SESSION['user_firstName'] = $obj->first_name;
            $_SESSION['user_lastName'] = $obj->last_name;
            $_SESSION['user_email'] = $obj->email;
            $_SESSION['role'] = $obj->role;
            $_SESSION['sex'] = $obj->sex;
            $_SESSION['user_name'] = "$obj->first_name $obj->last_name";

        } else {
            $retVal = "You may have entered a wrong email or password.";

        }
    } else {
        $stmt = $con->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = mysqli_fetch_object($result);
        $stmt->close();
            if ($result->num_rows > 0) {
                $isPassword = password_verify($password, $obj->password);
                if ($isPassword == true){
                    $status = 200;
                    $data = $obj;
                    $_SESSION['admin_id'] = $obj->admin_id;
                    $_SESSION['admin_firstName'] = $obj->first_name;
                    $_SESSION['admin_lastName'] = $obj->last_name;
                    $_SESSION['admin_email'] = $obj->email;
                    $_SESSION['role'] = $obj->role;
                    $_SESSION['admin_name'] = "$obj->first_name $obj->last_name";
    
                } else {
                    $retVal = "Incorrect password.";   
                }
            } else {
                $retVal = "Account does not exist.";   
            } 
    }
}

$myObj = array(
    'status' => $status,
    'data' => $data,
    'message' => $retVal  
);
$myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
echo $myJSON;

?>