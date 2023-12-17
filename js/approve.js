$(document).ready(function() {
    approvedAppointment();
});

function approvedAppointment() {
    $.ajax({
        url: '../../php/fetch_approved_app.php',
        method: 'GET',
        success: function (response) {
            var appointments = JSON.parse(response);
            $('#approvedTable tbody').empty();
            if (appointments.length > 0) {
                $.each(appointments, function (index, appointment) {
                    $('#approvedTable tbody').append(
                        
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
                $('#approvedTable tbody').append(

                    '<tr>'+
                        '<td style="text-align:center; width:"100%"">' +
                            '<p style=font-weight: bold;">' + 'No Approved Appointments next day.' + '</p>'+
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