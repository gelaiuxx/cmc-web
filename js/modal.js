let currentStep = 1; // Initialize current step

$('.make-appointment-btn').on('click', function () {
    currentStep = 1; 
    $('#appointmentModal').css('display', 'block');
    showStep(currentStep);
});

// Close the modal
function closeModal() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will exit the form and lose your progress.',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Yes, close it!'

    }).then((result) => {
        if (result.isConfirmed) {
            $('#appointmentModal').css('display', 'none');
            $('#addDependentModal').css('display', 'none');

        }
        // If user clicks "Cancel", do nothing
    });
}

function showStep(stepNumber) {
    $('.modal-step').css('display', 'none');
    $('#step' + stepNumber).css('display', 'block');
    updateProgressBar(stepNumber);
    currentStep = stepNumber;
}

function updateProgressBar(stepNumber) {
    for (let i = 1; i <= 4; i++) {
        const progressStep = $('#progress' + i);
        const progressLine = $('.progress-line').eq(i - 1);

        if (i < stepNumber) {
            progressStep.addClass('completed').html('✔');
            progressLine.addClass('completed');
        } else {
            progressStep.removeClass('completed').html(i);
            progressLine.removeClass('completed');
        }
    }
}


// Move to the next step without validation
function nextStep() {

    showStep(currentStep + 1);
}

// Move to the previous step
function prevStep() {
    showStep(currentStep - 1);
}


function openAddDependentModal() {
    var addDependentModal = document.getElementById('addDependentModal');
    addDependentModal.style.display = 'block';
}


function submitAddDependentForm(event) {

    event.preventDefault();
}


function openDepartmentLegendsModal() {
    var departmentLegend = document.getElementById('departmentLegend');
    departmentLegend.style.display = 'block';
}

function closeDepartmentLegendsModal() {
    var departmentLegend = document.getElementById('departmentLegend');
    departmentLegend.style.display = 'none';
}





// //FOR CONFIRMATION MODAL IN MAKING APPOINTMENT

// $('.submit-button').on('click', function () {
//     openConfirmationModal();
// });

// function openConfirmationModal() {
//     console.log('Opening confirmation modal');  // Add this line for debugging
//     var modal = document.getElementById('confirmationModal');
//     modal.style.display = 'block';
// }

// // Function to close the confirmation modal
// function closeConfirmationModal() {
//     var modal = document.getElementById('confirmationModal');
//     modal.style.display = 'none';
// }

// // Function to handle the confirmation and submit the form
// function confirmSubmit() {
//     showSuccessModal();

//     closeConfirmationModal();
// }


// $('.confirm-button').on('click', function () {
//     showSuccessModal();
// });

// // Function to open the success modal
// function showSuccessModal() {
//     // Show the loader
//     document.getElementById('loader').style.display = 'block';

//     setTimeout(function () {
//         // Hide the loader
//         document.getElementById('loader').style.display = 'none';

//         // Show the success modal
//         document.getElementById('successModal').style.display = 'block';
//     }, 1000);

// }
// // Function to close the success modal
// function closeSuccessModal() {
//     var successModal = document.getElementById('successModal');
//     successModal.style.display = 'none';
// }

// // Function to print the success modal
// function printSuccessModal() {
//     window.print(); // Trigger browser's print functionality
// }







