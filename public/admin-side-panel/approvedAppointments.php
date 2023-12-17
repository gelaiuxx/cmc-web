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
    <title>CMC | Approved Appointments</title>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
    <script type="text/javascript" src="../../js/authentication.js"></script>
    <script type="text/javascript" src="../../js/pendingcards.js"></script>
    <script type="text/javascript" src="../../js/approve.js"></script>

    <script src="https://kit.fontawesome.com/75f1c3823b.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="../../imgs/favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/admin-sidebar.css">
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

                <li>
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

                <li style="background-color: #FBF5EE; font-size: 30px">
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

            <!-- ========== CARDS ========= -->
            <div class="cards-all">
                <div class="cards-details">
                    <div class="cardBox">
                        <div class="card">
                            <div>
                                <div class="patients-catered" id="next_catered_count">
                                    <!-- ================ AJAX ONLOAD DATA FETCH ================= -->
                                </div>
                                <div class="cardName">Patients Booked Next 3 Days</div>
                            </div>

                            <div class="iconBx">
                                <a href="#" class="iconBx">
                                    <ion-icon name="people-outline"></ion-icon>
                                </a>
                            </div>
                        </div>

                        <div class="card">
                            <div>
                                <div class="patients-today" id="pending-next-threedays">
                                    <!-- ================ AJAX ONLOAD DATA FETCH ================= -->
                                </div>
                                <div class="cardName">Patients Pending Next 3 Days</div>
                            </div>

                            <div class="iconBx">
                                <a href="#" class="iconBx">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                </a>
                            </div>
                        </div>

                        <div class="card">
                            <div>
                                <div class="patients-tomorrow" id="approved-next-threedays">
                                    <!-- ================ AJAX ONLOAD DATA FETCH ================= -->
                                </div>
                                <div class="cardName">Appointments Approved Next 3 Days</div>
                            </div>

                            <div class="iconBx">
                                <a href="#" class="iconBx">
                                    <ion-icon name="arrow-forward-outline"></ion-icon>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pendingBody">
                <div class="pendingHeader">
                    <h1>Pending Appointments Next: 3 Days</h1>
                    
                    <div class="details">
                        <div class="appointmentsContainer">
                                <table id="tomTable">
                                    <thead>
                                        <tr>
                                            <td> Name</td>
                                            <td>Type</td>
                                            <td>Schedule</td>
                                            <td>Status</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                </table>
                        </div>
                    </div>
                </div>

                <div class="details">
                    <div class="appointmentsContainer">
                            <table id="approvedTable">
                                <thead>
                                </thead>
                                    <tbody>
                                    </tbody>
                            </table>
                    </div>
                </div>
            </div>       
        </div> <!-- ==== MAIN ==== -->
    </div> <!--CONTAINER-->

    
<div class="modal" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h1 class="modal-title">Appointment Information</h1>
                <button id="close-x" onclick="closeModal()" type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form onsubmit="updateAppointment()" id="updateAppointment">
                    <div class="form-group">
                        <label for="patient_name">Full name : </label>
                        <input type="text" class="form-control" id="patient_name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="category">Category :</label>
                        <input type="text" class="form-control" id="category" readonly>
                    </div>
                    <div class="form-group">
                        <label for="date_sched">Schedule :</label>
                        <input type="date" class="form-control" id="date_sched" readonly>
                    </div>
                    <div class="form-group">
                        <select name="stat" id="stat">
                            <option value="Pending" >Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Done">Done</option>
                        </select>
                    </div>

                    <button type="submit" id="submitChanges"><span><i class="fa-solid fa-check"></i></span>Save Appointment</button>
                
                </form>
            </div>
        </div>
    </div>
</div>

<div class="delete-modal" id="delete-modal">
    <div class="inner-delete">
        <div class="delete-content">
            <div class="delete-header">
                <h1>Deleting Appointment will permanently deleted.</h1>
            </div>

            <div class="option-delete">
                <button type="button" id="confirm" onclick="confirmDelete()">Yes</button>
                <button type="button" id="decline" onclick="deleteModal()">No</button>
            </div>
        </div>
    </div>
</div>

    <script>
                let list = document.querySelectorAll(".navigation li");

            function activeLink() {
            list.forEach((item) => {
                item.classList.remove("hovered");
            });
            this.classList.add("hovered");
            }

            list.forEach((item) => item.addEventListener("mouseover", activeLink));

            // Menu Toggle
            let toggle = document.querySelector(".toggle");
            let navigation = document.querySelector(".navigation");
            let main = document.querySelector(".main");

            toggle.onclick = function () {
            navigation.classList.toggle("active");
            main.classList.toggle("active");
            };
    </script>
</body>


</html>