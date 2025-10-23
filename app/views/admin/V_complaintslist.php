<?php require APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/list.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

  <div class="containers">
    <div class="admin-header">
      <h1>Complaints Management</h1>
      <p>View and manage all submitted complaints</p>
    </div>

    <!-- Stats cards -->
    <div class="stats">
      <div class="card"><h2 id="totalCount">0</h2><p>Total Complaints</p></div>
      <div class="card"><h2 id="pendingCount">0</h2><p>Pending</p></div>
      <div class="card"><h2 id="resolvedCount">0</h2><p>Resolved</p></div>
      <div class="card"><h2 id="urgentCount">0</h2><p>Urgent</p></div>
    </div>

    <!-- Search + Filter -->
    <div class="search-box">
      <div style="position: relative; flex: 1;">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="search-input" placeholder="Search complaints by subject or complainant...">
      </div>
      <select class="filter-select">
        <option value="all">All Status</option>
        <option value="pending">Pending</option>
        <option value="under_review">Under Review</option>
        <option value="resolved">Resolved</option>
        <option value="rejected">Rejected</option>
      </select>
    </div>

    <!-- Complaints Table -->
    <div class="data-table">
      <div class="table-header">All Complaints</div>
      <table>
        <thead>
          <tr>
            <th>Complain Code</th>
            <th>Subject</th>
            <th>Complainant</th>
            <th>Category</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="complaintsTable">
          <tr>
            <td>CMP-2024-001</td>
            <td>Service Quality Issue</td>
            <td>John Doe<br><small>john@example.com</small></td>
            <td>Service Quality</td>
            <td><span class="priority-badge priority-medium">Medium</span></td>
            <td><span class="status-badge status-pending">Pending</span></td>
            <td>2024-10-15</td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</button>
              <button class="action-btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
            </td>
          </tr>
          <tr>
            <td>CMP-2024-002</td>
            <td>Payment Processing Delay</td>
            <td>Jane Smith<br><small>jane@example.com</small></td>
            <td>Payment Issue</td>
            <td><span class="priority-badge priority-high">High</span></td>
            <td><span class="status-badge status-under_review">Under Review</span></td>
            <td>2024-10-14</td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</button>
              <button class="action-btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
            </td>
          </tr>
          <tr>
            <td>CMP-2024-003</td>
            <td>Technical Support Unresponsive</td>
            <td>Bob Johnson<br><small>bob@example.com</small></td>
            <td>Technical Support</td>
            <td><span class="priority-badge priority-urgent">Urgent</span></td>
            <td><span class="status-badge status-pending">Pending</span></td>
            <td>2024-10-13</td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</button>
              <button class="action-btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
            </td>
          </tr>
          <tr>
            <td>CMP-2024-004</td>
            <td>Product Quality Concern</td>
            <td>Alice Brown<br><small>alice@example.com</small></td>
            <td>Product Issue</td>
            <td><span class="priority-badge priority-low">Low</span></td>
            <td><span class="status-badge status-resolved">Resolved</span></td>
            <td>2024-10-12</td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</button>
              <button class="action-btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
            </td>
          </tr>
          <tr>
            <td>CMP-2024-005</td>
            <td>Staff Behavior Complaint</td>
            <td>Charlie Wilson<br><small>charlie@example.com</small></td>
            <td>Staff Behavior</td>
            <td><span class="priority-badge priority-medium">Medium</span></td>
            <td><span class="status-badge status-rejected">Rejected</span></td>
            <td>2024-10-11</td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</button>
              <button class="action-btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
      <button class="page-btn active">1</button>
      <button class="page-btn">2</button>
      <button class="page-btn">3</button>
      <button class="page-btn">Next</button>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal" id="deleteModal">
    <div class="modal-content">
      <h3>Confirm Delete</h3>
      <p>Are you sure you want to delete this complaint?</p>
      <div class="modal-actions">
        <button class="cancel-btn">Cancel</button>
        <button class="confirm-btn">Yes, Delete</button>
      </div>
    </div>
  </div>

</main>

<style>
.priority-badge {
  display: inline-block;
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
}

.priority-low {
  background: rgba(76, 175, 80, 0.2);
  color: #2e7d32;
}

.priority-medium {
  background: rgba(255, 193, 7, 0.2);
  color: #f57c00;
}

.priority-high {
  background: rgba(244, 67, 54, 0.2);
  color: #c62828;
}

.priority-urgent {
  background: rgba(156, 39, 176, 0.2);
  color: #7b1fa2;
}

.status-badge {
  display: inline-block;
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
}

.status-pending {
  background: rgba(255, 193, 7, 0.2);
  color: #f57c00;
}

.status-under_review {
  background: rgba(33, 150, 243, 0.2);
  color: #1976d2;
}

.status-resolved {
  background: rgba(76, 175, 80, 0.2);
  color: #2e7d32;
}

.status-rejected {
  background: rgba(244, 67, 54, 0.2);
  color: #c62828;
}

.action-btn {
  padding: 6px 10px;
  margin: 2px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 0.8rem;
  transition: all 0.3s ease;
}

.view-btn {
  background: #17a2b8;
  color: white;
}

.view-btn:hover {
  background: #138496;
}

.edit-btn {
  background: #ffc107;
  color: #212529;
}

.edit-btn:hover {
  background: #e0a800;
}

.delete-btn {
  background: #dc3545;
  color: white;
}

.delete-btn:hover {
  background: #c82333;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Update stats
  const rows = document.querySelectorAll('#complaintsTable tr');
  let total = rows.length;
  let pending = 0;
  let resolved = 0;
  let urgent = 0;

  rows.forEach(row => {
    const status = row.cells[5].textContent.toLowerCase();
    const priority = row.cells[4].textContent.toLowerCase();

    if (status.includes('pending')) pending++;
    if (status.includes('resolved')) resolved++;
    if (priority.includes('urgent')) urgent++;
  });

  document.getElementById('totalCount').textContent = total;
  document.getElementById('pendingCount').textContent = pending;
  document.getElementById('resolvedCount').textContent = resolved;
  document.getElementById('urgentCount').textContent = urgent;

  // Search functionality
  const searchInput = document.querySelector('.search-input');
  const filterSelect = document.querySelector('.filter-select');

  function filterTable() {
    const searchTerm = searchInput.value.toLowerCase();
    const filterValue = filterSelect.value.toLowerCase();

    rows.forEach(row => {
      const subject = row.cells[1].textContent.toLowerCase();
      const complainant = row.cells[2].textContent.toLowerCase();
      const status = row.cells[5].textContent.toLowerCase();

      const matchesSearch = subject.includes(searchTerm) || complainant.includes(searchTerm);
      const matchesFilter = filterValue === 'all' || status.includes(filterValue);

      row.style.display = matchesSearch && matchesFilter ? '' : 'none';
    });
  }

  searchInput.addEventListener('input', filterTable);
  filterSelect.addEventListener('change', filterTable);

  // Modal functionality
  const deleteModal = document.getElementById('deleteModal');
  const deleteBtns = document.querySelectorAll('.delete-btn');

  deleteBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      deleteModal.style.display = 'block';
    });
  });

  document.querySelector('.cancel-btn').addEventListener('click', function() {
    deleteModal.style.display = 'none';
  });

  document.querySelector('.confirm-btn').addEventListener('click', function() {
    // In a real app, this would send a delete request
    alert('Complaint deleted successfully!');
    deleteModal.style.display = 'none';
  });

  // Close modal when clicking outside
  window.addEventListener('click', function(event) {
    if (event.target === deleteModal) {
      deleteModal.style.display = 'none';
    }
  });
});
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>