<?php
session_start();
if (!isset($_SESSION["user_email"])) {
    header('Location: ../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMC | Welcome to CMC Service Portal!</title>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script type="text/javascript" src="../js/authentication.js"></script>
    <link rel="icon" type="image/x-icon" href="../../imgs/favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>


    <!-- Add other meta tags and stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />



    <link rel="stylesheet" href="../../css/style.css">




</head>

<body>

    <!-- =============== Navigation Sidebar ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="user_dashboard.php">
                        <div class="logo">
                            <img src="../../imgs/sidebarlogo.png" alt="">
                        </div>
                    </a>
                </li>

                <li style="background-color: #FBF5EE; font-size: 25px">
                    <a href="user_dashboard.php">
                        <span class="icon">
                            <ion-icon name="home"></ion-icon>
                        </span>
                        <span class="title">Home</span>
                    </a>
                </li>

                <li>
                    <a href="availableSlots.php">
                        <span class="icon">
                            <ion-icon name="time-outline"></ion-icon>
                        </span>
                        <span class="title">Available Slots</span>
                    </a>
                </li>

                <li>
                    <a href="myAppointments.php">
                        <span class="icon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </span>
                        <span class="title">My Appointments</span>
                    </a>
                </li>

                <li>
                    <a href="myHistory.php">
                        <span class="icon">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">My History</span>
                    </a>
                </li>

                <li>
                <a onclick="signoutClick(event)" id="logout">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>


        <!-- ========================= Main ==================== -->
        <div class="main">

            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="user-dropdown">
                    <div class="user">
                        <?php
                        if ($_SESSION['sex'] === 'male') {
                            echo '<img src="../../imgs/male.png" alt="user-male">';
                        } else {
                            echo  '<img src="../../imgs/female.png" alt="user-female">';
                        }
                        ?>
                        <div class="user-info">
                            <p class="user-name">
                                <?php
                                echo $_SESSION['user_name'];
                                ?>
                            </p>
                            <p class="user-email">
                                <?php
                                echo $_SESSION['user_email'];
                                ?>
                            </p>
                        </div>
                    </div>

                    <div class="dropdown-content">
                        <a href="myAppointments.php" class="appointments">
                            <ion-icon class="icon" name="calendar-outline"></ion-icon> My Appointments
                        </a>
                        <a href="availableSlots.php" class="slots">
                            <ion-icon class="icon" name="time-outline"></ion-icon> Available Slots
                        </a>
                        <a href="myHistory.php" class="history">
                            <ion-icon class="icon" name="document-text-outline"></ion-icon> My History
                        </a>
                        <a href="#" class="logout" onclick="signoutClick(event)">
                            <ion-icon class="icon" name="log-out-outline"></ion-icon> Sign out
                        </a>
                    </div>
                </div>
            </div>

            <div class="dashboard-header">
                <div class="dashboard-greeting">
                    <span style="color: #020303;">Hello</span>,
                    <span style="color: #28844B;">
                        <?php
                        echo $_SESSION['user_name'];
                        ?>
                    </span>!
                    <div class="message">
                        Welcome to CMC Service Portal! Your health is our top priority. </div>
                </div>

                <div class="img">
                    <img src="../../imgs/abstract.png" alt="">
                </div>
            </div>







            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="patients-catered" id="patients-catered">
                            10
                            <!-- ================ AJAX ONLOAD DATA FETCH ================= -->
                        </div>
                        <div class="cardName">No. of Patients Catered per day</div>
                    </div>

                    <div class="iconBx">
                        <a href="#" class="iconBx">
                            <ion-icon name="people-outline"></ion-icon>
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="patients-today" id="patients-today">

                            <!-- ================ AJAX ONLOAD DATA FETCH ================= -->
                        </div>
                        <div class="cardName">No. of Patients Today</div>
                    </div>

                    <div class="iconBx">
                        <a href="#" class="iconBx">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="patients-tomorrow" id="patients-tomorrow">


                            <!-- ================ AJAX ONLOAD DATA FETCH ================= -->
                        </div>
                        <div class="cardName">No. of Patients for Tomorrow</div>
                    </div>

                    <div class="iconBx">
                        <a href="#" class="iconBx">
                            <ion-icon name="arrow-forward-outline"></ion-icon>
                        </a>
                    </div>
                </div>


                <div class="card">
                    <div>
                        <div class="patients-yesterday" id="patients-yesterday">

                            16
                            <!-- ================ AJAX ONLOAD DATA FETCH ================= -->
                        </div>
                        <div class="cardName">No. of Patients Yesterday</div>
                    </div>

                    <div class="iconBx">
                        <a href="#" class="iconBx">
                            <ion-icon name="time-outline"></ion-icon>
                        </a>
                    </div>
                </div>


            </div>

            <!-- ================ Appointments Table Section ================= -->
            <div class="details">
                <div class="appointmentsContainer">
                    <div class="cardHeader">
                        <h2>Your Appointments</h2>

                        <a href="myAppointments.php" class="btn">
                            <ion-icon name="eye-outline"></ion-icon> View
                        </a>

                    </div>

                    <table id="appointmentsTable">
                        <thead>
                            <tr>
                                <td>Patient Name</td>
                                <td>Category</td>
                                <td>Consultation Schedule</td>
                                <td>Status</td>

                            </tr>
                        </thead>


                        <tbody>
                
                        </tbody>
                    </table>
                </div>


                <div class="wrapper">
                    <div class="make-appointment">
                        <div class="header-section">
                            <h2>Make Appointment</h2>
                            <p>Make a new appointment</p>
                        </div>
                        <div class="button-section">
                            <a href="myAppointments.php" class="iconBx">

                                <button class="icon-button"><ion-icon name="add"></ion-icon></button>

                            </a>
                        </div>
                    </div>


                    <div class="calendar-container">
                        <header>
                            <div class="current-date"></div>
                            <div class="icons">
                                <span id="prev" class="material-symbols-rounded">chevron_left</span>
                                <span id="next" class="material-symbols-rounded">chevron_right</span>
                            </div>
                        </header>
                        <div class="calendar">
                            <ul class="weeks">
                                <li>Sun</li>
                                <li>Mon</li>
                                <li>Tue</li>
                                <li>Wed</li>
                                <li>Thu</li>
                                <li>Fri</li>
                                <li>Sat</li>
                            </ul>
                            <ul class="days"></ul>
                        </div>
                    </div>


                </div>



            </div>
        </div>

    </div>
    </div>
    </div>


    <!-- =========== Scripts =========  -->
    <script src="../../js/main.js"></script>
    <script src="../../js/script.js"></script>
    <script src="../../js/authentication.js"></script>






</body>

</html>