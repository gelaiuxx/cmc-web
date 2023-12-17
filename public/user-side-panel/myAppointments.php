<?php
include '../../php/connection.php';

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
    <title>CMC | My Appointments</title>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- <script src="../js/authentication.js"></script> -->
    <link rel="icon" type="image/x-icon" href="../../imgs/favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/myAppointments.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


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

                <li>
                    <a href="availableSlots.php">
                        <span class="icon">
                            <ion-icon name="time-outline"></ion-icon>
                        </span>
                        <span class="title">Available Slots</span>
                    </a>
                </li>

                <li style="background-color: #FBF5EE; font-size: 25px">
                    <a href="myAppointments.php">
                        <span class="icon">
                            <ion-icon name="calendar"></ion-icon>
                        </span>
                        <span class="title">Appointments</span>
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

            <div class="appointments-title">
                <span style="color: #020303;">My</span>
                <span style="color: #28844B;"> Appointments
                </span>
                <!-- Department Legends Button -->
                <button class="department-legends-btn" onclick="openDepartmentLegendsModal()">Department Legends
                </button>
            </div>




            <!-- ================ My dependents ================= -->
            <div class="appointments-page">
                <div class="dependents">
                    <div class="cardHeader">
                        <h2>My Dependents</h2>
                        <!-- Button to Open Add Dependent Modal -->
                        <a href="#" class="btn" onclick="openAddDependentModal()">
                            <ion-icon name="person-add-outline" class="add-icon"></ion-icon> Add Dependent
                        </a>

                    </div>

                    <!-- Dependent Details Section -->
                    <div class="dependent-details">
                        <?php include '../../php/get_dependent_details.php'; ?>
                    </div>
                </div>


                <!-- ================ My appointments Table Section ================= -->
                <div class="appointments-table">
                    <table id="myAppointmentsTable">
                        <thead>
                            <tr>
                                <td>Patient Name</td>
                                <td>Category</td>
                                <td>Consultation Schedule</td>
                                <td>Status</td>
                                <td></td>


                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            $user_id = $_SESSION['user_id'];

                            if ($user_id) {
                                $sql = "SELECT CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
                                a.category,
                                CONCAT(a.day, ' ', DATE_FORMAT(a.time, '%l:%i %p')) AS schedule,
                                a.stat, a.appointment_id
                            FROM appointments a
                            JOIN patients p ON a.patient_id = p.patient_id
                            WHERE a.user_id = $user_id
                            ORDER BY a.queue_no DESC";

                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["patient_name"] . "</td>";
                                        echo "<td>" . $row["category"] . "</td>";
                                        echo "<td>" . $row["schedule"] . "</td>";
                                        echo "<td>" . $row["stat"] . "</td>";
                                        echo '<td><button data-id="' . $row['appointment_id'] . '" class="view-button"><i class="fa-regular fa-eye"></i> View</button></td>';
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr>";
                                    echo "<td></td>";
                                    echo '<td colspan="5"><img src="../../imgs/appointment.png" alt="No Appointments Image"></td>';

                                    echo "</tr>";
                                }

                                // Close the database connection
                                $con->close();
                            }
                            ?>



                        </tbody>
                    </table>
                </div>



                <!-- Modal -->
                <div id="departmentLegend" class="department-legend-modal">
                    <div class="modal-content">
                        <span class="dlclose-btn" onclick="closeDepartmentLegendsModal()">&times;</span>
                        <h2 class="dlTitle"> Department Legends</h2>
                        <div class="modal-left">
                            <div class="department-info">
                                <h2>CECAP</h2><br>
                                <ul>
                                    <li>PAGPA KONSULTA UG PAG PA OPERA SA CANCER SA MATRES, OVARIO UG CERVIX</li>
                                    <li>MONDAY- FACE TO FACE PARA SA CERVICAL CANCER</li>
                                    <li>TUESDAY- FACE TO FACE PARA SA TANANG OVARIAN CANCER, H.MOLE AND GTN</li>
                                    <li>THURSDAY- FACE TO FACE PARA SA ENDOMETRIAL CANCER</li>
                                </ul>
                                <br>
                                <ul>
                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon, Tue, Thu</li>
                                    <li>Opening Time: 8:00 am</li>
                                    <li>Closing Time: 11:00 am</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-right">
                            <div class="department-info">
                                <h2>DENTAL</h2><br>
                                <ul>
                                    <li>PLEASE CALL 09876543212</li> <br>

                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon, Wed, Thu, Fri</li>
                                    <li>Opening Time: 8:00 am</li>
                                    <li>Closing Time: 3:00 pm</li>
                                </ul>
                            </div>
                        </div>

                        <div class="modal-left">
                            <div class="department-info">
                                <h2>ENT-HNS (EAR,NOSE,THROAT-HEAD AND NECK SURGERY)</h2><br>
                                <ul>
                                    <li>PAGPAKONSULTA UG PAGPA OPERA SA MGA BUGON O SAKIT SA LIOG , ILONG, BABA UG DUNGGAN</li>
                                </ul>
                                <br>
                                <ul>
                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon, Wed, Thu, Fri</li>
                                    <li>Opening Time: 8:00 am</li>
                                    <li>Closing Time: 3:00 pm</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-right">
                            <div class="department-info">
                                <h2>FAMILY MEDICINE</h2><br>
                                <ul>
                                    <li>PAGPACONSULTA SA DERMATOLOGY, TB, PALLIATIVE/HOSPICE CARE, GERIATRICS , UG SA MGA PASYENTE NGA FIRST TIME MAGPAKONSULTA</li>
                                    <br>

                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon,Tue,Wed,Thu,Fri</li>
                                    <li>Opening Time: 8:00 am</li>
                                    <li>Closing Time: 12:00 pm</li>
                                </ul>
                            </div>
                        </div>

                        <div class="modal-left">
                            <div class="department-info">
                                <h2>GENERAL SURGERY</h2><br>
                                <ul>
                                    <li>PAGPAKONSULTA UG PAGPA OPERA SA NAGKA-LAINGLAING SAKIT/ TUMOR SA LAWAS ( SAMA SA TINAE , TOTOY) ,WALAY LABOT SA SAKIT SA MATRIS O OVARIO</li>
                                </ul>
                                <br>
                                <ul>
                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon,Tue,Fri</li>
                                    <li>Opening Time: 8:00 am</li>
                                    <li>Closing Time: 12:00 pm</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-right">
                            <div class="department-info">
                                <h2>GYNE</h2><br>
                                <ul>
                                    <li>PAGPAKONSULTA UG PAGPA OPERA SA NAGKA LAINGLAING SAKIT/ TUMOR SA BABAYE (KINATAWO, MATRIS, OVARIO) UG SA MGA NAKUHAAN, WALAY LABOT SA TUMOR SA TOTOY</li>
                                    <br>

                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon,Wed,Fri</li>
                                    <li>Opening Time: 8:00 am</li>
                                    <li>Closing Time: 7:00 pm</li>
                                </ul>
                            </div>
                        </div>

                        <div class="modal-left">
                            <div class="department-info">
                                <h2>NEUROSURGERY

                                </h2><br>
                                <ul>
                                    <li>PAGPAKONSULTA UG PAGPA OPERA SA SAKIT SA ULO/UTOK UG SPINE. WEDNESDAY- OLD PATIENT, THURSDAY- NEW PATIENT
                                    </li>
                                </ul>
                                <br>
                                <ul>
                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Wed, Thu</li>
                                    <li>Opening Time: 1:00 pm</li>
                                    <li>Closing Time: 3:00 pm</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-right">
                            <div class="department-info">
                                <h2>INTERNAL MEDICINE (GENERAL)
                                </h2><br>
                                <ul>
                                    <li>PAGPAKONSULTA SA MGA NAGKA LAINGLAING PARTE SA LAWAS NGA DILI KAILANGAN UG OPERASYON NGA NAG EDAD 19 UG PATAAS ( SAMA SA DIABETES, ENDOCRINE, CARDIAC CLINIC, NEUROLOGY, HEMATOLOGY, GASTROENTEROLOGY, NEPHROLOGY/RENAL O DIALYSIS, RHEUMATOLOGY/LUPUS UG PULMONOLOGY)
                                    </li>
                                    <br>
                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon,Wed,Thu</li>
                                    <li>Opening Time: 8:00 am</li>
                                    <li>Closing Time: 11:00 am</li>
                                </ul>
                            </div>
                        </div>

                        <div class="modal-left">
                            <div class="department-info">
                                <h2>OB (PREGNANT/BUNTIS ONLY)


                                </h2><br>
                                <ul>
                                    <li>PAGPAKONSULTA SA BUNTIS UG BAG-O LANG NANGANAK

                                    </li>
                                </ul>
                                <br>
                                <ul>
                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon, Tue, Thu, Friday</li>
                                    <li>Opening Time: 8:00 am</li>
                                    <li>Closing Time: 7:00 pm</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-right">
                            <div class="department-info">
                                <h2>OPHTHALMOLOGY/EYE CENTER

                                </h2><br>
                                <ul>
                                    <li>PLEASE CALL 09086339835
                                    </li>
                                    <br>
                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon, Wed, Thu, Fri</li>
                                    <li>Opening Time: 8:00 am</li>
                                    <li>Closing Time: 3:00 pm</li>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-left">
                            <div class="department-info">
                                <h2>ORTHOPEDICS
                                </h2><br>
                                <ul>
                                    <li>PAGPAKONSULTA UG PAGPA OPERA SA SAKIT/NABALIAN SA BUKOG, SPINE, HAND AND FOOT
                                    </li>
                                </ul>
                                <br>
                                <ul>
                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Wed, Thu</li>
                                    <li>Opening Time: 8:00 am</li>
                                    <li>Closing Time: 4:00 pm</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-right">
                            <div class="department-info">
                                <h2>PEDIA (GENERAL)

                                </h2><br>
                                <ul>
                                    <li>PAGPAKONSULTA SA MGA NAGKALAINGLAING SAKIT SA BATA NGA NAG EDAD UG 18 UG PAUBOS

                                    </li>
                                    <br>

                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon,Wed,Thu</li>
                                    <li>Opening Time: 8:00 am</li>
                                    <li>Closing Time: 11:00 am</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-left">
                            <div class="department-info">
                                <h2>PRIMARY CARE </h2><br>
                                <ul>
                                    <li>UNANG PAGPAKONSULTA SA OPD SA LAING LAING SAKIT SA LAWAS ( PARA SA ADULT/DAGKO) EDAD 19 UG PATAAS
                                    </li>
                                </ul>
                                <br>
                                <ul>
                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon, Wed, Thu</li>
                                    <li>Opening Time: 1:00 pm</li>
                                    <li>Closing Time: 3:00 pm</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-right">
                            <div class="department-info">
                                <h2>UROLOGY

                                </h2><br>
                                <ul>
                                    <li>PAGPAKONSULTA UG PAGPA OPERA SA SAKIT SA PANTOG, PROSTATA , KINATAWO SA LALAKI UG BATO SA KIDNEY. (SUGOD SEPTEMBER NAA NA SA OPD BUILDING)
                                    </li>
                                    <br>

                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Tue, Friday</li>
                                    <li>Opening Time: 3:00 pm</li>
                                    <li>Closing Time: 5:00 pm</li>
                                </ul>
                            </div>
                        </div>

                        <div class="modal-left">
                            <div class="department-info">
                                <h2>ANIMAL BITES TREATMENT CENTER
                                </h2><br>
                                <ul>
                                    <li>PARA SA PERMIRONG PAGPAKONSULTA SA MGA NAPAAKAN OG IRO UG IRING </li>
                                </ul>
                                <br>
                                <ul>
                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon, Thu, Fri</li>
                                    <li>Opening Time: 8:00 am</li>
                                    <li>Closing Time: 4:00 pm</li>
                                </ul>
                            </div>
                        </div>

                        <div class="modal-right">
                            <div class="department-info">
                                <h2>GASTROENTEROLOGY
                                </h2><br>
                                <ul>
                                    <li>PAKONSULTA SA TINAE ,TUNGOL, ATAY UG APDO (PERO DILI MANGOPERAHAY) PARA ENDOSCOPY/COLONOSCOPY</li>
                                </ul>
                                <br>
                                <ul>
                                    <li><strong>Consultation Schedule</strong></li> <br>
                                    <li>Days: Mon, Tue, Wed, Thu, Fri</li>
                                    <li>Opening Time: 2:00 pm</li>
                                    <li>Closing Time: 4:00 pm</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- Modal -->
                <form id="addAppointmentForm">
                    <div class="modal" id="appointmentModal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>

                            <!-- Patient Information -->
                            <div class="modal-step" id="step1">
                                <input type="hidden" id="patientId" name="patientId" value="">

                                <h2>Patient Information</h2>

                                <div class="progress-bar-container">
                                    <div class="progress-bar">
                                        <div class="progress-step" id="progress1">1</div>
                                        <div class="progress-line"></div>
                                        <div class="progress-step" id="progress2">2</div>
                                        <div class="progress-line"></div>
                                        <div class="progress-step" id="progress3">3</div>
                                        <div class="progress-line"></div>
                                        <div class="progress-step" id="progress4">4</div>
                                    </div>
                                </div>




                                <!-- Left Side -->
                                <div class="left-side">
                                    <label for="firstName">First Name</label>
                                    <input type="text" id="firstName" name="firstName" placeholder="First Name" required>


                                    <label for="lastName">Last Name</label>
                                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>

                                    <label for="middleName">Middle Name</label>
                                    <input type="text" id="middleName" name="middleName" placeholder="Middle Name">

                                    <label for="extensionName">Extension Name</label>
                                    <select id="extensionName" name="extensionName">
                                        <option value="Sr.">Sr.</option>
                                        <option value="Jr.">Jr.</option>
                                        <option value="N/A">N/A</option>
                                    </select>

                                    <label for="dob">Date of Birth</label>
                                    <input type="date" id="dob" name="dob" value="<?php echo date('Y-m-d'); ?>" required>
                                    <label for="civilStatus">Civil Status</label>
                                    <select id="civilStatus" name="civilStatus" required>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                </div>

                                <!-- Right Side -->
                                <div class="right-side">
                                    <label for="sex">Sex</label>
                                    <select id="sex" name="sex" required>
                                        <option value="Female">Female</option>
                                        <option value="Male">Male</option>
                                    </select>

                                    <label for="religion">Religion</label>
                                    <input type="text" id="religion" name="religion" placeholder="Religion" required>

                                    <label for="nationality">Nationality</label>
                                    <input type="text" id="nationality" name="nationality" placeholder="Nationality" required>

                                    <label for="occupation">Occupation</label>
                                    <input type="text" id="occupation" name="occupation" placeholder="Occupation" required>

                                    <label for="cellphoneNumber">Cellphone Number</label>
                                    <input type="tel" id="cellphoneNumber" name="cellphoneNumber" placeholder="Cellphone Number" required>
                                </div>


                                <!-- Next Button with Icon -->
                                <button class="next1-button" onclick="nextStep()">
                                    Next <ion-icon name="arrow-forward-outline"></ion-icon>
                                </button>

                            </div>


                            <!-- Step 2: Address Information -->
                            <div class="modal-step" id="step2" style="display: none;">
                                <h2>Address Information</h2>

                                <div class="progress-bar-container">
                                    <div class="progress-bar">
                                        <div class="progress-step completed" id="progress1">✔</div>
                                        <div class="progress-line completed"></div>
                                        <div class="progress-step" id="progress2">2</div>
                                        <div class="progress-line"></div>
                                        <div class="progress-step" id="progress3">3</div>
                                        <div class="progress-line"></div>
                                        <div class="progress-step" id="progress4">4</div>
                                    </div>
                                </div>

                                <!-- Left Side -->
                                <div class="left-side">
                                    <label for="houseLotNo">House/ Lot No.</label>
                                    <input type="text" id="houseLotNo" name="houseLotNo" placeholder="House/ Lot No." required>

                                    <label for="street">Street</label>
                                    <input type="text" id="street" name="street" placeholder="Street" required>

                                    <label for="province">Province</label>
                                    <input type="text" id="province" name="province" placeholder="Province" required>
                                </div>

                                <!-- Right Side -->
                                <div class="right-side">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" placeholder="City" required>

                                    <label for="barangay">Barangay</label>
                                    <input type="text" id="barangay" name="barangay" placeholder="Barangay" required>

                                    <label for="postalCode">Postal Code</label>
                                    <input type="text" id="postalCode" name="postalCode" placeholder="Postal Code" required>
                                </div>

                                <!-- Previous and Next Buttons with Icons -->
                                <div class="button-container">
                                    <button class="prev-button" onclick="prevStep()">
                                        <ion-icon name="arrow-back-outline"></ion-icon> Previous
                                    </button>

                                    <button class="next-button" onclick="nextStep()">
                                        Next <ion-icon name="arrow-forward-outline"></ion-icon>
                                    </button>
                                </div>

                            </div>


                            <!-- Step 3: Family Background -->
                            <div class="modal-step" id="step3" style="display: none;">
                                <h2>Family Background</h2>

                                <div class="progress-bar-container">
                                    <div class="progress-bar">
                                        <div class="progress-step completed" id="progress1">✔</div>
                                        <div class="progress-line completed"></div>
                                        <div class="progress-step completed" id="progress2">✔</div>
                                        <div class="progress-line completed"></div>
                                        <div class="progress-step" id="progress3">3</div>
                                        <div class="progress-line"></div>
                                        <div class="progress-step" id="progress4">4</div>
                                    </div>
                                </div>
                                <!-- Left Side -->
                                <div class="left-side">
                                    <label for="spouseName">Spouse Name</label>
                                    <input type="text" id="spouseName" name="spouseName" placeholder="Spouse Name">

                                    <label for="spouseAddress">Spouse Address</label>
                                    <input type="text" id="spouseAddress" name="spouseAddress" placeholder="Spouse Address">
                                </div>

                                <!-- Right Side -->
                                <div class="right-side">
                                    <label for="fathersName">Father's Name</label>
                                    <input type="text" id="fathersName" name="fathersName" placeholder="Father's Name" required>

                                    <label for="motherMaidenName">Mother Maiden Name</label>
                                    <input type="text" id="motherMaidenName" name="motherMaidenName" placeholder="Mother Maiden Name" required>
                                </div>

                                <!-- Previous and Next Buttons with Icons -->
                                <div class="button-container">
                                    <button class="prev-button" onclick="prevStep()">
                                        <ion-icon name="arrow-back-outline"></ion-icon> Previous
                                    </button>

                                    <button class="next-button" onclick="nextStep()">
                                        Next <ion-icon name="arrow-forward-outline"></ion-icon>
                                    </button>
                                </div>
                            </div>


                            <!-- Step 4: Chief Complaint -->
                            <div class="modal-step" id="step4" style="display: none;">
                                <h2>Appointment Information</h2>

                                <div class="progress-bar-container">
                                    <div class="progress-bar">
                                        <div class="progress-step completed" id="progress1">✔</div>
                                        <div class="progress-line completed"></div>
                                        <div class="progress-step completed" id="progress2">✔</div>
                                        <div class="progress-line completed"></div>
                                        <div class="progress-step completed" id="progress3">✔</div>
                                        <div class="progress-line"></div>
                                        <div class="progress-step" id="progress4">4</div>
                                    </div>
                                </div>

                                <div class="appNote"> Please take note of the available schedule for consultation in each department:
                                </div>

                                <!-- Inside your modal content -->
                                <table class="department-sched-table">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>Consultation Schedule</th>
                                            <th>Opening Time</th>
                                            <th>Closing Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>CECAP</td>
                                            <td>Mon, Tue, Thu</td>
                                            <td>8:00 am</td>
                                            <td>11:00 am</td>
                                        </tr>

                                        <tr>
                                            <td>DENTAL</td>
                                            <td>Mon,Tue,Fri</td>
                                            <td> 8:00 am</td>
                                            <td>5:00 pm</td>
                                        </tr>

                                        <tr>
                                            <td>ENT-HNS (EAR,NOSE,THROAT-HEAD AND NECK SURGERY)</td>
                                            <td>Mon, Wed, Thu, Fri</td>
                                            <td>8:00 am</td>
                                            <td>3:00 pm</td>
                                        </tr>

                                        <tr>
                                            <td>FAMILY MEDICINE</td>
                                            <td>Mon, Tue, Wed, Thu, Fri</td>
                                            <td>8:00 am</td>
                                            <td>12:00 pm</td>
                                        </tr>

                                        <tr>
                                            <td>GENERAL SURGERY</td>
                                            <td>Mon, Tue, Fri</td>
                                            <td>8:00 am</td>
                                            <td>12:00 pm</td>
                                        </tr>

                                        <tr>
                                            <td>GYNE</td>
                                            <td>Mon, Wed, Fri</td>
                                            <td>8:00 am</td>
                                            <td>7:00 pm</td>
                                        </tr>

                                        <tr>
                                            <td>NEUROSURGERY</td>
                                            <td>Wed, Thu</td>
                                            <td>1:00 pm</td>
                                            <td>3:00 pm</td>
                                        </tr>

                                        <tr>
                                            <td>INTERNAL MEDICINE (GENERAL)</td>
                                            <td>Mon, Wed, Thu</td>
                                            <td>8:00 am</td>
                                            <td>11:00 am</td>
                                        </tr>

                                        <tr>
                                            <td>OB (PREGNANT/BUNTIS ONLY)</td>
                                            <td>Mon, Tue, Thu, Fri</td>
                                            <td>8:00 am</td>
                                            <td>7:00 pm</td>
                                        </tr>

                                        <tr>
                                            <td>OPHTHALMOLOGY/EYE CENTER</td>
                                            <td>Wed, Thu</td>
                                            <td>9:00 am</td>
                                            <td>3:00 pm</td>
                                        </tr>

                                        <tr>
                                            <td>ORTHOPEDICS</td>
                                            <td>Wed, Thu</td>
                                            <td>8:00 am</td>
                                            <td>4:00 pm</td>
                                        </tr>

                                        <tr>
                                            <td>PEDIA (GENERAL)</td>
                                            <td>Mon, Wed, Thu</td>
                                            <td>8:00 am</td>
                                            <td>11:00 am</td>
                                        </tr>

                                        <tr>
                                            <td>PRIMARY CARE</td>
                                            <td>Mon, Wed, Thu</td>
                                            <td>1:00 pm</td>
                                            <td>3:00 pm</td>
                                        </tr>


                                        <tr>
                                            <td>UROLOGY</td>
                                            <td>Tue, Fri</td>
                                            <td>3:00 pm</td>
                                            <td>5:00 pm</td>
                                        </tr>

                                        <tr>
                                            <td>ANIMAL BITES TREATMENT CENTER</td>
                                            <td>Mon, Thu, Fri</td>
                                            <td>8:00 am</td>
                                            <td>4:00 pm</td>
                                        </tr>

                                        <tr>
                                            <td>GASTROENTEROLOGY</td>
                                            <td>Mon, Tue, Wed, Thu, Fri</td>
                                            <td>2:00 pm</td>
                                            <td>4:00 pm</td>
                                        </tr>
                                    </tbody>
                                </table>




                                <div class="left-side">
                                    <label for="category" class="cat">Choose a Category</label>
                                    <select id="category" name="category" required>
                                        <?php include '../../php/get_category.php'; ?>
                                    </select>

                                    <label for="time">Choose Time</label>
                                    <input type="time" id="time" name="time" placeholder="Time" required>


                                </div>

                                <div class="right-side">

                                    <label for="appointmentDate" class="date">Choose Date</label>
                                    <input type="date" id="appointmentDate" name="appointmentDate" value="<?php echo date('Y-m-d'); ?>" required>

                                </div>


                                <!-- Full Width Chief Complaint Text Area -->
                                <label for="chiefComplaint">Chief Complaint</label>
                                <textarea id="chiefComplaint" name="chiefComplaint" rows="4" placeholder="State here the problem or symptoms you are experiencing and you want to be consulted.(Unsay imong gipamati/ ganahan ipakonsulta sa imong lawas)"></textarea>


                                <span id="error-message"></span>
                                <!-- Previous and Submit Buttons with Icons -->
                                <div class="button-container">
                                    <button class="prev-button" onclick="prevStep()">
                                        <ion-icon name="arrow-back-outline"></ion-icon> Previous
                                    </button>

                                    <button class="submit-button">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>

                </form>
            </div>

        </div>


    </div>
    </div>

    <!-- HTML for the Confirmation Modal -->
    <div id="confirmationModal" class="confirmation-modal" style="display: none;">

        <div class="confirmation-modal-content">

            <h2>Are you sure you want to submit this form?</h2>
            <p>You are about to submit the form. Please Note that you won't able to edit the form after submitting it. Do
                you want to proceed?</p>

            <div class="confirm-button-container">
                <button class="close-button" onclick="closeConfirmationModal()">Cancel</button>
                <button class="confirm-button" onclick="confirmSubmit()">Yes</button>
            </div>
        </div>
    </div>

    <div id="loader" class="loader"></div>
    <div id="successModal" class="success-modal">
        <div class="modal-content">

            <div style="text-align: center;">
                <img src="../../imgs/success.png" alt="Check Icon">
                <h2>Thank you for trusting Cebu Medical Care</h2>
                <p>Your appointment has been successfully created. Please go to the My Appointments Tab page to track the status of your appointment. </p>

                <div class="booking-details">
                    <h1 style="font-weight: bold;" id="queueNumber"></h1>
                    <h2>Queue Number</h2>
                    <p style="margin-top: 10px; font-size:18px;">Patient Name: <span id="patientName" style="font-size:18px;"></span></p>
                    <p style="margin-top: 10px; font-size:18px;">Department: <span id="categ" style="font-size:18px;"></span></p>
                    <p style="margin-top: 10px;font-size:18px;">Appointment Date: <span id="scheduledDate" style="font-size:18px;"></span></p><br>


                    <p class="note">
                        Please make your consultation experience smoother:
                        <br>
                        <strong>1. Arrival Time:</strong> Aim to arrive 15 minutes before your scheduled consultation.<br>
                        <strong>2. Queue Number:</strong> Remember to present your queue number. <br>
                        <strong>3. Safety First:</strong> Wear a face mask for everyone's safety.<br>
                        <strong>4. Social Distancing:</strong> Observe a distance of at least 1 meter.<br>
                    </p>
                </div>
            </div>

            <div class="success-button-container">
                <button class="cancel-button" onclick="closeSuccessModal()">Close</button>

                <div class="dropdown-container">
                    <div class="dropdown-content">
                        <a href="#" class="dropdown-option" onclick="downloadOptionSelected('image')">Save as Image</a>
                        <a href="#" class="dropdown-option" onclick="downloadOptionSelected('print')">Print</a>
                    </div>
                    <button class="dropdown-button">Download</button>

                </div>
            </div>


        </div>
    </div>


    <!-- Viewing Appointment Details Modal -->
    <div id="viewAppointmentDetailsModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="closeViewAppointmentModal()">&times;</span>
            <h2>Appointment Details</h2>
            <div id="viewAppointmentModalBody">
            </div>
        </div>
    </div>

    <!-- Add Dependent Modal -->
    <div class="modal" id="addDependentModal">
        <div class="modal-content-dependent">
            <span class="close" onclick="closeModal()">&times;</span>

            <!-- Form Content Here -->
            <!-- <form id="addDependentForm" method="post" action="../../php/add_dependents.php"> -->
            <form id="addDependentForm" method="post" onsubmit="addDependents(event)">

                <!-- Step 1: Patient Information -->
                <div class="modal-step">

                    <h2>Patient Information</h2>

                    <!-- Left Side -->
                    <div class="left-side">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="First Name">

                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>


                        <label for="middleName">Middle Name</label>
                        <input type="text" id="middleName" name="middleName" placeholder="Middle Name">

                        <label for="extensionName">Extension Name</label>
                        <select id="extensionName" name="extensionName">
                            <option value="Sr.">Sr.</option>
                            <option value="Jr.">Jr.</option>
                            <option value="N/A">N/A</option>
                        </select>

                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" placeholder="dd-mm-yyyy<?php echo date('Y-m-d'); ?>" required>


                        <label for="civilStatus">Civil Status</label>
                        <select id="civilStatus" name="civilStatus" required>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>

                    <div class="right-side">
                        <label for="sex">Sex</label>
                        <select id="sex" name="sex" required>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>

                        <label for="religion">Religion</label>
                        <input type="text" id="religion" name="religion" placeholder="Religion" required>

                        <label for="nationality">Nationality</label>
                        <input type="text" id="nationality" name="nationality" placeholder="Nationality" required>

                        <label for="occupation">Occupation</label>
                        <input type="text" id="occupation" name="occupation" placeholder="Occupation" required>

                        <label for="cellphoneNumber">Cellphone Number</label>
                        <input type="tel" id="cellphoneNumber" name="cellphoneNumber" placeholder="Cellphone Number" required>

                    </div>

                    <hr>

                    <div class="modal-step">
                        <h2>Address Information</h2>

                        <!-- Left Side -->
                        <div class="left-side">
                            <label for="houseLotNo">House/ Lot No.</label>
                            <input type="text" id="houseLotNo" name="houseLotNo" placeholder="House/ Lot No." required>

                            <label for="street">Street</label>
                            <input type="text" id="street" name="street" placeholder="Street" required>

                            <label for="province">Province</label>
                            <input type="text" id="province" name="province" placeholder="Province" required>
                        </div>

                        <!-- Right Side -->
                        <div class="right-side">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" placeholder="City" required>



                            <label for="barangay">Barangay</label>
                            <input type="text" id="barangay" name="barangay" placeholder="Barangay" required>

                            <label for="postalCode">Postal Code</label>
                            <input type="text" id="postalCode" name="postalCode" placeholder="Postal Code" required>
                        </div>

                        <hr>

                        <div class="modal-step">
                            <h2>Family Background</h2>
                            <!-- Left Side -->
                            <div class="left-side">
                                <label for="spouseName">Spouse Name</label>
                                <input type="text" id="spouseName" name="spouseName" placeholder="Spouse Name">

                                <label for="spouseAddress">Spouse Address</label>
                                <input type="text" id="spouseAddress" name="spouseAddress" placeholder="Spouse Address">
                            </div>

                            <!-- Right Side -->
                            <div class="right-side">
                                <label for="fathersName">Father's Name</label>
                                <input type="text" id="fathersName" name="fathersName" placeholder="Father's Name" required>

                                <label for="motherMaidenName">Mother Maiden Name</label>
                                <input type="text" id="motherMaidenName" name="motherMaidenName" placeholder="Mother Maiden Name" required>
                            </div>
                            <!-- Error Message Div -->
                            <span id="error-message-div"></span>




                            <div class="button-container">
                                <button class="dependent-submit-button" type="submit">
                                    Add Dependent
                                </button>
                            </div>
            </form>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="../../js/main.js"></script>
    <script src="../../js/authentication.js"></script>
    <script src="../../js/modal.js"></script>
    <script src="../../js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.view-button').click(function() {
                var appointmentId = $(this).data('id');

                // Perform AJAX request
                $.ajax({
                    url: '../../php/viewAppointmentModal.php',
                    type: 'GET',
                    data: {
                        appointmentId: appointmentId
                    },
                    success: function(response) {
                        $('#viewAppointmentModalBody').html(response);
                        $('#viewAppointmentDetailsModal').modal('show');
                    },
                    error: function() {
                        alert('Error fetching appointment details');
                    }
                });
            });
        });

        function closeViewAppointmentModal() {
            // Hide the modal
            $('#viewAppointmentDetailsModal').modal('hide');
        }
    </script>

    <script src="../../js/autosuggest.js"></script>






</body>

</html>