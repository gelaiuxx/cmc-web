var xhttp = new XMLHttpRequest();

$(document).ready(function() {
    fetchPendingAppointments();
    // tomorrowAppointment();
    nextDayAppointment();
    displayAllPatients();
    doneAppointment();
});

function signinSubmit(e) {
    var errorMsg = document.getElementById('errorMsg');
    var url = "../php/signin_action.php";
    var data = $("#signinForm").serialize();
    var urlData = url + "?" + data;

    xhttp.open("GET", urlData, true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                try {
                    var res = JSON.parse(this.responseText);
                    if (res.status === 200) {
                        $('#signinForm')[0].reset();
                        if (res.data.role === 'user-only') {
                            window.location.href = '../public/user-side-panel/user_dashboard.php';
                        } else if (res.data.role === 'admin-only') {
                            window.location.href = '../public/admin-side-panel/admin_dashboard.php';
                        } else {
                            window.location.href = '../public/index.php';
                        }
                    } else {
                        errorMsg.innerText = res.message;
                    }
                } catch (e) {
                    errorMsg.innerText = res.message;
                }
            } else {
                errorMsg.innerText = res.message;
            }
        }
        errorMsg.style.display = 'block';
        setTimeout(function(){
            errorMsg.style.display = 'none';
        }, 3000);

    };
    e.preventDefault();
    errorMsg.style.display = 'block';
}

// <============== REGISTER ACCOUNT / SIGN UP ================>
function signupSubmit(e){
    $.ajax({
        type : 'POST',
        url : '../php/signup_action.php',
        data : $('#signupForm').serialize(),

        success : function(response) {
            var res = JSON.parse(response);
            if(res.message == 'Account created successfully.'   ){
                document.getElementById('errorMsg').style.color = 'green';
                document.getElementById('errorMsg').innerText = res.message;
            
            }else {
                document.getElementById('errorMsg').innerText = res.message;
            }
            if(res["status"] == 200){
                $('#signupForm')[0].reset();
            }
        }
        
    });
    e.preventDefault();
}

// <============== SIGNOUT ACCOUNT ================>
function signoutClick(e){
    var url = '../../php/signout_action.php';
    xhttp.open("GET", url, true);
    xhttp.send();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var res = JSON.parse(this.responseText);
            if(res["status"] == 200){
                window.location.href = '../../public/index.php';
            }
        }
    };
}

// <============== DISPLAY LIST OF PENDING APPOINTMENTS IF LOAD ================>
function fetchPendingAppointments() {
    $.ajax({
        url: '../../php/fetch_pending_app.php',
        method: 'GET',
        success: function (response) {
            var appointments = JSON.parse(response);
            $('#pendingTable tbody').empty();
            if (appointments.length > 0) {
                $.each(appointments, function (index, appointment) {
                    $('#pendingTable tbody').append(
                        '<tr>' +
                            '<td>' + appointment.patient_name + '</td>' +
                            '<td>' + appointment.type + '</td>' +
                            '<td>' + appointment.schedule + '</td>' +
                            '<td>' + appointment.status + '</td>' +
                        '</tr>'
                    );
                });
            } else {
                $('#pendingTable tbody').append(
                    '<tr>' + 
                    '<td colspan= "5" style="text-align:center;">' +
                        '<p>' + 'No Pending Appointments.' + '</p>'+
                    '</td>' +
                    
                    '</tr>'+
                    
                    '<tr>'+
                    '<td colspan= "5" style="text-align:center;">' +
                        '<img src="../../imgs/nouser.png" alt="no-user">' + 
                    '</td>' +
                '</tr>'
                );
            }
        },
        // error: function (error) {
        //     console.log("AJAX Error:", xhr.responseText);
        //     console.log("Status:", status);
        //     console.log("Error:", error);
        // }
    });
}

// <============== TOM APPOINTMENT ================>
// function tomorrowAppointment() {
//     $.ajax({
//         url: '../php/fetch_tomorrow_app.php',
//         method: 'GET',
//         success: function (response) {
//             var appointments = JSON.parse(response);
//             $('#tomTable tbody').empty();
//             if (appointments.length > 0) {
//                 $.each(appointments, function (index, appointment) {
//                     $('#tomTable tbody').append(
                        
