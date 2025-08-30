<?php require_once APPROOT . '/views/inc/header.php'; ?>

<!-- Marketplace-specific CSS -->
<link rel="stylesheet" href="<?= URLROOT ?>/css/seller/editproduct.css?v=<?= time(); ?>">

<?php
// Ensure $product is available and cast to array if it's an object
if (isset($product) && is_object($product)) {
    $product = (array) $product;
}
?>

<main class="main-content" id="mainContent">
    <h2><i class="fas fa-edit"></i> Edit Product</h2>

    <form method="post" action="<?= URLROOT ?>/products/update" enctype="multipart/form-data">
        <input type="hidden" name="item_id" value="<?= htmlspecialchars($product['item_id'] ?? '') ?>">
        <input type="hidden" name="current_image" value="<?= htmlspecialchars($product['image_url'] ?? '') ?>">

            
            <div class="card">
                <h3>Product Information</h3>
                <div class="form-section">
                    <div class="image-container">
                        <img src="<?= URLROOT ?>/uploads/<?= htmlspecialchars($product['image_url'] ?? '') ?>" class="product-image">
                        <label>Add New Image :</label>
                        <input type="file" name="image">
                    </div>

                    <div class="info-container">
                        <label>Product Name:</label>
                        <input type="text" name="item_name" value="<?= htmlspecialchars($product['item_name'] ?? '') ?>" required>

                        <label>Product Type:</label>
                        <select name="category" required>
                            <option value="">Select Category</option>
                            <option value="Fertilizer" <?= isset($product['category']) && $product['category']=='Fertilizer' ? 'selected' : '' ?>>Fertilizer</option>
                            <option value="Seeds" <?= isset($product['category']) && $product['category']=='Seeds' ? 'selected' : '' ?>>Seeds</option>
                            <option value="Tools" <?= isset($product['category']) && $product['category']=='Tools' ? 'selected' : '' ?>>Tools</option>
                        </select>

                        <label>Brand:</label>
                        <input type="text" name="brand" value="<?= htmlspecialchars($product['brand'] ?? '') ?>">

                        <label>Price:</label>
                        <input type="number" name="price_per_unit" value="<?= htmlspecialchars($product['price_per_unit'] ?? '') ?>" step="0.01" required>

                        <label>Discount (%):</label>
                        <input type="number" name="discount" value="<?= htmlspecialchars($product['discount'] ?? '') ?>" step="1">

                        <label>Discount Price:</label>
                        <input type="number" name="discount_price" value="<?= htmlspecialchars($product['discount_price'] ?? '') ?>" step="0.01">

                        <label>Description:</label>
                        <textarea name="description" rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>

                        <label>Expiration Date:</label>
                        <input type="date" name="expiration_date" value="<?= htmlspecialchars($product['expiration_date'] ?? '') ?>">

                        <label>Available Quantity:</label>
                        <input type="number" name="available_quantity" value="<?= htmlspecialchars($product['available_quantity'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="button-container">
                    <input type="submit" value="Update">
                    <a href="<?= URLROOT ?>/products/manage" class="button">Back to List</a>
                </div>
            </div>
            
    
    </form>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
