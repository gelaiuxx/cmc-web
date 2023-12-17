// search.js

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const searchButton = document.getElementById("searchButton");

    searchButton.addEventListener("click", function () {
        const searchTerm = searchInput.value.trim();

        // Perform AJAX request to the server to get search results
        $.ajax({
            type: "POST",
            url: "../../php/search_history.php", // Create a new PHP file for handling search
            data: { searchTerm: searchTerm },
            success: function (response) {
                const result = JSON.parse(response);
                updateTable(result);
            },
            error: function () {
                console.error("Error fetching search results.");
            }
        });
    });

    function updateTable(results) {
        const tableBody = document.querySelector("#myHistoryTable tbody");
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
            row.innerHTML ='<td colspan="5"><img src="../../imgs/nodoneappointments.png" alt="No Appointments Image"></td>';
            tableBody.appendChild(row);
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const search = document.getElementById("search-history");
    const searchHistoryButton = document.getElementById("searchHistoryButton");

    searchHistoryButton.addEventListener("click", function () {
        const searchTerm = search.value.trim();

        $.ajax({
            type: "POST",
            url: "../../php/admin_search.php",
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
            row.innerHTML ='<td colspan="5"><img src="../../imgs/nodoneappointments.png" alt="No Appointments Image"></td>';
            tableBody.appendChild(row);
        }
    }
});



document.addEventListener("DOMContentLoaded", function () {
    const searchPatient = document.getElementById("search-patient");
    const searchPatientButton = document.getElementById("searchPatientButton");

    if (searchPatient && searchPatientButton) {
        searchPatientButton.addEventListener("click", function () {
            const searchKey = searchPatient.value.trim();

            $.ajax({
                type: "POST",
                url: "../../php/search_patients.php",
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
                    '<img src="../../imgs/patients.png" alt="patient">' +
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
            showAllPatients.innerHTML ='<center><img src="../../imgs/nopatientsfound.png" alt="No patients found Image"></center>';
        }
    }
});
