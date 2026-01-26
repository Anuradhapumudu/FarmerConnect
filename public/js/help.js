//admin help page js

function enableEmergencyEdit() {
    document.getElementById('emergencyDisplay').style.display = 'none';
    document.getElementById('emergencyEdit').style.display = 'block';
}

function cancelEmergencyEdit() {
    document.getElementById('emergencyEdit').style.display = 'none';
    document.getElementById('emergencyDisplay').style.display = 'block';

    // hide error message if exists
    const errorBox = document.getElementById('emergencyError');
    if (errorBox) {
        errorBox.style.display = 'none';
    }
}

function resetMemberForm() {
    const form = document.querySelector('.add-officer-form');
    form.reset();

    // Clear input fields completely
    form.querySelectorAll('input').forEach(input => {
        input.value = '';
    });

    // Reset select dropdown to first option
    form.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
    });

    // hide error message if exists
    const errorBox = document.getElementById('memberError');
    if (errorBox) {
        errorBox.style.display = 'none';
    }
}



//scroll down to the error msg
window.onload = function() {
    const memberErrorBox = document.getElementById("memberError");
    const emergencyErrorBox = document.getElementById("emergencyError");

    if (memberErrorBox) {
        memberErrorBox.scrollIntoView({ behavior: "smooth", block: "center" });
        return;
    }

    if (emergencyErrorBox) {
        emergencyErrorBox.scrollIntoView({ behavior: "smooth", block: "center" });
    }
}





////user help page js
        // Simulate loading of team member images with fallback
        document.querySelectorAll('.member-img').forEach(img => {
            img.onerror = function() {
                this.src = "data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22100%22%20height%3D%22100%22%20viewBox%3D%220%200%20100%20100%22%3E%3Crect%20width%3D%22100%22%20height%3D%22100%22%20fill%3D%22%234CAF50%22%20%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%20font-size%3D%2236%22%20fill%3D%22white%22%3E%3Ctspan%20x%3D%2250%25%22%20dy%3D%22.35em%22%3E%3C%2Ftspan%3E%3C%2Ftext%3E%3C%2Fsvg%3E";
            };
        });