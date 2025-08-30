<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/seller/addProduct.css">


<main class="main-content" id="mainContent">

 <div class="form-wrapper">
    <h2><i class="fa-solid fa-plus-circle"></i> Add a Product</h2>


<form method="post" action="" enctype="multipart/form-data">
    <label>Product Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" required>

    <label>Seller Id:</label>
    <input type="text" name="seller_id" value="<?= htmlspecialchars($data['seller_id']) ?>" required>

    <label>Category:</label>
    <select name="category" required>
        <option value="">Select Category</option>
        <option value="Fertilizer" <?= $data['category']=='Fertilizer'?'selected':'' ?>>Fertilizer</option>
        <option value="Seeds" <?= $data['category']=='Seeds'?'selected':'' ?>>Seeds</option>
        <option value="Tools" <?= $data['category']=='Tools'?'selected':'' ?>>Tools</option>
    </select>

    <label>Description:</label>
    <textarea name="description" rows="3" required><?= htmlspecialchars($data['description']) ?></textarea>

    <label>Region:</label>
    <select name="region" required>
        <option value="">Select Region</option>
        <option value="Colombo" <?= $data['region']=='Colombo'?'selected':'' ?>>Colombo</option>
        <option value="Galle" <?= $data['region']=='Galle'?'selected':'' ?>>Galle</option>
        <option value="Matara" <?= $data['region']=='Matara'?'selected':'' ?>>Matara</option>
    </select>

    <label>Unit Type:</label>
    <select name="unit_type" required>
        <option value="">Select Unit</option>
        <option value="kg" <?= $data['unit_type']=='kg'?'selected':'' ?>>Kg</option>
        <option value="litre" <?= $data['unit_type']=='litre'?'selected':'' ?>>Litre</option>
        <option value="packet" <?= $data['unit_type']=='packet'?'selected':'' ?>>Packet</option>
    </select>

    <label>Price Per Unit (LKR):</label>
    <input type="number" step="0.1" name="price" value="<?= htmlspecialchars($data['price']) ?>" required>

    <label>Available Quantity:</label>
    <input type="number" name="available" value="<?= htmlspecialchars($data['available']) ?>" required>

    <label>Image:</label>
    <input type="file" name="image" accept="image/*" required>

    <?php if (!empty($data['success'])): ?>
        <div class="success"><?= $data['success'] ?></div>
    <?php endif; ?>
    <?php if (!empty($data['error'])): ?>
        <div class="error"><?= $data['error'] ?></div>
    <?php endif; ?>

    <div style="display:flex; gap:10px; margin-top:20px;">
        <button type="submit" style="flex:1; background:#2e7d32;">
            <i class="fa-solid fa-check"></i> Add Product
        </button>
        <button type="button" onclick="window.location.href='<?= URLROOT ?>/manageproduct'" 
                style="flex:1; background:#dc3545;">
            <i class="fa-solid fa-xmark"></i> Cancel
        </button>
    </div>
</form>
    </div>
</main>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
