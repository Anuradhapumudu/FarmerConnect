<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/help/help.css?v=<?= time(); ?>">


<main class="main-content" id="mainContent">
    <section class="help-section">
        <div class="containers">
            <div class="section-title">
                <h1>Help Center</h1>
                <p>Get in touch with our dedicated agricultural support team for assistance</p>
            </div>

            <!-- Support Team Section -->
            <div class="team-section">
                <div class="section-title">
                    <h2>Our Support Team</h2>
                </div>



                
      <div class="team-grid">
      <?php foreach ($data['members'] as $member): ?>
        <?php
            $img = $member->image ?? '';
            if (empty($img)) {
                $imgUrl = 'https://cdn-icons-png.flaticon.com/512/847/847969.png';
            } elseif (strpos($img, 'http') === 0) {
                $imgUrl = $img;
            } else {
                $imgUrl = URLROOT . '/' . $img;
            }
        ?>

        <div class="team-member">
            <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($member->name) ?>" class="member-img">
            <div class="member-name"><?= htmlspecialchars($member->name) ?></div>
            <div class="member-role"><?= htmlspecialchars($member->type) ?></div>
            <div class="member-contact">
                <p><i class="fas fa-phone"></i> <?= htmlspecialchars($member->phone) ?></p>

                <div class="officer-actions">
                    <a href="<?= URLROOT ?>/help/delete/<?= $member->id ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Remove this member from Help Center?')">
                       Remove
                    </a>
                </div>
            </div>
          </div>
           <?php endforeach; ?>
            </div>


                <!-- Add New Support Member Section -->
                <div class="section-title">
                    <h2>Add New Support Member</h2>
                </div>

                <form action="<?= URLROOT ?>/help/add" method="POST" class="add-officer-form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="id">Member ID</label>
                        <!--Error checking-->
                                        <?php if (!empty($data['form_errors']['add_member'])): ?>
                    <div class="alert alert-danger" id="memberError" >                        
                            <?php foreach ($data['form_errors']['add_member'] as $error): ?>
                                    <p style="color: red;">
                                      <?= htmlspecialchars($error) ?>  </p>
                            <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                        <input type="text" class="form-control" name="id" value="<?= htmlspecialchars($data['form_data']['id'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" name="type" required>
                            <option value="Officer" <?= isset($data['form_data']['type']) && $data['form_data']['type'] === 'Officer' ? 'selected' : '' ?>>Officer</option>
                            <option value="Admin" <?= isset($data['form_data']['type']) && $data['form_data']['type'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" onclick="resetMemberForm()">Cancel</button>
                        <button type="submit" class="btn">Add Member</button>
                    </div>
                </form>
            </div>

            <!-- Emergency Contact Section -->
            <div class="emergency-contact">
                <h3>Emergency Contact</h3>

                <?php if (!empty($data['form_errors']['emergency'])): ?>
                    <div class="alert alert-danger" id="emergencyError">
                        <?php foreach ($data['form_errors']['emergency'] as $error): ?>
                            <p style="color: red;">
                                <?= htmlspecialchars($error) ?>
                            </p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>



                <!-- Display Mode -->
                <div id="emergencyDisplay" style="display: <?= !empty($data['form_errors']['emergency']) ? 'none' : 'block' ?>;">
                    <div class="emergency-number">
                        <?= htmlspecialchars($data['emergencyNumber']->phone ?? 'Not set') ?>
                    </div>

                    <p class="emergency-text">
                        Available 24/7 for urgent agricultural issues requiring immediate assistance
                    </p>

                    <div class="officer-actions">
                        <button class="btn btn-sm btn-outline" onclick="enableEmergencyEdit()">Edit</button>
                    </div>
                </div>

                <!-- Edit Mode -->
                <form id="emergencyEdit"
                      action="<?= URLROOT ?>/help/updateEmergency"
                      method="POST"
                      style="display: <?= !empty($data['form_errors']['emergency']) ? 'block' : 'none' ?>;">

                <input type="text"
                    name="phone"
                    class="form-control emergency-input"
                    value="<?= htmlspecialchars($data['form_data']['emergency_phone'] ?? ($data['emergencyNumber']->phone ?? '')) ?>"
                    placeholder="10 digits only (no spaces)"
                    required>

                    <div class="officer-actions">
                        <button type="submit" class="btn btn-sm btn-outline">Save</button>
                        <button type="button" class="btn btn-sm btn-danger"
                                onclick="cancelEmergencyEdit()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<script src="<?php echo URLROOT; ?>/js/help.js?v=<?= time(); ?>"></script>


<?php require_once APPROOT . '/views/inc/footer.php'; ?>