//                         '<tr>' +
//                             '<td id="hide">' + appointment.appointment_id + '</td>' +
//                             '<td>' + appointment.patient_name + '</td>' +
//                             '<td>' + appointment.type + '</td>' +
//                             '<td>' + appointment.schedule + '</td>' +
//                             '<td>' + appointment.stat + '</td>' +
//                             '<td id="act">' +
//                                 '<button id="editBtn" class="actionButtons" onclick="editAppointment(this)">' +
//                                     '<i class="fa-solid fa-pen-to-square"></i>' +
//                                 '</button>' +
//                                 '<button id="trash" class="actionButtons" onclick="deleteAppointment(this)">' +
//                                     '<i class="fa-regular fa-trash-can"></i>' +
//                                 '</button>' +
//                             '</td>' +
//                         '</tr>'

//                     );
                    

//                 });
//             } else {
//                 $('#tomTable tbody').append(

//                     '<tr>'+
//                     '<td colspan= "5" style="text-align:center;">' +
//                         '<p style="color: red; font-weight: bold;">' + 'No Pending Appointments Tomorrow.' + '</p>'+
//                         '<img src="../../imgs/nouser.png" alt="no-user">' + 
//                     '<td>' +
//                 '</tr>'
//                 );
//             }
//         },
//         error: function (error) {
//             console.log("Error fetching appointments:", error);
//         }
//     });
// }

function nextDayAppointment() {
    $.ajax({
        url: '../../php/fetch_nextday_app.php',
        method: 'GET',
        success: function (response) {
            var appointments = JSON.parse(response);
            $('#nextTable tbody').empty();
            if (appointments.length > 0) {
                $.each(appointments, function (index, appointment) {
                    $('#nextTable tbody').append(
                        
                        '<tr>' +
                            '<td id="hide">' + appointment.appointment_id + '</td>' +
                            '<td>' + appointment.patient_name + '</td>' +
                            '<td>' + appointment.type + '</td>' +
                            '<td>' + appointment.schedule + '</td>' +
                            '<td>' + appointment.stat + '</td>' +
                            '<td id="act">' +
                                '<button id="editBtn" class="actionButtons" onclick="editAppointment(this)">' +
                                    '<i class="fa-solid fa-pen-to-square"></i>' +
                                '</button>' +
                                '<button id="trash" class="actionButtons" onclick="deleteAppointment(this)">' +
                                    '<i class="fa-regular fa-trash-can"></i>' +
                                '</button>' +
                            '</td>' +
                        '</tr>'

                    );
                    

                });
            } else {
                $('#nextTable tbody').append(

                    '<tr>'+
                        '<td style="text-align:center; width:"100%"">' +
                            '<p style=font-weight: bold;">' + 'No Pending Appointments next day.' + '</p>'+
                            '<img src="../../imgs/nouser.png" alt="no-user">' + 
                        '</td>' +
                    '</tr>'
                );
            }
        },
        error: function (error) {
            console.log("Error fetching appointments:", error);
        }
    });
}

function doneAppointment() {
    $.ajax({
        url: '../../php/fetch_done_app.php',
        method: 'GET',
        success: function (response) {
            var appointments = JSON.parse(response);
            $('#doneTable tbody').empty();
            if (appointments.length > 0) {
                $.each(appointments, function (index, appointment) {
                    $('#doneTable tbody').append(
                        
                        '<tr>' +
                            '<td>' + appointment.patient_name + '</td>' +
                            '<td>' + appointment.type + '</td>' +
                            '<td>' + appointment.schedule + '</td>' +
                            '<td>' + appointment.stat + '</td>' +
                        '</tr>'

                    );
                    

                });
            } else {
                $('#doneTable tbody').append(

                    '<tr>'+
                        '<td colspan="5" style="text-align:center; width:"100%"; padding:0px !important">' +
                            '<p style=font-weight: bold;">' + 'No appointment complete.' + '</p>'+
                            '<img src="../../imgs/nouser.png" alt="no-user">' + 
                        '</td>' +
                    '</tr>'
                );
            }
        },
        error: function (error) {
            console.log("Error fetching appointments:", error);
        }
    });
}

