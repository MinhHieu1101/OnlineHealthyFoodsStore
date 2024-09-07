// Declare variables outside of the function scope
var codRadioButton, visaRadioButton, visaInfoDiv;

function validate() {
    // Get the radio buttons and the VISA info div
    codRadioButton = document.getElementById('payment_method_COD');
    visaRadioButton = document.getElementById('payment_method_VISA');
    visaInfoDiv = document.getElementById('visa_info');
}

function displayVisaInfo() {
    visaInfoDiv.style.display = "block";
}

function hideVisaInfo() {
    visaInfoDiv.style.display = "none";
}

function init() {
    // Call validate function to ensure that variables are initialized
    validate();

    // Check if radio buttons are defined before setting onclick handlers
    if (visaRadioButton && codRadioButton) {
        visaRadioButton.onclick = displayVisaInfo;
        codRadioButton.onclick = hideVisaInfo;
    } else {
        console.error("Radio buttons are not defined.");
    }
}

// Call init function when the document is ready
$(document).ready(init);
