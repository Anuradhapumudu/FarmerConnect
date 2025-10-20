<?php require_once APPROOT . '/views/inc/sellerheader.php'; ?>

<link rel="stylesheet" href="<?= URLROOT ?>/css/seller/editproduct.css?v=<?= time(); ?>">

<?php
$product = $data['product'] ?? [];
$errors = $data['errors'] ?? [];
?>

<main class="main-content" id="mainContent">
  <div class="containers">
    <div class="form-wrapper">
        <div class="form-header">
            <div class="form-icon">
            <h2><i class="fas fa-edit"></i> 
            </div>
            <h2>Edit Product</h2>
        </div>

        <p class="required-note"><span class="required">*</span> indicates required fields</p>

        <?php if(!empty($errors['general'])): ?>
            <div class="error"><?= $errors['general'] ?></div>
        <?php endif; ?>

        <form method="post" action="<?= URLROOT ?>/Marketplace/editProduct/<?= ($product['item_id'] ?? 0) ?>" enctype="multipart/form-data">

            <input type="hidden" name="item_id" value="<?= htmlspecialchars($product['item_id'] ?? '') ?>">
            <input type="hidden" name="current_image" value="<?= htmlspecialchars($product['image_url'] ?? '') ?>">

            <div class="form-grid">
                <!-- Product Name -->
                <div class="form-group">
                    <label>Product Name: <span class="required">*</span></label>
                    <input type="text" name="item_name" value="<?= htmlspecialchars($product['item_name'] ?? '') ?>" required>
                    <?php if(!empty($errors['name'])): ?>
                        <div class="error"><?= $errors['name'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label>Product Type: <span class="required">*</span></label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <?php
                        $categories = ['Fertilizer','Seeds','Agrochemicals','Equipments','Rental','Others'];
                        foreach ($categories as $cat) {
                            $selected = (isset($product['category']) && $product['category']==$cat) ? 'selected' : '';
                            echo "<option value='$cat' $selected>$cat</option>";
                        }
                        ?>
                    </select>
                    <?php if(!empty($errors['category'])): ?>
                        <div class="error"><?= $errors['category'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <div class="form-group full-width">
                    <label>Description(Optional):
                    <textarea name="description" rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label>Status: <span class="required">*</span></label>
                    <select name="status" required>
                        <option value="">Select Status</option>
                        <option value="Instock" <?= (isset($product['status']) && $product['status']=='Instock') ? 'selected' : '' ?>>In Stock</option>
                        <option value="Outstock" <?= (isset($product['status']) && $product['status']=='Outstock') ? 'selected' : '' ?>>Out Stock</option>
                    </select>
                    <?php if(!empty($errors['status'])): ?>
                        <div class="error"><?= $errors['status'] ?></div>
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
                  $selected = (isset($product['province']) && $product['province'] == $province) ? 'selected' : '';
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
                    <label>Unit Type: <span class="required">*</span></label>
                    <select name="unit_type" required>
                        <option value="">Select Unit</option>
                        <?php
                        $units = ['kg','litre','packet','hour','day'];
                        foreach ($units as $unit) {
                            $selected = (isset($product['unit_type']) && $product['unit_type']==$unit) ? 'selected' : '';
                            echo "<option value='$unit' $selected>$unit</option>";
                        }
                        ?>
                    </select>
                    <?php if(!empty($errors['unit_type'])): ?>
                        <div class="error"><?= $errors['unit_type'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Price -->
                <div class="form-group">
                    <label>Price Per Unit (LKR): <span class="required">*</span></label>
                    <input type="number" name="price_per_unit" value="<?= htmlspecialchars($product['price_per_unit'] ?? '') ?>" step="0.01" required>
                    <?php if(!empty($errors['price'])): ?>
                        <div class="error"><?= $errors['price'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Available Quantity -->
                <div class="form-group">
                    <label>Available Quantity: <span class="required">*</span></label>
                    <input type="number" name="available_quantity" value="<?= htmlspecialchars($product['available_quantity'] ?? '') ?>" required>
                    <?php if(!empty($errors['available'])): ?>
                        <div class="error"><?= $errors['available'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Image -->
                <label>Current Image:</label>
                <?php if(!empty($product['image_url'])): ?>
                    <img src="<?= URLROOT ?>/uploads/<?= htmlspecialchars($product['image_url']) ?>" class="product-image-preview" style="max-width:150px;">
                <?php endif; ?>

                <div class="form-group full-width">
                    <label>Upload New Image:</label>
                    <div class="file-input-container">
                        <div class="file-input-button">
                            <i class="fas fa-cloud-upload-alt"></i> Choose Product Image
                        </div>
                        <input type="file" name="image" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check-circle"></i> Update Product
                </button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= URLROOT ?>/Marketplace/manageProduct'">
                    <i class="fas fa-times-circle"></i> Cancel
                </button>
            </div>
        </form>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.querySelector('input[type="file"]');
    const fileInputButton = document.querySelector('.file-input-button');

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            fileInputButton.innerHTML = `<i class="fas fa-check-circle"></i> ${this.files[0].name}`;
            fileInputButton.style.borderColor = '#2e7d32';
            fileInputButton.style.background = '#e8f5e9';
        } else {
            fileInputButton.innerHTML = `<i class="fas fa-cloud-upload-alt"></i> Choose Product Image`;
        }
    });

     const districtsByProvince = {
        "Central": ["Kandy","Matale","Nuwara Eliya"],
        "Eastern": ["Ampara","Batticaloa","Trincomalee"],
        "Northern": ["Jaffna","Kilinochchi","Mannar","Mullaitivu","Vavuniya"],
        "North Central": ["Anuradhapura","Polonnaruwa"],
        "North Western": ["Kurunegala","Puttalam"],
        "Sabaragamuwa": ["Kegalle","Ratnapura"],
        "Southern": ["Galle","Matara","Hambantota"],
        "Uva": ["Badulla","Monaragala"],
        "Western": ["Colombo","Gampaha","Kalutara"]
    };

    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');

    function populateDistricts(selectedProvince, selectedDistrict = null) {
        districtSelect.innerHTML = '<option value="">Select District</option>';
        if(districtsByProvince[selectedProvince]) {
            districtsByProvince[selectedProvince].forEach(dist => {
                const option = document.createElement('option');
                option.value = dist;
                option.textContent = dist;
                if(dist === selectedDistrict) option.selected = true;
                districtSelect.appendChild(option);
            });
        }
    }

    // Populate on page load if province exists
    populateDistricts(provinceSelect.value, "<?= $product['region'] ?? '' ?>");

    // Populate when province changes
    provinceSelect.addEventListener('change', function() {
        populateDistricts(this.value);
    });
});
</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>