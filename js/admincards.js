function fetchPatientCount() {
    var xhttpPatientCounts = new XMLHttpRequest();
    var url = "../../php/get_total_admin_cards.php";
    xhttpPatientCounts.open("GET", url, true);
    xhttpPatientCounts.onreadystatechange = function () {
        if (xhttpPatientCounts.readyState == 4) {
            if (xhttpPatientCounts.status == 200) {
                var data = JSON.parse(xhttpPatientCounts.responseText);

                var todayCount = data.today_count;
                var todayPending = data.today_pending;
                var todayDone = data.today_done;
                var tomorrowPending = data.tom_pending;

                document.getElementById('patients-catered-today').innerText = todayCount;
                document.getElementById('patients-pending-today').innerText = todayPending;
                document.getElementById('patients-done').innerText = todayDone;
                document.getElementById('patients-tom-pending').innerText = tomorrowPending;

            } else {
                console.error("Error fetching data. Status code: " + xhttpPatientCount.status);
            }
        }
    };
    xhttpPatientCounts.send();
}

$(document).ready(function () {
    fetchPatientCount();
});