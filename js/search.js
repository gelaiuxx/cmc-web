
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
            row.innerHTML = "<td colspan='4'>No results found</td>";
            tableBody.appendChild(row);
        }
    }
});
