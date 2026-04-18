<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/adminvieworderdetail.css?v=<?= time(); ?>"></div></div></div>
<div class="container">

    <div class="page-header">
        <h2>Order Details #<?= $data['order']->order_id ?></h2>
    </div>

    <div class="order-detail-grid">

        <!-- ORDER INFO -->
        <div class="order-section">
            <h3> Order Information</h3>

            <div class="info-row">
                <span class="label">Created:</span>
                <span class="value"><?= date('M j, Y', strtotime($data['order']->order_create_date)) ?></span>
            </div>

            <div class="info-row">
                <span class="label">Status:</span>
                <span class="value">
                    <?= ucwords(str_replace('_',' ',$data['order']->order_status)) ?>
                </span>
            </div>

            <div class="info-row">
                <span class="label">Latest Update:</span>
                <span class="value">
                    <?= date('M j, Y - h:i A', strtotime($data['order']->latest_change)) ?>
                </span>
            </div>

            <div class="info-row">
                <span class="label">Quantity:</span>
                <span class="value"><?= $data['order']->quantity ?></span>
            </div>

            <div class="info-row">
                <span class="label">Category:</span>
                <span class="value"><?= $data['order']->category ?></span>
            </div>

            <div class="info-row">
                <span class="label">Total:</span>
                <span class="value">LKR <?= number_format($data['order']->total_price,2) ?></span>
            </div>

            <div class="info-row">
                <span class="label">Payment:</span>
                <span class="value"><?= $data['order']->payment_method ?></span>
            </div>
        </div>

        <!-- SELLER -->
        <div class="order-section">
            <h3> Seller</h3>

            <div class="info-row">
                <span class="label">ID:</span>
                <span class="value"><?= $data['order']->seller_id ?></span>
            </div>

            <div class="info-row">
                <span class="label">Name:</span>
                <span class="value"><?= $data['order']->seller_first . ' ' . $data['order']->seller_last ?></span>
            </div>

            <div class="info-row">
                <span class="label">Phone:</span>
                <span class="value"><?= $data['order']->seller_telNo ?></span>
            </div>

            <div class="info-row">
                <span class="label">Address:</span>
                <span class="value"><?= $data['order']->seller_address ?></span>
            </div>
        </div>
</div>

<div class="order-detail-grid1">
        <!-- CUSTOMER -->
        <div class="order-section full-width">
            <h3> Customer</h3>

            <div class="info-row">
                <span class="label">NIC:</span>
                <span class="value"><?= $data['order']->farmer_nic ?></span>
            </div>

            <div class="info-row">
                <span class="label">Name:</span>
                <span class="value"><?= $data['order']->farmer_full ?></span>
            </div>

            <div class="info-row">
                <span class="label">Phone:</span>
                <span class="value"><?= $data['order']->farmer_telNo ?></span>
            </div>
        </div>

    </div>

    <div class="btn-wrapper">
        <a href="<?php echo URLROOT; ?>/marketplace/adminViewOrders" class="btn">Back</a>
    </div>

</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>