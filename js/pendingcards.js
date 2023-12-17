function patientCount() {
    var xhttpPatient = new XMLHttpRequest();
    var url = "../../php/get_total_pending.php";
    xhttpPatient.open("GET", url, true);
    xhttpPatient.onreadystatechange = function () {
        if (xhttpPatient.readyState == 4) {
            if (xhttpPatient.status == 200) {
                var data = JSON.parse(xhttpPatient.responseText);

                var nextCount = data.next_count;
                var nextPending = data.next_pending;
                var nextApproved = data.next_approved;

                document.getElementById('next_catered_count').innerText = nextCount;
                document.getElementById('pending-next-threedays').innerText = nextPending;
                document.getElementById('approved-next-threedays').innerText = nextApproved;

            } else {
                console.error("Error fetching data. Status code: " + xhttpPatient.status);
            }
        }
    };
    xhttpPatient.send();
}

$(document).ready(function () {
    patientCount();
});