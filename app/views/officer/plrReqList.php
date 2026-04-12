<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/plrReqList.css?v=<?= time(); ?>">

<main class="main-content">
<div class="containers">

    <div class="officer-header">
        <h1>PLR Registration Requests</h1>
        <p>Approve or reject farmer paddy registration requests</p>
    </div>

    <div class="search-box">
    <div style="position: relative; flex: 1;">
        
    <form method="GET" action="<?php echo URLROOT; ?>/officer/plrReqList">
        <div class="search-box">

            <div style="position: relative; flex: 1;">
                <i class="fas fa-search search-icon"></i>

                <input 
                    type="text" 
                    name="search"
                    value="<?php echo $_GET['search'] ?? ''; ?>"
                    class="search-input" 
                    placeholder="Search by PLR or NIC..."
                >
            </div>

            <!-- ✅ Search Button -->
            <button type="submit" class="search-btn">
                Search
            </button>

        </div>
    </form>
    </div>
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

        </table>

<!-- ✅ MOBILE CARDS (Pending) -->
<div class="farmer-cards">
<?php if (!empty($data['pending'])): ?>
    <?php foreach ($data['pending'] as $req): ?>
        <div class="farmer-card">
            <div class="farmer-card-header">
                <h4><?php echo $req->PLR; ?></h4>
                <span class="status pending">Pending</span>
            </div>

            <div class="farmer-card-body">
                <p><strong>NIC:</strong> <?php echo $req->NIC_FK; ?></p>
                <p><strong>Name:</strong> <?php echo $req->full_name; ?></p>
                <p><strong>Seed:</strong> <?php echo $req->Paddy_Seed_Variety; ?></p>
                <p><strong>Size:</strong> <?php echo $req->Paddy_Size; ?></p>
                <p><strong>Date:</strong> <?php echo date('d M Y', strtotime($req->created_at)); ?></p>
            </div>

            <div class="farmer-card-actions">
                <a href="<?php echo URLROOT; ?>/officer/plrReqList/show/<?php echo $req->id; ?>" class="btn view">
                    View Request
                </a>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>

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


                            <a href="<?php echo URLROOT; ?>/officer/plrReqList/show/<?php echo $req->id; ?>" class="btn view">
                                View Request
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

</table>

        <!-- ✅ MOBILE CARDS (Pending) -->
        <div class="farmer-cards">
        <?php if (!empty($data['history'])): ?>
            <?php foreach ($data['history'] as $req): ?>
                <div class="farmer-card">
                    <div class="farmer-card-header">
                        <h4><?php echo $req->PLR; ?></h4>
                                    <span class="status <?php echo $req->status; ?>">
                                        <?php echo ucfirst($req->status); ?>
                                    </span>
                    </div>

                    <div class="farmer-card-body">
                        <p><strong>NIC:</strong> <?php echo $req->NIC_FK; ?></p>
                        <p><strong>Name:</strong> <?php echo $req->full_name; ?></p>
                        <p><strong>Seed:</strong> <?php echo $req->Paddy_Seed_Variety; ?></p>
                        <p><strong>Size:</strong> <?php echo $req->Paddy_Size; ?></p>
                        <p><strong>Date:</strong> <?php echo date('d M Y', strtotime($req->created_at)); ?></p>
                    </div>

                    <div class="farmer-card-actions">
                        <a href="<?php echo URLROOT; ?>/officer/plrReqList/show/<?php echo $req->id; ?>" class="btn view">
                            View Request
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>

        </div> 


</div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>