function displayAllPatients() {
    $.ajax({
        url: '../../php/patient_list.php',
        method: 'GET',
        success: function (response) {
            var patients = JSON.parse(response);
            $('#showAllPatients').empty();
            if (patients.length > 0) {
                $.each(patients, function (index, patient) {
                    $('#showAllPatients').append(
                        '<div class="patient-box">' +
                            '<div class="patient-img">' +
                                '<div>' +
                                        '<img src="../../imgs/patient.png" alt="patient">' +
                                '</div>' +
                            '</div>' +
                            '<div class="patient-box-data">' +
                                '<ul>' +
                                    '<li>Name: ' + patient.name + '</li>' +
                                    '<li>Birthdate: ' + patient.birthdate + '</li>' +
                                    '<li>Sex: ' + patient.sex + '</li>' +
                                    '<li>Phone: ' + patient.phone + '</li>' +
                                    '<li>Barangay: ' + patient.barangay + '</li>' +
                                    '<li>Municipality: ' + patient.municipality + '</li>' +
                                    '<li>Province: ' + patient.province + '</li>' +
                                    '<li>Type: ' + patient.type + '</li>' +
                                '</ul>' +
                            '</div>' +
                        '</div>'
                    );
                });
            } else {
                $('#showAllPatients').append(
                    '<div>' +
                        '<div>' +
                            '<h1>No Patient Registered.</h1>' +
                        '</div>' +
                    '</div>'
                );
            }
        },
        error: function (error) {
            console.log("Error fetching patients:", error);
        }
    });
}

// <============= SHOW PASSWORD INTO TEXT ================>
function togglePasswordVisibility(icon) {
const passwordInput = icon.previousElementSibling; // Get the previous sibling, which is the input element

    if (passwordInput.type === "password") {
        icon.className = "pass-toggle-btn fa fa-eye-slash";
        passwordInput.type = "text";
    } else {
        icon.className = "pass-toggle-btn fa fa-eye";
        passwordInput.type = "password";
    }
}

// <============== SHOW EYE IF THE FIELD IS NOT EMPTY ================>
function input() {
    const hidePass = document.getElementById('pass-toggle-btn');
    const pass = document.getElementById('password');

    if (pass !== null) {
        if (pass.value === '') {
            hidePass.style.display = 'none';
        } else {
            hidePass.style.display = 'block';
        }
    }

    const hidePasst = document.getElementById('pass-toggle-btn-two');
    const conPass = document.getElementById('confirm_password');

    if (conPass !== null) {
        if (conPass.value === '') {
            hidePasst.style.display = 'none';
        } else {
            hidePasst.style.display = 'block';
        }
    }
}

    var selectedRowIndex = 0;
    var selectedID = -1;

    var selectedPatient = {
    patient_name: "",
    category: "",
    date_sched: "",
    stat: ""
    };

    function editAppointment(btn) {
    let modal = document.getElementById('editModal');
        if(modal.style.display = 'none'){
            modal.style.display = 'block';
        } else{
            modal.style.display = 'none';
        }
            var upatient_name = document.getElementById('patient_name');
            var ucategory = document.getElementById('category');
            var udate_sched = document.getElementById('date_sched');
            var ustat = document.getElementById('stat');
        
            selectedRowIndex = btn.parentNode.parentNode.rowIndex;
            appointment_id = btn.parentNode.parentNode.cells[0].innerText;
            selectedPatient.patient_name = btn.parentNode.parentNode.cells[1].innerText;
            selectedPatient.category = btn.parentNode.parentNode.cells[2].innerText;
            selectedPatient.date_sched = btn.parentNode.parentNode.cells[3].innerText;
            selectedPatient.stat = btn.parentNode.parentNode.cells[4].innerText;
        
            upatient_name.value = selectedPatient.patient_name;
            ucategory.value = selectedPatient.category;
            udate_sched.value = selectedPatient.date_sched;
            ustat.value = selectedPatient.stat;

        }
        
        function updateAppointment() {
            var data = $("#updateAppointment").serialize() + "&appointment_id=" + appointment_id;
            console.log(data);
            $.ajax({
                type: 'POST',
                url: '../../php/update_appointment.php',
                data: data,
                success: function (response) {
                    try {
                        var res = JSON.parse(response);
                        if (res['status'] == 200) {
                            var selectedRow = table.getElementsByTagName('tr')[selectedRowIndex];
                            selectedRow.cells[1].innerHTML = document.getElementById("patient_name").value;
                            selectedRow.cells[2].innerHTML = document.getElementById("category").value;

                            var rawDateValue = document.getElementById("date_sched").value;
                            var formattedDate = rawDateValue ? new Date(rawDateValue).toISOString().split('T')[0] : null;

                            selectedRow.cells[3].innerHTML = formattedDate;
                            selectedRow.cells[4].innerHTML = document.getElementById("stat").value;
                        } else {
                        console.error('Invalid JSON response:', response);
                    } 
                }catch (e) {
                        console.error('Error parsing JSON:', e, response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX request failed:', error);
                }
            });
            
            
        }

        function deleteModal() {
            const deleteModal = document.getElementById('delete-modal');
            if (deleteModal.style.display === 'none') {
                deleteModal.style.display = 'block';
            } else {
                deleteModal.style.display = 'none';
            }
        }
        
        function confirmDelete() {
            var data = "appointment_id=" + document.getElementById('delete-modal').dataset.appointmentId;

            $.ajax({
                type: 'POST',
                url: '../../php/delete_appointment.php',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res["status"] == 200) {
                        document.getElementById('trash').parentNode.parentNode.remove();
                    }
                }
            });
            deleteModal();
        }
        
        function deleteAppointment(btn) {
            const deleteModal = document.getElementById('delete-modal');
            if (deleteModal.style.display = 'none') {
                deleteModal.style.display = 'block';
            } else {
                deleteModal.style.display = 'none';
            }
            var appointmentId = btn.parentNode.parentNode.cells[0].innerText;
            document.getElementById('delete-modal').dataset.appointmentId = appointmentId;
        }        

    function closeModal(){
        document.getElementById('editModal').style.display = 'none';
    }

