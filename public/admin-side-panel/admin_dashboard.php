<?php
session_start();
if(!isset($_SESSION["admin_email"])){
        header('location: ../index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>CMC | Service Portal</title>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script type="text/javascript" src="../../js/authentication.js"></script>
    <script type="text/javascript" src="../../js/admincards.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

    <link rel="icon" type="image/x-icon" href="../../imgs/favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet"href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/admin.css">



</head>

<body>
    <!-- =============== SIDEBAR ================ -->
    <div class="container">
        <div class="navigation">
                <ul>
                    <li>
                        <a href="admin_dashboard.php">
                            <div class="logo">
                                <img src="../../imgs/sidebarlogo.png" alt="sidebarlogo">
                            </div>
                        </a>
                    </li>

                    <li style="background-color: #FBF5EE; font-size: 30px">
                        <a href="admin_dashboard.php">
                            <span class="icon"><ion-icon name="home"></ion-icon></span>
                            <span class="title">Home</span>
                        </a>
                    </li>

                    <li >
                        <a href="availableAdminSlot.php">
                            <span class="icon">
                                <ion-icon name="time-outline"></ion-icon>
                            </span>
                            <span class="title">Available Slots</span>
                        </a>
                    </li>

                    <li>
                        <a href="pendingAppointment.php">
                            <span class="icon">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </span>
                            <span class="title">Pendings</span>
                        </a>
                    </li>

                    <li>
                        <a href="approvedAppointments.php">
                            <span class="icon">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </span>
                            <span class="title">Approved</span>
                        </a>
                    </li>


                    <li>
                        <a href="history.php">
                            <span class="icon">
                                <ion-icon name="document-text-outline"></ion-icon>
                            </span>
                            <span class="title">Finish Appointments</span>
                        </a>
                    </li>

                    <li>
                        <a href="users.php">
                            <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                            </span>
                            <span class="title">Patients</span>                    
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

        <!-- =========== MAIN ============= -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="admin-dropdown">
                    <div class="admin">
                    <img src="../../imgs/admin.png" alt="admin">
                        <div class="admin-info">
                            <p class="admin-name">
                                <?php
                                    echo $_SESSION['admin_name'];
                                ?>
                            </p>
                            <p class="admin-email">
                                <?php
                                    echo $_SESSION['admin_email'];
                                ?>
                            </p>
                        </div>
                    </div>

                    <div class="dropdown-content">
                        <a href="pendingAppointment.php" class="appointments">
                            <ion-icon class="icon" name="calendar-outline"></ion-icon> All Pendings
                        </a>

                        <a href="availableAdminSlot.php" class="slots">
                            <ion-icon class="icon" name="time-outline"></ion-icon> Available Slots
                        </a>

                        <a href="approvedAppointments.php" class="slots">
                            <ion-icon class="icon" name="time-outline"></ion-icon> Approved Appoint...
                        </a>

                        <a href="history.php" class="history">
                            <ion-icon class="icon" name="document-text-outline"></ion-icon> Done Appointments
                        </a>
                        <a href="#" class="logout" onclick="signoutClick(event)">
                            <ion-icon class="icon" name="log-out-outline"></ion-icon> Sign out
                        </a>
                    </div>
                </div> <!--DROPDOWN-->
            </div> <!--TOPBAR-->

            <div class="dashboard-container">
                <div class="dashboard-header">
                    <div class="dashboard-greeting">
                        <span style="color: #020303;">Hello</span>,
                        <span style="color: #28844B;">
                            <?php
                                echo 'Admin'. " ". $_SESSION['admin_lastName'];
                            ?>
                        </span>!
                        <div class="message">
                            Welcome to CMC Service Portal! Your health is our top priority. </div>
                    </div>

                    <div class="img">
                        <img src="../../imgs/abstract.png" alt="">
                    </div>

                    
                </div>

                <div class="time-container">
                    <div class="time" id="time">
                    </div>
                </div>
            </div> <!-- ==== DASHBOARD-CONTAINER ==== -->

            <!-- ========== CARDS ========= -->
            <div class="cards-all">
                <div class="cards-details">
                    <div class="cardBox">
                        <div class="card">
                            <div>
                                <div class="patients-catered" id="patients-catered-today">
                                    <!-- ================ AJAX ONLOAD DATA FETCH ================= -->
                                </div>
                            <div class="cardName">Patients Booked Today</div>
                            </div>

                            <div class="iconBx">
                                <a href="#" class="iconBx">
                                    <ion-icon name="people-outline"></ion-icon>
                                </a>
                            </div>
                        </div>

                        <div class="card">
                            <div>
                                <div class="patients-today" id="patients-pending-today">
                                    
                                    <!-- ================ AJAX ONLOAD DATA FETCH ================= -->
                                </div>
                                <div class="cardName">Patients Pending Today</div>
                            </div>

                            <div class="iconBx">
                                <a href="#" class="iconBx">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                </a>
                            </div>
                        </div>

                        <div class="card">
                            <div>
                                <div class="patients-tomorrow" id="patients-done">
                                    <!-- ================ AJAX ONLOAD DATA FETCH ================= -->
                                </div>
                                <div class="cardName">Patients Completed Today</div>
                            </div>

                            <div class="iconBx">
                                <a href="#" class="iconBx">
                                    <ion-icon name="arrow-forward-outline"></ion-icon>
                                </a>
                            </div>
                        </div>

                        <div class="card">
                            <div>
                                <div class="patients-tomorrow" id="patients-tom-pending">
                                    <!-- ================ AJAX ONLOAD DATA FETCH ================= -->
                                </div>
                            <div class="cardName">Patients Booked for Tomorrow</div>
                            </div>

                            <div class="iconBx">
                                <a href="#" class="iconBx">
                                    <ion-icon name="arrow-forward-outline"></ion-icon>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="details">
                        <div class="appointmentsContainer">
                            <div class="cardHeader">
                                <h2>View Appointments</h2>
                                <a href="pendingAppointment.php" class="btn">
                                    <ion-icon name="eye-outline"></ion-icon> View
                                </a>

                            </div>

                            <table id="pendingTable">
                                <thead>
                                    <tr>
                                        <td>Patient Name</td>
                                        <td>Type</td>
                                        <td>Schedule</td>
                                        <td>Status</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <!-- Placeholder Data -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="wrapper">
                    <a href="pendingAppointment.php" style="text-decoration: none;">
                    
                        <div class="make-appointment">
                            <a href="pendingAppointment.php" style="text-decoration: none;">
                                <div class="header-section">
                                    <h2>View Appointments</h2>
                                    <p>Pending appointments</p>
                                </div>
                                
                                <div class="button-section">
                                    <a href="pendingAppointment.php" class="iconBx">
                                        <button class="icon-button"><ion-icon name="eye-outline"></ion-icon></button>
                                    </a>
                                </div>
                        </div>
                    </a>

                        <div class="calendar-container">
                            <header>
                                <p class="current-date"></p>
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
        </div> <!-- ==== MAIN ==== -->
        
    </div> <!--CONTAINER-->

    <script type="text/javascript" src="../../js/main.js"></script>
    <script>
            //<============= SET TIME ===================>
        function updateTime() {
            const now = new Date();
            const timeDiv = document.getElementById('time');

            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');

            const timeString = `${hours}:${minutes}:${seconds}`;
            timeDiv.innerText = timeString;
        }

        setInterval(updateTime, 1000);
        updateTime();
        
    </script>
</body>

</html>