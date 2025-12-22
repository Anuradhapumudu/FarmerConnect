<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/help/help.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">
    <section class="help-section">
        <div class="containers">
            <div class="section-title">
                <h1>Help Center</h1>
                <p>Get in touch with our dedicated agricultural support team for assistance</p>
            </div>

            <div class="team-section">
                <div class="section-title">
                    <h2>Our Support Team</h2>
                </div>
                <div class="team-grid">
                    <?php foreach($data['members'] as $member): ?>
                        <div class="team-member">
                            <img src="https://randomuser.me/api/portraits/men/5.jpg" alt="<?= $member->name ?>" class="member-img">
                            <div class="member-name"><?= $member->name ?></div>
                            <div class="member-role"><?= $member->type ?></div>
                            <div class="member-contact">
                                <p><i class="fas fa-phone"></i> <?= $member->phone ?></p>
                            </div>
                            <div class="officer-actions">
                                <a href="<?= URLROOT ?>/help/delete/<?= $member->id ?>/<?= $member->type ?>" class="btn btn-sm btn-danger">Remove</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="section-title">
                    <h2>Add New Support Member</h2>
                </div>

                <form action="<?= URLROOT ?>/help/add" method="POST" class="add-officer-form">
                    <div class="form-group">
                        <label for="id">Member ID</label>
                        <input type="text" class="form-control" name="id" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" name="type" required>
                            <option value="officer">Officer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="reset" class="btn btn-outline">Cancel</button>
                        <button type="submit" class="btn">Add Member</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
