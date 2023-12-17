<?php
session_start();

if(isset($_SESSION["admin_email"])){
    header('location: ../public/admin-side-panel/admin_dashboard.php');
}

if(isset($_SESSION["user_email"])){
    header('location: ../public/user-side-panel/admin_dashboard.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="../imgs/favicon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link rel="stylesheet" href="../css/signup.css">
    <script type="text/javascript" src="../js/authentication.js"></script>

    <title>Sign up | Cebu Medical Care</title>
</head>

<body>

    <div class="formbox">
        <div class="leftform-box">
            <div class="headline">
                <div class="logobox">
                    <img src="../imgs/logo.png" alt="logo">
                </div>

                <div class="headlinebox">
                    <div class="title_name">
                        <h1>CEBU MEDICAL CARE</h1>
                    </div>

                    <div class="tagline">
                        <p>YOUR HEALTH IS OUR PRIORITY!</p>
                    </div>
                </div>
            </div>

            <div class="picture-box">
                <img src="../imgs/medical.png" alt="medical-picture">
            </div>
        </div>
        <div class="rightform-box">
            <div id="errorDiv">
                <p id="errorMsg"></p>
            </div>

            <div class="inner-right-form">
                <div class="register">
                    <h2></b>Register <span style="color: #28844B;">Cebu Medical Care</span>!</b></h2>
                </div>
                <form id="signupForm" method="post" onsubmit="signupSubmit(event)">
                    <div class="inputBox-info">
                        <div class="inputBox info">
                            <div class="firstName">
                                <div class="label"><label for="first_name">First Name</label></div>
                                <input type="text" name="first_name" id="first_name" placeholder="Enter first name" required="required">
                            </div>

                            <div class="lastName">
                                <div class="label"><label for="last_name">Last Name</label></div>
                                <input type="text" name="last_name" id="last_name" placeholder="Enter last name" required="required">
                            </div>
                        </div>

                        <div class="inputBox info">
                            <div class="birthdate">
                                <div class="label"><label for="birthdate">Birth of Date</label></div>
                                <input type="date" name="date" id="date" placeholder="" required="required">
                            </div>

                            <div class="sex">
                                <div class="label"><label for="sex">Sex</label></div>
                                <input maxlength="6" type="text" name="sex" id="sex" placeholder="Female" required="required">
                            </div>
                        </div>
                    </div>

                    <div class="inputBox-pass">
                        <div class="inputBox">
                            <div class="label"><label for="phone_number">Phone Number</label></div>
                            <input maxlength="11" type="tel" name="tel" id="tel" placeholder="Enter phone number" required="required">
                        </div>

                        <div class="inputBox">
                            <div class="label"><label for="email">Email Address</label></div>
                            <input type="email" name="email" id="email" placeholder="Enter email address" required="required">
                        </div>

                        <div class="inputBox">
                            <div class="label"><label for="password">Password</label></div>
                            <input maxlength=12 type="password" name="password" id="password" placeholder="Enter password" required="required" oninput="input()">
                            <i id="pass-toggle-btn" onclick="togglePasswordVisibility(this)" class="fa-solid fa-eye"></i>
                        </div>

                        <div class="inputBox">
                            <div class="label"><label for="confirm_password">Confirm Password</label></div>
                            <input maxlength=12 type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required="required" oninput="input()">
                            <i id="pass-toggle-btn-two" onclick="togglePasswordVisibility(this)" class="fa-solid fa-eye"></i>
                        </div>

                        <div class="signUpBtn">
                            <button type="submit" id="signUpBtn"><b style="font-size: 20px">Register</b></button>
                        </div>
                </form>

                <div class="hasAccount">
                    <p>Already have an account ? <span id="toSignIn"><a href="index.php">Log In</a></span> </p>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>

</html>