<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/seller/deleteproduct.css">

<div class="container">
  <h2>Delete Product</h2>
  <p>Are you sure you want to delete <strong><?php echo htmlspecialchars($data->item_name); ?></strong>?</p>

  <form action="<?php echo URLROOT; ?>/seller/delete_product/<?php echo $data->item_id; ?>" method="POST">
    <input type="submit" value="Yes, Delete" class="btn btn-danger">
    <a href="<?php echo URLROOT; ?>/Marketplace/manageProducts" class="btn btn-secondary">Cancel</a>
  </form>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
