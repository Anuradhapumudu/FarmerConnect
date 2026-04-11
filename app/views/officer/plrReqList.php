<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/officerYellowCase.css?v=<?= time(); ?>">

<main class="main-content">
<div class="containers">

    <div class="officer-header">
        <h1>PLR Registration Requests</h1>
        <p>Approve or reject farmer paddy registration requests</p>
    </div>

    <!-- ===================== PENDING TABLE ===================== -->
    <div class="farmer-table-wrapper">
        <div class="farmer-table-header">Pending Requests</div>

        <table>
            <thead>
                <tr>
                    <th>PLR</th>
                    <th>NIC</th>
                    <th>Name</th>
                    <th>Seed</th>
                    <th>Size</th>
                    <th>Requested Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($data['pending'])): ?>
                    <?php foreach ($data['pending'] as $req): ?>
                    <tr>
                        <td><?php echo $req->PLR; ?></td>
                        <td><?php echo $req->NIC_FK; ?></td>
                        <td><?php echo $req->full_name; ?></td>
                        <td><?php echo $req->Paddy_Seed_Variety; ?></td>
                        <td><?php echo $req->Paddy_Size; ?></td>
                        <td><?php echo date('d M Y', strtotime($req->created_at)); ?></td>

                        <td>
                            <span class="status pending">Pending</span>
                        </td>

                        <td>
                            <a href="<?php echo URLROOT; ?>/officer/plrReqList/show/<?php echo $req->id; ?>" class="btn view">
                                View Request
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No Pending Requests</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>


    <!-- ===================== HISTORY TABLE ===================== -->
    <div class="farmer-table-wrapper" style="margin-top:30px;">
        <div class="farmer-table-header">Request History</div>

        <table>
            <thead>
                <tr>
                    <th>PLR</th>
                    <th>NIC</th>
                    <th>Name</th>
                    <th>Seed</th>
                    <th>Size</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($data['history'])): ?>
                    <?php foreach ($data['history'] as $req): ?>
                    <tr>
                        <td><?php echo $req->PLR; ?></td>
                        <td><?php echo $req->NIC_FK; ?></td>
                        <td><?php echo $req->full_name; ?></td>
                        <td><?php echo $req->Paddy_Seed_Variety; ?></td>
                        <td><?php echo $req->Paddy_Size; ?></td>
                        <td><?php echo date('d M Y', strtotime($req->created_at)); ?></td>

                        <td>
                            <span class="status <?php echo $req->status; ?>">
                                <?php echo ucfirst($req->status); ?>
                            </span>
                        </td>

                        <td>
                            <!-- 🔁 Toggle buttons -->
                            <?php if ($req->status == 'approved'): ?>
                                <a href="<?php echo URLROOT; ?>/officer/plrReqList/reject/<?php echo $req->id; ?>" class="btn reject">
                                    Reject
                                </a>
                            <?php else: ?>
                                <a href="<?php echo URLROOT; ?>/officer/plrReqList/approve/<?php echo $req->id; ?>" class="btn approve">
                                    Approve
                                </a>
                            <?php endif; ?>

                            <a href="<?php echo URLROOT; ?>/officer/plrReqList/show/<?php echo $req->id; ?>" class="btn view">
                                View
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No History Found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>