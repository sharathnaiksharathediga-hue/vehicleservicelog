// ========================================
// Vehicle Service Center - JavaScript
// ========================================


// ----------------------------------------
// 1. Delete Confirmation
// ----------------------------------------

function confirmDelete(message = "Are you sure you want to delete this record?") {

    return confirm(message);

}


// ----------------------------------------
// 2. Form Validation
// ----------------------------------------

function validateForm(form) {

    let inputs = form.querySelectorAll("input[required], select[required]");

    for (let input of inputs) {

        if (input.value.trim() === "") {

            alert("Please fill all required fields.");

            input.focus();

            return false;
        }
    }

    return true;
}


// ----------------------------------------
// 3. Phone Number Validation
// ----------------------------------------

function validatePhone(phone) {

    let phonePattern = /^[0-9]{10}$/;

    if (!phonePattern.test(phone)) {

        alert("Please enter a valid 10-digit phone number.");

        return false;
    }

    return true;
}


// ----------------------------------------
// 4. Amount Validation
// ----------------------------------------

function validateAmount(amount) {

    if (amount <= 0 || isNaN(amount)) {

        alert("Please enter a valid amount.");

        return false;
    }

    return true;
}


// ----------------------------------------
// 5. Automatically Hide Messages
// ----------------------------------------

document.addEventListener("DOMContentLoaded", function () {

    const messages = document.querySelectorAll(
        ".success, .error"
    );

    messages.forEach(function (message) {

        setTimeout(function () {

            message.style.display = "none";

        }, 4000);

    });

});