<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/deleteproduct.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

<div class="containers">
  <h2 style="color:#d32f2f;"><i class="fas fa-trash"></i> Confirm Delete Product</h2>

  <img src="<?= URLROOT ?>/uploads/<?= htmlspecialchars($data->image_url) ?>" alt="Product Image">

  <p><b>Product Name:</b> <?= htmlspecialchars($data->item_name) ?></p>
  <p><b>Price per Unit:</b> Rs. <?= number_format($data->price_per_unit,2) ?></p>
  <p><b>Available Quantity:</b> <?= $data->available_quantity ?></p>

  <form action="<?php echo URLROOT; ?>/Marketplace/DeleteProduct/delete_product/<?= $data->item_id ?>" 
        method="POST" class="button-container">

    <input type="submit" value="Yes, Delete" class="btn btn-danger">
    <a href="<?php echo URLROOT; ?>/Marketplace/ManageProduct" class="btn btn-secondary">Cancel</a>
  </form>

  <p class="note" style="color:#b71c1c;">⚠️ Deleting this product is permanent and cannot be undone.</p>
</div>

</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>
