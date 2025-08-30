<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/seller/manageproduct.css">

<main class="main-content" id="mainContent">

  <div class="my_product">
    <div class="heading">Manage Products</div>

    <div class="add_products">
      <a href="<?php echo URLROOT; ?>/addProduct" class="btn btn-add"><i class="fa fa-plus"></i> Add New Product</a>
    </div>

    <h2 style="text-align:center; margin-bottom:20px;">Your Products</h2>

    <div class="product_box">
    <?php foreach($data['products'] as $product): ?>
  <div class="product-container">
    <img src="<?php echo URLROOT . '/uploads/' . $product->image_url; ?>" alt="Product">
    <div class="product-details">
      <span class="in-stock">In Stock</span>
      <h2><?php echo htmlspecialchars($product->item_name); ?></h2>
      <div><span class="price">Rs <?php echo htmlspecialchars($product->price_per_unit); ?></span></div>
      <p class="description"><?php echo htmlspecialchars($product->description); ?></p>
      <div class="badges">
        <span class="stock">Stock: <?php echo htmlspecialchars($product->available_quantity); ?></span>
        <span class="region">Region: <?php echo htmlspecialchars($product->region); ?></span>
      </div>
      <hr class="divider">
      <div class="actions">
        <a href="<?php echo URLROOT; ?>/editProduct/<?php echo $product->item_id; ?>" class="btn btn-edit">
          <i class="fas fa-edit"></i> Edit
        </a>
        <a href="<?php echo URLROOT; ?>/seller/delete_product/<?php echo $product->item_id; ?>" class="btn btn-delete">
          <i class="fas fa-trash"></i> Delete
        </a>
      </div>
    </div>
  </div>
<?php endforeach; ?>

    </div>
  </div>
</div></main>





<?php require_once APPROOT . '/views/inc/footer.php'; ?>
