<?php require APPROOT . '/views/inc/sellerheader.php'; ?>
<link rel="stylesheet" href="<?= URLROOT; ?>/css/marketplace/deleteproduct.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">
  <div class="containers">
    <h2>
      <i class="fas fa-trash"></i> Confirm Delete Product
    </h2>

    <img src="<?= URLROOT ?>/uploads/<?= htmlspecialchars($data->image_url ?? '') ?>" alt="Product Image">

    <div class="product-details">
      <p><b>Product Name:</b> <span><?= htmlspecialchars($data->item_name ?? '') ?></span></p>
      <p><b>Price per Unit:</b> <span>Rs. <?= number_format($data->price_per_unit ?? 0, 2) ?></span></p>
      <p><b>Available Quantity:</b> <span><?= $data->available_quantity ?? 0 ?></span></p>
      <p><b>District:</b> <span><?= htmlspecialchars($data->region ?? '') ?></span></p>
      <p><b>Province:</b> <span><?= htmlspecialchars($data->province ?? '') ?></span></p>
      <p><b>Product Type:</b> <span><?= htmlspecialchars($data->category ?? '') ?></span></p>
      <p><b>Unit Type:</b> <span><?= htmlspecialchars($data->unit_type ?? '') ?></span></p>
    </div>

    <form action="<?= URLROOT; ?>/Marketplace/deleteProduct/<?= $data->item_id ?>" 
          method="POST" class="button-container">
      <button type="submit" class="btn-danger">
        <i class="fas fa-trash"></i> Yes, Delete
      </button>
      <a href="<?= URLROOT; ?>/Marketplace/manageProduct" class="btn-secondary">
        <i class="fas fa-times"></i> Cancel
      </a>
    </form>

    <p class="note">
      Deleting this product is permanent and cannot be undone.
    </p>
  </div>
</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>