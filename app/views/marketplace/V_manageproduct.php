<?php require_once APPROOT . '/views/inc/sellerheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/seller/manageproduct.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

  <div class="my_product">
    <div class="heading">Manage Products</div>

    <div class="add_products">
      <a href="<?php echo URLROOT; ?>/Marketplace/addProduct" class="btn btn-add">
        <i class="fa fa-plus"></i> Add New Product
      </a>
    </div>

    <div class="product_box">
      <?php foreach($data['products'] as $product): ?>
        <div class="product-container">
          <img src="<?php echo URLROOT . '/uploads/' . $product->image_url; ?>" alt="Product">

<div class="product-details">
  <?php 
      $statusClass = '';
      if ($product->status === 'Instock') $statusClass = 'status-instock';
      elseif ($product->status === 'Outstock') $statusClass = 'status-outstock';
  ?>
  <span class="status <?php echo $statusClass; ?>">
    <?php echo htmlspecialchars($product->status); ?>
  </span>

  <h2><?php echo htmlspecialchars($product->item_name); ?></h2>
  <div>
    <span class="price">Rs <?php echo htmlspecialchars($product->price_per_unit); ?></span>
  </div>
  <p class="description"><?php echo htmlspecialchars($product->description); ?></p>

  <div class="badges">
    <span class="region">District: <?php echo htmlspecialchars($product->region); ?></span>
    <span class="province">Province: <?php echo htmlspecialchars($product->province); ?></span>
  </div>

  <div class="info">
    <span class="stock">Available: <?php echo htmlspecialchars($product->available_quantity); ?></span>
    <span class="category">Category: <?php echo htmlspecialchars($product->category); ?></span>
    <span class="unit-type">Unit Type: <?php echo htmlspecialchars($product->unit_type); ?></span>
  </div>

  <hr class="divider">

  <div class="actions">
    <a href="<?php echo URLROOT; ?>/Marketplace/editProduct/<?=$product->item_id; ?>" class="btn btn-edit">
      <i class="fas fa-edit"></i> Edit
    </a>
    <a href="<?php echo URLROOT; ?>/Marketplace/deleteProduct/<?=$product->item_id; ?>" class="btn btn-delete">
      <i class="fas fa-trash"></i> Delete
    </a>
  </div>
</div>

        </div>
      <?php endforeach; ?>
    </div>
  </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
