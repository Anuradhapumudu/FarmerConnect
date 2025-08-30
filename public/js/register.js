function showForm(formId, button) {
    document.querySelectorAll('.form-box').forEach(form => {
        form.classList.remove('active');
    });
    document.getElementById(formId).classList.add('active');

    // Reset all buttons
    document.querySelectorAll('.btn-group button').forEach(btn => {
        btn.classList.remove('active');
    });

    // Highlight the clicked button
    button.classList.add('active');
}
