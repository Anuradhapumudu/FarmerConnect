<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?= URLROOT ?>/css/seller/editproduct.css?v=<?= time(); ?>">

<?php
$product = $data['product'] ?? [];
?>

<main>
    <div class="form-wrapper">
        <h2><i class="fas fa-edit"></i> Edit Product</h2>

        <form method="post" action="<?= URLROOT ?>/Marketplace/EditProduct/index/<?= ($product['item_id'] ?? 0) ?>" enctype="multipart/form-data">

            <input type="hidden" name="item_id" value="<?= htmlspecialchars($product['item_id'] ?? '') ?>">
            <input type="hidden" name="current_image" value="<?= htmlspecialchars($product['image_url'] ?? '') ?>">

            <div class="required-note">Fields marked with <span class="required">*</span> are required</div>

            <label>Product Name: <span class="required">*</span></label>
            <input type="text" name="item_name" value="<?= htmlspecialchars($product['item_name'] ?? '') ?>" required>

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

            <label>Description:<span class="required">*</span></label>
            <textarea name="description" rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>

            <label>Status: <span class="required">*</span></label>
            <select name="status" required>
                <option value="">Select Status</option>
                <option value="Instock" <?= (isset($product['status']) && $product['status']=='Instock') ? 'selected' : '' ?>>In Stock</option>
                <option value="Outstock" <?= (isset($product['status']) && $product['status']=='Outstock') ? 'selected' : '' ?>>Out Stock</option>
            </select>

            <label>Region: <span class="required">*</span></label>
            <select name="region" required>
                <option value="">Select Region</option>
                <?php
                $regions = ['Colombo','Galle','Matara'];
                foreach ($regions as $reg) {
                    $selected = (isset($product['region']) && $product['region']==$reg) ? 'selected' : '';
                    echo "<option value='$reg' $selected>$reg</option>";
                }
                ?>
            </select>

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

            <label>Price Per Unit (LKR): <span class="required">*</span></label>
            <input type="number" name="price_per_unit" value="<?= htmlspecialchars($product['price_per_unit'] ?? '') ?>" step="0.01" required>

            <label>Available Quantity: <span class="required">*</span></label>
            <input type="number" name="available_quantity" value="<?= htmlspecialchars($product['available_quantity'] ?? '') ?>" required>

            <label>Current Image:</label>
            <?php if(!empty($product['image_url'])): ?>
                <img src="<?= URLROOT ?>/uploads/<?= htmlspecialchars($product['image_url']) ?>" class="product-image-preview">
            <?php endif; ?>

            <label>Upload New Image:</label>
            <input type="file" name="image">

            <button type="submit">Update Product</button>
            <a href="<?= URLROOT ?>/Marketplace/ManageProduct" class="back-button">Back to List</a>

        </form>
    </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
