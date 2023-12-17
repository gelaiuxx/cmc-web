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
    <title>CMC | My History</title>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script type="text/javascript" src="../js/authentication.js"></script>
    <link rel="icon" type="image/x-icon" href="../../imgs/favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/myHistory.css">
    <link rel="stylesheet" href="../../css/style-slots.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>

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

                <li>
                    <a href="user_dashboard.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Home</span>
                    </a>
                </li>

                <li style="background-color: #FBF5EE; font-size: 25px">
                    <a href="availableSlots.php">
                        <span class="icon">
                            <ion-icon name="time"></ion-icon>
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
                            <ion-icon name="document-outline"></ion-icon>
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
                        <a onclick="signoutClick(event)" id="logout">
                            <ion-icon class="icon" name="log-out-outline"></ion-icon> Sign out
                        </a>
                    </div>
                </div>
            </div>

            <div class="history-page-title">
                <span style="color: #020303;">Available</span>
                <span style="color: #28844B;"> Slots

                </span>



            </div>


            <div id="bodyContainer">

                <section id="availableSlots">
                    <div id="headerBodyContainer">

                        <div id="calendarSlot">
                            <div id="calendarHeader">
                                <div id="MonthContainer"></div>
                                <div id="portal">
                                    <div id="prev"><button onclick="prevMonth()">Previous</button></div>
                                    <div id="next"><button onclick="nextMonth()">Next</button></div>
                                </div>
                            </div>
                            <div id="dateContent">

                            </div>
                        </div>
                </section>







            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="../../js/main.js"></script>
    <script src="../../js/authentication.js"></script>
    <script src="../../js/script-slots.js"></script>








</body>

</html>