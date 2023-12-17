document.addEventListener('DOMContentLoaded', function () {
    createCalendar(new Date());
});

function createCalendar(date) {
    const calendarContainer = document.getElementById('dateContent');
    const MonthContainer = document.getElementById('MonthContainer');
    MonthContainer.textContent = formatDate(date, { month: 'long', year: 'numeric' });
    calendarContainer.innerHTML = '';

    // Calculate the first and last day of the month
    const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    // console.log("This is from lastDay" +lastDay);

    // Initialize variables for the loop
    let currentDate = new Date(firstDay);
    // console.log(currentDate);

    const table = document.createElement('table');
    const thead = document.createElement('thead');
    const tbody = document.createElement('tbody');

    // Create header row
    const headerRow = document.createElement('tr');
    const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    daysOfWeek.forEach(day => {
        const th = document.createElement('th');
        th.textContent = day;
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);

    const startingDayOfWeek = firstDay.getDay();
    // console.log("starting day of the week is " + startingDayOfWeek);

    let row = document.createElement('tr');
    for (let i = 0; i < 7; i++) {
        if (i < startingDayOfWeek) {
            // Add empty cells for days before the 1st day of the month
            const cell = document.createElement('td');
            row.appendChild(cell);
        } else {
            // Add cells for the 1st day and onwards
            const cell = document.createElement('td');
            const dayOfMonth = currentDate.getDate();
            cell.textContent = dayOfMonth;
            cell.setAttribute('data-date', formattedDate(currentDate, { year: 'numeric', month: '2-digit', day: '2-digit' }));
            const slotIndicator = document.createElement('div');
            slotIndicator.classList = "allocation";
            fetchslots(cell.getAttribute("data-date"));
            console.log(slotIndicator);

            if (isSameDate(currentDate, new Date())) {
                cell.classList.add('highlight');
            }

            cell.appendChild(slotIndicator);
            row.appendChild(cell);
            currentDate.setDate(currentDate.getDate() + 1);
        }
    }
    tbody.appendChild(row);

    // Continue creating the rest of the calendar cells
    while (currentDate <= lastDay) {
        row = document.createElement('tr');
        for (let j = 0; j < 7 && currentDate <= lastDay; j++) {
            const cell = document.createElement('td');
            const dayOfMonth = currentDate.getDate();
            cell.textContent = dayOfMonth;
            cell.setAttribute('data-date', formattedDate(currentDate, { year: 'numeric', month: '2-digit', day: '2-digit' }));
            const slotIndicator = document.createElement('div');
            slotIndicator.classList = "allocation";
            fetchslots(cell.getAttribute("data-date"));
            console.log(slotIndicator);

            if (isSameDate(currentDate, new Date())) {
                cell.classList.add('highlight');
            }
            cell.appendChild(slotIndicator);
            row.appendChild(cell);
            currentDate.setDate(currentDate.getDate() + 1);
        }
        tbody.appendChild(row);
    }

    table.appendChild(thead);
    table.appendChild(tbody);
    calendarContainer.appendChild(table);

}

function handleCellClick(date) {
    const formattedDate = formatDate(date, { year: 'numeric', month: '2-digit', day: '2-digit' });
    console.log(`Clicked on date: ${formattedDate}`);
}

function prevMonth() {
    const currentMonth = new Date(document.getElementById('MonthContainer').textContent);
    currentMonth.setMonth(currentMonth.getMonth() - 1);
    createCalendar(currentMonth);
}

function nextMonth() {
    const currentMonth = new Date(document.getElementById('MonthContainer').textContent);
    currentMonth.setMonth(currentMonth.getMonth() + 1);
    createCalendar(currentMonth);
}

function formatDate(date, options) {
    return date.toLocaleDateString('en-US', options).replace(/\//g, '-');
}
function formattedDate(date, options) {
    return date.toLocaleDateString('fr-CA', options).replace(/\//g, '-');
}

function isSameDate(date1, date2) {
    return (
        date1.getFullYear() === date2.getFullYear() &&
        date1.getMonth() === date2.getMonth() &&
        date1.getDate() === date2.getDate()
    );
}

// Function to fetch slots information
function fetchslots(allocation) {
    $.ajax({
        url: '../../php/counter.php',
        type: 'POST',
        data: { day: allocation },
        success: function (data) {
            try {
                const allocated = JSON.parse(data);
                const dateHere = allocated.dayToday;
                const allocationContainer = document.querySelector(`td[data-date="${allocation}"] .allocation`);

                if (dateHere == allocation && allocationContainer) {
                    allocationContainer.textContent = allocated.slotsTaken + "/10";

                    const value = parseInt(allocated.slotsTaken, 10);
                    const backgroundColor = value >= 10 ? '#D21312' : '#2e9254';

                    const cell = document.querySelector(`td[data-date="${allocation}"]`);
                    if (cell) {
                        cell.style.background = backgroundColor;
                    }
                    allocationContainer.style.color = value >= 10 ? '#fff' : '#fff';
                }
            } catch (error) {
                console.error('Error parsing JSON:', error);
                console.log('Raw response:', data);
            }
        }
    });
}