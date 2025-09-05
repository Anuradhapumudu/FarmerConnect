<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/seller/addProduct.css">

<main class="main-content" id="mainContent">
 <div class="form-wrapper">
    <h2><i class="fa-solid fa-plus-circle"></i> Add a Product</h2>
    <p class="required-note"><span class="required">*</span> indicates required fields</p>

    <?php if(!empty($data['errors']['general'])): ?>
        <div class="error"><?= $data['errors']['general'] ?></div>
    <?php endif; ?>

    <form method="post" action="" enctype="multipart/form-data">

        <label>Product Name: <span class="required">*</span></label>
        <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>">
        <?php if(!empty($data['errors']['name'])): ?>
            <small class="error"><?= $data['errors']['name'] ?></small>
        <?php endif; ?>

        <label>Seller Id: <span class="required">*</span></label>
        <input type="text" name="seller_id" value="<?= htmlspecialchars($data['seller_id']) ?>">
        <?php if(!empty($data['errors']['seller_id'])): ?>
            <small class="error"><?= $data['errors']['seller_id'] ?></small>
        <?php endif; ?>

        <label>Category: <span class="required">*</span></label>
        <select name="category">
            <option value="">Select Category</option>
            <option value="Fertilizer" <?= $data['category']=='Fertilizer'?'selected':'' ?>>Fertilizer</option>
            <option value="Seeds" <?= $data['category']=='Seeds'?'selected':'' ?>>Paddy Seeds</option>
            <option value="Agrochemicals" <?= $data['category']=='Agrochemicals'?'selected':'' ?>>Agrochemicals</option>
            <option value="Equipments" <?= $data['category']=='Equipments'?'selected':'' ?>>Equipments</option>
            <option value="Rental" <?= $data['category']=='Rental'?'selected':'' ?>>Rent Machinery</option>
            <option value="Others" <?= $data['category']=='Others'?'selected':'' ?>>Others</option>
        </select>
        <?php if(!empty($data['errors']['category'])): ?>
            <small class="error"><?= $data['errors']['category'] ?></small>
        <?php endif; ?>

        <label>Description: <span class="required">*</span></label>
        <textarea name="description" rows="3"><?= htmlspecialchars($data['description']) ?></textarea>
        <?php if(!empty($data['errors']['description'])): ?>
            <small class="error"><?= $data['errors']['description'] ?></small>
        <?php endif; ?>

        <label>Status: <span class="required">*</span></label>
        <select name="status">
            <option value="">Select Status</option>
            <option value="Instock" <?= $data['status']=='Instock'?'selected':'' ?>>In Stock</option>
            <option value="Outstock" <?= $data['status']=='Outstock'?'selected':'' ?>>Out Stock</option>
        </select>
        <?php if(!empty($data['errors']['status'])): ?>
            <small class="error"><?= $data['errors']['status'] ?></small>
        <?php endif; ?>

        <label>Region: <span class="required">*</span></label>
        <select name="region">
            <option value="">Select Region</option>
            <option value="Colombo" <?= $data['region']=='Colombo'?'selected':'' ?>>Colombo</option>
            <option value="Galle" <?= $data['region']=='Galle'?'selected':'' ?>>Galle</option>
            <option value="Matara" <?= $data['region']=='Matara'?'selected':'' ?>>Matara</option>
        </select>
        <?php if(!empty($data['errors']['region'])): ?>
            <small class="error"><?= $data['errors']['region'] ?></small>
        <?php endif; ?>

        <label>Unit Type: <span class="required">*</span></label>
        <select name="unit_type">
            <option value="">Select Unit</option>
            <option value="kg" <?= $data['unit_type']=='kg'?'selected':'' ?>>Kg</option>
            <option value="litre" <?= $data['unit_type']=='litre'?'selected':'' ?>>Litre</option>
            <option value="packet" <?= $data['unit_type']=='packet'?'selected':'' ?>>Packet</option>
            <option value="hour" <?= $data['unit_type']=='hour'?'selected':'' ?>>1 Hour</option>
            <option value="day" <?= $data['unit_type']=='day'?'selected':'' ?>>1 Day</option>
        </select>
        <?php if(!empty($data['errors']['unit_type'])): ?>
            <small class="error"><?= $data['errors']['unit_type'] ?></small>
        <?php endif; ?>

        <label>Price Per Unit (LKR): <span class="required">*</span></label>
        <input type="number" step="0.1" name="price" value="<?= htmlspecialchars($data['price']) ?>">
        <?php if(!empty($data['errors']['price'])): ?>
            <small class="error"><?= $data['errors']['price'] ?></small>
        <?php endif; ?>

        <label>Available Quantity: <span class="required">*</span></label>
        <input type="number" name="available" value="<?= htmlspecialchars($data['available']) ?>">
        <?php if(!empty($data['errors']['available'])): ?>
            <small class="error"><?= $data['errors']['available'] ?></small>
        <?php endif; ?>

        <label>Image: <span class="required">*</span></label>
        <input type="file" name="image" accept="image/*">
        <?php if(!empty($data['errors']['image'])): ?>
            <small class="error"><?= $data['errors']['image'] ?></small>
        <?php endif; ?>

        <div style="display:flex; gap:10px; margin-top:20px;">
            <button type="submit" style="flex:1; background:#2e7d32;">
                <i class="fa-solid fa-check"></i> Add Product
            </button>
            <button type="button" onclick="window.location.href='<?= URLROOT ?>/marketplace/manageproduct'" 
                    style="flex:1; background:#dc3545;">
                <i class="fa-solid fa-xmark"></i> Cancel
            </button>
        </div>

    </form>
</div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