// ========================== SEARCH HISTORY =============================
    document.addEventListener("DOMContentLoaded", function () {
        const search = document.getElementById("search-history");
        const searchHistoryButton = document.getElementById("searchHistoryButton");
    
        searchHistoryButton.addEventListener("click", function () {
            const searchTerm = search.value.trim();
    
            $.ajax({
                type: "POST",
                url: "../../php/search_patient.php",
                data: { searchTerm: searchTerm },
                success: function (response) {
                    const result = JSON.parse(response);
                    console.log(response);
                    tableUpdate(result);
                },
                error: function () {
                    console.error("Error fetching search results.");
                }
            });
        });
    
        function tableUpdate(results) {
            const tableBody = document.querySelector("#doneTable tbody");
            tableBody.innerHTML = "";
    
            if (results.length > 0) {
                results.forEach(function (result) {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${result.patient_name}</td>
                        <td>${result.type}</td>
                        <td>${result.schedule}</td>
                        <td>${result.status}</td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                const row = document.createElement("tr");
                row.innerHTML ='<td colspan="5">' +
                                '<img src="../../imgs/nodoneappointment.png" alt="No Appointments Image">' + 
                                '</td>';                
                tableBody.appendChild(row);
            }
        }
    });


// ==========================LIST PATIENTS =============================
    document.addEventListener("DOMContentLoaded", function () {
        const searchPatient = document.getElementById("search-patient");
        const searchPatientButton = document.getElementById("searchPatientButton");
    
        if (searchPatient && searchPatientButton) {
            searchPatientButton.addEventListener("click", function () {
                const searchKey = searchPatient.value.trim();
    
                $.ajax({
                    type: "POST",
                    url: "../../php/search_lists_patient.php",
                    data: { searchKey: searchKey },
                    success: function (response) {
                        const result = JSON.parse(response);
                        console.log(result)
                        updatePatientsList(result);
                    },
                    error: function () {
                        console.error("Error fetching search results.");
                    }
                });
            });
        } else {
            console.error("Search elements not found in the document.");
        }
    
        function updatePatientsList(results) {
            const showAllPatients = document.getElementById("showAllPatients");
            showAllPatients.innerHTML = "";
    
            if (results.length > 0) {
                results.forEach(function (patient) {
                    $('#showAllPatients').append(
                        '<div class="patient-box">' +
                            '<div class="patient-img">' +
                                '<div>' +
                                    '<img src="../../imgs/patient.png" alt="patient">' +
                                '</div>' +
                            '</div>' +

                            '<div class="patient-box-data">' +
                                '<ul>' +
                                    '<li>Name: ' + patient.name + '</li>' +
                                    '<li>Birthdate: ' + patient.birthdate + '</li>' +
                                    '<li>Sex: ' + patient.sex + '</li>' +
                                    '<li>Phone: ' + patient.phone + '</li>' +
                                    '<li>Barangay: ' + patient.barangay + '</li>' +
                                    '<li>Municipality: ' + patient.municipality + '</li>' +
                                    '<li>Province: ' + patient.province + '</li>' +
                                    '<li>Type: ' + patient.type + '</li>' +
                                '</ul>' +
                            '</div>' +
                        '</div>' 
                    );
                });
            } else {
                showAllPatients.innerHTML = 
                    '<tr style = "align-items: center">' +
                        '<td>' + '<center>' +
                            '<img src="../../imgs/noPatient.png" alt="No Appointments Image">' + 
                                '</center>'+
                        '</td>' +
                    '</tr>';
            }
        }
    });