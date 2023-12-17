<?php
session_start();

if(isset($_SESSION["admin_email"])){
        header('location: admin-side-panel/admin_dashboard.php');
    }

if(isset($_SESSION["user_email"])){
    header('location: user-side-panel/user_dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="../imgs/favicon.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link rel="stylesheet" href="../css/login.css">
    <script type="text/javascript" src="../js/authentication.js"></script>

    <title>Login | Cebu Medical Care</title>
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
            <div class="inner-rightform">
                <div class="login-form">
                    <form id="signinForm" method="get" onsubmit="signinSubmit(event)">
                    <h2><b>Welcome to <span style="color: #28844B;">Cebu Medical Care</span>!</b></h2>
                        <div class="inputBox">
                            <div class="label"><label for="email">Email Address</label></div>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    placeholder="Enter email address" 
                                    required ="required">
                        </div>


                        <div class="inputBox">
                            <div class="label"><label for="password">Password</label></div>
                                <input 
                                    maxlength = 12
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    placeholder="Enter password" 
                                    required="required"
                                    oninput="input()">
                                    <i id="pass-toggle-btn" onclick="togglePasswordVisibility(this)" class="fa-solid fa-eye"></i>
                        </div>

                        <div class="forgot_password">
                            <a href="#"><p>Forgot password?</p></a>
                        </div>

                        <div id="errorDiv">
                            <p id="errorMsg"></p>
                        </div>

                        <div class="loginBtn">
                            <button type="submit" id="loginBtn"><span><b style="font-size: 20px;">Login</b></span></button>
                        </div>

                        <div class="noAccount">
                            <p>Don't have an account yet? <span id="toSignUp"><a href="signup.php">Sign Up Here</a></span> </p>
                        </div>  
                    </form>
                </div>
        </div>
    </div>
</body>
</html>
