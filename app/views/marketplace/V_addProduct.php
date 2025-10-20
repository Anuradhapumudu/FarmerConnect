<?php require_once APPROOT . '/views/inc/sellerheader.php'; ?>
<link rel="stylesheet" href="<?= URLROOT ?>/css/seller/addProduct.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">
  <div class="containers">
    <div class="form-wrapper">
      <div class="form-header">
        <div class="form-icon">
          <i class="fas fa-seedling"></i>
        </div>
        <h2>Add a New Product</h2>
      </div>
      
      <form method="post" action="<?= URLROOT ?>/marketplace/addProduct" enctype="multipart/form-data">
        <div class="form-grid">
          
          <!-- Product Name -->
          <div class="form-group">
            <label>Product Name <span class="required">*</span></label>
            <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" placeholder="Enter product name" 
                   class="<?= !empty($data['errors']['name']) ? 'error-field' : '' ?>">
            <?php if(!empty($data['errors']['name'])): ?>
              <div class="error"><?= $data['errors']['name'] ?></div>
            <?php endif; ?>
          </div>
          
          <!-- Seller ID -->
          <div class="form-group">
            <label>Seller ID <span class="required">*</span></label>
            <input type="text" name="seller_id" value="<?= htmlspecialchars($data['seller_id']) ?>" readonly>
          </div>
          
          <!-- Category -->
          <div class="form-group">
            <label>Category <span class="required">*</span></label>
            <select name="category" class="<?= !empty($data['errors']['category']) ? 'error-field' : '' ?>">
              <option value="">Select Category</option>
              <option value="Fertilizer" <?= $data['category']=='Fertilizer'?'selected':'' ?>>Fertilizer</option>
              <option value="Seeds" <?= $data['category']=='Seeds'?'selected':'' ?>>Paddy Seeds</option>
              <option value="Agrochemicals" <?= $data['category']=='Agrochemicals'?'selected':'' ?>>Agrochemicals</option>
              <option value="Equipments" <?= $data['category']=='Equipments'?'selected':'' ?>>Equipments</option>
              <option value="Rental" <?= $data['category']=='Rental'?'selected':'' ?>>Rent Machinery</option>
              <option value="Others" <?= $data['category']=='Others'?'selected':'' ?>>Others</option>
            </select>
            <?php if(!empty($data['errors']['category'])): ?>
              <div class="error"><?= $data['errors']['category'] ?></div>
            <?php endif; ?>
          </div>
          
          <!-- Status -->
          <div class="form-group">
            <label>Status <span class="required">*</span></label>
            <select name="status" class="<?= !empty($data['errors']['status']) ? 'error-field' : '' ?>">
              <option value="">Select Status</option>
              <option value="Instock" <?= $data['status']=='Instock'?'selected':'' ?>>In Stock</option>
              <option value="Outstock" <?= $data['status']=='Outstock'?'selected':'' ?>>Out of Stock</option>
            </select>
            <?php if(!empty($data['errors']['status'])): ?>
              <div class="error"><?= $data['errors']['status'] ?></div>
            <?php endif; ?>
          </div>
          
          <!-- Province -->
          <div class="form-group">
            <label>Province <span class="required">*</span></label>
            <select id="province" name="province" class="<?= !empty($data['errors']['province']) ? 'error-field' : '' ?>">
              <option value="">Select Province</option>
              <?php 
                $provinces = ["Central","Eastern","North Central","Northern","North Western","Sabaragamuwa","Southern","Uva","Western"];
                foreach($provinces as $province) {
                  $selected = $data['province']==$province ? 'selected' : '';
                  echo "<option value='$province' $selected>$province</option>";
                }
              ?>
            </select>
            <?php if(!empty($data['errors']['province'])): ?>
              <div class="error"><?= $data['errors']['province'] ?></div>
            <?php endif; ?>
          </div>
          
          <!-- District -->
          <div class="form-group">
            <label>District <span class="required">*</span></label>
            <select id="district" name="region" class="<?= !empty($data['errors']['region']) ? 'error-field' : '' ?>">
              <option value="">Select District</option>
            </select>
            <?php if(!empty($data['errors']['region'])): ?>
              <div class="error"><?= $data['errors']['region'] ?></div>
            <?php endif; ?>
          </div>
          
          <!-- Unit Type -->
          <div class="form-group">
            <label>Unit Type <span class="required">*</span></label>
            <select name="unit_type" class="<?= !empty($data['errors']['unit_type']) ? 'error-field' : '' ?>">
              <option value="">Select Unit</option>
              <option value="kg" <?= $data['unit_type']=='kg'?'selected':'' ?>>Kg</option>
              <option value="litre" <?= $data['unit_type']=='litre'?'selected':'' ?>>Litre</option>
              <option value="packet" <?= $data['unit_type']=='packet'?'selected':'' ?>>Packet</option>
              <option value="hour" <?= $data['unit_type']=='hour'?'selected':'' ?>>1 Hour</option>
              <option value="day" <?= $data['unit_type']=='day'?'selected':'' ?>>1 Day</option>
            </select>
            <?php if(!empty($data['errors']['unit_type'])): ?>
              <div class="error"><?= $data['errors']['unit_type'] ?></div>
            <?php endif; ?>
          </div>
          
          <!-- Price -->
          <div class="form-group">
            <label>Price Per Unit (LKR) <span class="required">*</span></label>
            <input type="number" step="0.1" name="price" value="<?= htmlspecialchars($data['price']) ?>" placeholder="0.00"
                   class="<?= !empty($data['errors']['price']) ? 'error-field' : '' ?>">
            <?php if(!empty($data['errors']['price'])): ?>
              <div class="error"><?= $data['errors']['price'] ?></div>
            <?php endif; ?>
          </div>
          
          <!-- Available Quantity -->
          <div class="form-group">
            <label>Available Quantity <span class="required">*</span></label>
            <input type="number" name="available" value="<?= htmlspecialchars($data['available']) ?>" placeholder="Enter quantity"
                   class="<?= !empty($data['errors']['available']) ? 'error-field' : '' ?>">
            <?php if(!empty($data['errors']['available'])): ?>
              <div class="error"><?= $data['errors']['available'] ?></div>
            <?php endif; ?>
          </div>
          
          <!-- Description -->
          <div class="form-group full-width">
            <label>Description (Optional)</label>
            <textarea name="description" rows="3" placeholder="Describe your product in detail"><?= htmlspecialchars($data['description']) ?></textarea>
          </div>
          
          <!-- Product Image -->
          <div class="form-group full-width">
            <label>Product Image <span class="required">*</span></label>
            <div class="file-input-container">
              <div class="file-input-button <?= !empty($data['errors']['image']) ? 'error-field' : '' ?>">
                Choose Product Image
              </div>
              <input type="file" name="image" accept="image/*">
            </div>
            <?php if(!empty($data['errors']['image'])): ?>
              <div class="error"><?= $data['errors']['image'] ?></div>
            <?php endif; ?>
          </div>

        </div>
        
        <div class="button-group">
          <button type="submit" class="btn btn-primary">Add Product</button>
          <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= URLROOT ?>/Marketplace/manageProduct'">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const fileInput = document.querySelector('input[type="file"]');
  const fileInputButton = document.querySelector('.file-input-button');
  
  fileInput.addEventListener('change', function() {
    if (this.files.length > 0) {
      fileInputButton.textContent = this.files[0].name;
      fileInputButton.style.borderColor = '#2e7d32';
      fileInputButton.style.background = '#e8f5e9';
    } else {
      fileInputButton.textContent = 'Choose Product Image';
      fileInputButton.style.borderColor = '';
      fileInputButton.style.background = '';
    }
  });

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

  const provinceSelect = document.getElementById('province');
  const districtSelect = document.getElementById('district');

  function populateDistricts(province, selectedDistrict = '') {
    districtSelect.innerHTML = '<option value="">Select District</option>';
    if (province && districtsByProvince[province]) {
      districtsByProvince[province].forEach(district => {
        const option = document.createElement('option');
        option.value = district;
        option.textContent = district;
        if (district === selectedDistrict) option.selected = true;
        districtSelect.appendChild(option);
      });
    }
  }

  provinceSelect.addEventListener('change', function() {
    populateDistricts(this.value);
  });

  const savedProvince = "<?= htmlspecialchars($data['province']) ?>";
  const savedDistrict = "<?= htmlspecialchars($data['region']) ?>";
  if (savedProvince) populateDistricts(savedProvince, savedDistrict);

  // Error field CSS
  const style = document.createElement('style');
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
  document.head.appendChild(style);
});
</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
