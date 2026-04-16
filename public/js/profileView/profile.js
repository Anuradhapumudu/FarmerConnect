        document.getElementById('uploadInput').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);

                const removeFlag = document.getElementById('removed_flag');
                if (removeFlag) removeFlag.remove();
            }
        });



//when error happen jump to it
        window.onload = function() {
    const firstError = document.querySelector('.error-field');

    if (firstError) {
        firstError.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        // optional: highlight input
        const input = firstError.previousElementSibling;
        if (input) {
            input.style.border = "2px solid red";
        }
    }
};