<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/FarmerProfile.css?v=<?= time(); ?>">

<main>

<!-- PADDY DETAILS -->
    <div class="page-title">
        <h2>Edit Paddy Details</h2>
    </div>


    <div class="profile-card">
        <div class="profile-info">
            <form id="paddyForm" method="POST" action="<?php echo URLROOT; ?>/officer/FarmerProfile/updatePLR">
                <input type="hidden" name="nic" value="<?= $data['paddy']->NIC_FK ?>">


                <div class="form-group">

                    <label for="PLR">PLR Number</label>
                    <input type="hidden" name="plr" value="<?= $data['paddy']->PLR ?>">
                    <input type="text" value="<?= $data['paddy']->PLR ?>" readonly>
                    <?php if(!empty($data['errors']['PLR'])): ?>
                        <small class="error" style="color:#d93025;"><?php echo $data['errors']['PLR']; ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="Paddy_Seed_Variety">Paddy Seed Variety</label>
                      <select id="Paddy_Seed_Variety" name="Paddy_Seed_Variety" required>

                            <option value="BG-250" <?= ($data['paddy']->Paddy_Seed_Variety=='BG-250')?'selected':'' ?>>BG-250 (2.5 months)</option>
                            <option value="BG-300" <?= ($data['paddy']->Paddy_Seed_Variety=='BG-300')?'selected':'' ?>>BG-300 (3.0 months)</option>
                            <option value="AT-307" <?= ($data['paddy']->Paddy_Seed_Variety=='AT-307')?'selected':'' ?>>AT-307 (3.0 months)</option>
                            <option value="AT-308" <?= ($data['paddy']->Paddy_Seed_Variety=='AT-308')?'selected':'' ?>>AT-308 (3.0 months)</option>
                            <option value="BG-352" <?= ($data['paddy']->Paddy_Seed_Variety=='BG-352')?'selected':'' ?>>BG-352 (3.5 months)</option>
                            <option value="BG-357" <?= ($data['paddy']->Paddy_Seed_Variety=='BG-357')?'selected':'' ?>>BG-357 (3.5 months)</option>
                            <option value="BG-359" <?= ($data['paddy']->Paddy_Seed_Variety=='BG-359')?'selected':'' ?>>BG-359 (3.5 months)</option>
                            <option value="BG-360" <?= ($data['paddy']->Paddy_Seed_Variety=='BG-360')?'selected':'' ?>>BG-360 (3.5 months)</option>
                            <option value="BW-367" <?= ($data['paddy']->Paddy_Seed_Variety=='BW-367')?'selected':'' ?>>BW-367 (3.5 months)</option>
                            <option value="BW-375" <?= ($data['paddy']->Paddy_Seed_Variety=='BW-375')?'selected':'' ?>>BW-375 (3.5 months)</option>
                            <option value="BG-403" <?= ($data['paddy']->Paddy_Seed_Variety=='BG-403')?'selected':'' ?>>BG-403 (4.0 months)</option>
                            <option value="BG-406" <?= ($data['paddy']->Paddy_Seed_Variety=='BG-406')?'selected':'' ?>>BG-406 (4.0 months)</option>
                            <option value="BG-405" <?= ($data['paddy']->Paddy_Seed_Variety=='BG-405')?'selected':'' ?>>BG-405 (4.5 months)</option>
                      </select>
                </div>

                <div class="form-group">
                    <label for="Paddy_Size">Paddy Size (in acres)</label>
                    <input type="text" name="Paddy_Size" id="Paddy_Size" value="<?= $data['paddy']->Paddy_Size ?>">
                </div>

                <input type="hidden" name="Province" value="<?= $data['paddy']->Province ?>">
                <input type="hidden" name="District" value="<?= $data['paddy']->District ?>">
                <input type="hidden" name="Govi_Jana_Sewa_Division" value="<?= $data['paddy']->Govi_Jana_Sewa_Division ?>">

                <div class="form-group">
                    <label for="Grama_Niladhari_Division">Grama Niladhari Division</label>
                    <input type="text" id="Grama_Niladhari_Division" name="Grama_Niladhari_Division" value="<?= $data['paddy']->Grama_Niladhari_Division ?>" required>
                </div>

                <div class="form-group">
                    <label for="Yaya">Yaya Name</label>
                    <input type="text" id="Yaya" name="Yaya" value="<?= $data['paddy']->Yaya ?>" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn save-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    </main>

    <script>
        //validate Paddy form

        //validate PLR

            document.getElementById('paddyForm').addEventListener('submit', function(e) {


                //  Validate Paddy Size (Option 3)
                const size = document.getElementById('Paddy_Size').value.trim();
                if (!size || isNaN(size) || size <= 0) {
                    e.preventDefault();
                    alert('Paddy size must be a number greater than 0.');
                    document.getElementById('Paddy_Size').focus();
                    return;
                }
            });


    </script>

    <?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>