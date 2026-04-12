
// Load paddy size when PLR is selected
function loadPaddySize() {
    const plrSelect = document.getElementById('plrNumber');
    const paddySizeInput = document.getElementById('paddySize');
    const selectedOption = plrSelect.options[plrSelect.selectedIndex];

    if (selectedOption.value) {
        const paddySize = selectedOption.getAttribute('data-size');
        paddySizeInput.value = paddySize;
    } else {
        paddySizeInput.value = '';
    }
}

// Initialize paddy size on page load if PLR is already selected
document.addEventListener('DOMContentLoaded', function () {
    // Set dates
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('todayDate').value = today;
    if (!document.getElementById('observationDate').value) {
        document.getElementById('observationDate').value = today;
        document.getElementById('observationDate').max = today;
    }

    // Initialize paddy size if PLR is pre-selected
    const plrSelect = document.getElementById('plrNumber');
    if (plrSelect.value) {
        loadPaddySize();
    }

    // Affected Area Validation
    const affectedAreaInput = document.getElementById('affectedArea');
    const paddySizeInput = document.getElementById('paddySize');

    function validateAffectedArea() {
        const area = parseFloat(affectedAreaInput.value);
        const maxSize = parseFloat(paddySizeInput.value);

        if (!isNaN(area) && !isNaN(maxSize)) {
            if (area > maxSize) {
                affectedAreaInput.setCustomValidity(`Affected area cannot be larger than the paddy size (${maxSize} acres)`);
                affectedAreaInput.reportValidity();
            } else {
                affectedAreaInput.setCustomValidity('');
            }
        } else {
            affectedAreaInput.setCustomValidity('');
        }
    }

    if (affectedAreaInput && paddySizeInput) {
        affectedAreaInput.addEventListener('input', validateAffectedArea);
        // Also validate when paddy size changes (via PLR selection)
        // Since paddySize is readonly and updated via JS, we'll hook into the PLR change
        document.getElementById('plrNumber').addEventListener('change', function () {
            // Wait for stack to clear so paddySize updates first
            setTimeout(validateAffectedArea, 100);
        });
    }
});
