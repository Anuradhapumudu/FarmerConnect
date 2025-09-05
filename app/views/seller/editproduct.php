<?php require_once APPROOT . '/views/inc/header.php'; ?>

<!-- Edit Product C SS -->
<link rel="stylesheet" href="<?= URLROOT ?>/css/seller/editproduct.css?v=<?= time(); ?>">

<?php
$product = $data['product'] ?? [];
?>

<main>
    <div class="form-wrapper">
        <h2><i class="fas fa-edit"></i> Edit Product</h2>

        <form method="post" action="<?= URLROOT ?>/editproduct/index/<?= $product['item_id'] ?>" enctype="multipart/form-data">

            <input type="hidden" name="item_id" value="<?= htmlspecialchars($product['item_id'] ?? '') ?>">
            <input type="hidden" name="current_image" value="<?= htmlspecialchars($product['image_url'] ?? '') ?>">

            <div class="required-note">Fields marked with <span class="required">*</span> are required</div>

            <label>Product Name: <span class="required">*</span></label>
            <input type="text" name="item_name" value="<?= htmlspecialchars($product['item_name'] ?? '') ?>" required>

            <label>Product Type: <span class="required">*</span></label>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="Fertilizer" <?= isset($product['category']) && $product['category']=='Fertilizer' ? 'selected' : '' ?>>Fertilizer</option>
                <option value="Seeds" <?= isset($product['category']) && $product['category']=='Seeds' ? 'selected' : '' ?>>Seeds</option>
                <option value="Agrochemicals" <?= isset($product['category']) && $product['category']=='Agrochemicals' ? 'selected' : '' ?>>Agrochemicals</option>
                <option value="Equipments" <?= isset($product['category']) && $product['category']=='Equipments' ? 'selected' : '' ?>>Equipments</option>
                <option value="Rental" <?= isset($product['category']) && $product['category']=='Rental' ? 'selected' : '' ?>>Rent Machinery</option>
                <option value="Others" <?= isset($product['category']) && $product['category']=='Others' ? 'selected' : '' ?>>Others</option>
            </select>

            <label>Description:</label>
            <textarea name="description" rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>

            <label>Status: <span class="required">*</span></label>
            <select name="status" required>
                <option value="">Select Status</option>
                <option value="Instock" <?= isset($product['status']) && $product['status']=='Instock' ? 'selected' : '' ?>>In Stock</option>
                <option value="Outstock" <?= isset($product['status']) && $product['status']=='Outstock' ? 'selected' : '' ?>>Out Stock</option>
            </select>

            <label>Region: <span class="required">*</span></label>
            <select name="region" required>
                <option value="">Select Region</option>
                <option value="Colombo" <?= isset($product['region']) && $product['region']=='Colombo' ? 'selected' : '' ?>>Colombo</option>
                <option value="Galle" <?= isset($product['region']) && $product['region']=='Galle' ? 'selected' : '' ?>>Galle</option>
                <option value="Matara" <?= isset($product['region']) && $product['region']=='Matara' ? 'selected' : '' ?>>Matara</option>
            </select>

            <label>Unit Type: <span class="required">*</span></label>
            <select name="unit_type" required>
                <option value="">Select Unit</option>
                <option value="kg" <?= isset($product['unit_type']) && $product['unit_type']=='kg' ? 'selected' : '' ?>>Kg</option>
                <option value="litre" <?= isset($product['unit_type']) && $product['unit_type']=='litre' ? 'selected' : '' ?>>Litre</option>
                <option value="packet" <?= isset($product['unit_type']) && $product['unit_type']=='packet' ? 'selected' : '' ?>>Packet</option>
                <option value="hour" <?= isset($product['unit_type']) && $product['unit_type']=='hour' ? 'selected' : '' ?>>1 Hour</option>
                <option value="day" <?= isset($product['unit_type']) && $product['unit_type']=='day' ? 'selected' : '' ?>>1 Day</option>
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
            <a href="<?= URLROOT ?>/manageproduct" class="back-button">Back to List</a>

        </form>
    </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
