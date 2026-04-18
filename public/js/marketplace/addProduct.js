// Wait until the whole HTML page is loaded before running JS
document.addEventListener('DOMContentLoaded', function () {



  // Select the hidden file input
  const fileInput = document.querySelector('input[type="file"]');

  // Select the custom button (styled button)
  const fileInputButton = document.querySelector('.file-input-button');

  // When user selects a file
  fileInput.addEventListener('change', function () {

    // If at least one file is selected
    if (this.files.length > 0) {

      // Show selected file name on button
      fileInputButton.textContent = this.files[0].name;

      // Change button style to indicate success
      fileInputButton.style.borderColor = '#2e7d32';
      fileInputButton.style.background = '#e8f5e9';

    } else {

      // Reset button text if no file selected
      fileInputButton.textContent = 'Choose Product Image';

      // Reset styles
      fileInputButton.style.borderColor = '';
      fileInputButton.style.background = '';
    }
  });



  // Object that maps provinces to their districts
  const districtsByProvince = {
    "Central": ["Kandy", "Matale", "Nuwara Eliya"],
    "Eastern": ["Ampara", "Batticaloa", "Trincomalee"],
    "North Central": ["Anuradhapura", "Polonnaruwa"],
    "Northern": ["Jaffna", "Kilinochchi", "Mannar", "Mullaitivu", "Vavuniya"],
    "North Western": ["Kurunegala", "Puttalam"],
    "Sabaragamuwa": ["Kegalle", "Ratnapura"],
    "Southern": ["Galle", "Hambantota", "Matara"],
    "Uva": ["Badulla", "Monaragala"],
    "Western": ["Colombo", "Gampaha", "Kalutara"]
  };





  // Province dropdown
  const provinceSelect = document.getElementById('province');

  // District dropdown
  const districtSelect = document.getElementById('district');


 


  function populateDistricts(province, selectedDistrict = '') {

    // Reset district dropdown
    districtSelect.innerHTML = '<option value="">Select District</option>';

    // If province exists in our data
    if (province && districtsByProvince[province]) {

      // Loop through districts and create options
      districtsByProvince[province].forEach(district => {

        const option = document.createElement('option');
        option.value = district;
        option.textContent = district;

        // Keep previously selected district (for edit forms)
        if (district === selectedDistrict) {
          option.selected = true;
        }

        districtSelect.appendChild(option);
      });
    }
  }




  provinceSelect.addEventListener('change', function () {

    // Update district dropdown based on selected province
    populateDistricts(this.value);

  });




  // Previously selected province (from backend)
  const savedProvince = "<?= htmlspecialchars($data['province']) ?>";

  // Previously selected district
  const savedDistrict = "<?= htmlspecialchars($data['region']) ?>";

  // If data exists, populate districts with selected value
  if (savedProvince) {
    populateDistricts(savedProvince, savedDistrict);
  }




  // Create a style element
  const style = document.createElement('style');

  // Add CSS for error fields
  style.textContent = `
    .error-field {
      border: 2px solid #d32f2f !important;
      background-color: #ffebee !important;
    }

    .error {
      color: #d32f2f;
      font-size: 14px;
      margin-top: 5px;
    }
  `;

  // Add styles to the page
  document.head.appendChild(style);

});