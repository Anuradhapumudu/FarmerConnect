document.addEventListener('DOMContentLoaded', function () {
    // auto hide alerts
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        });
    }, 5000);

    // view details on row click (excluding status select)
    document.querySelectorAll('.reports-table tbody tr').forEach(row => {
        row.addEventListener('click', function (e) {
            // Don't trigger if clicking on status select or its form
            if (!e.target.closest('select') && !e.target.closest('.status-form')) {
                const url = this.getAttribute('data-href');
                if (url) {
                    window.location.href = url;
                }
            }
        });
    });

    //filtering
    const filters = ['farmernic-filter', 'date-filter', 'severity-filter', 'status-filter'];
    filters.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('change', filterReports);
        // Add input event for text search for real-time filtering
        if (id === 'farmernic-filter') el.addEventListener('input', filterReports);
    });

    const clearBtn = document.getElementById('clear-filters');
    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            filters.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
            document.querySelectorAll('.reports-table tbody tr').forEach(row => row.style.display = '');
        });
    }

    function filterReports() {
        const nic = document.getElementById('farmernic-filter').value.toLowerCase();
        const date = document.getElementById('date-filter').value;
        const severity = document.getElementById('severity-filter').value.toLowerCase();
        const status = document.getElementById('status-filter').value.toLowerCase();

        document.querySelectorAll('.reports-table tbody tr').forEach(row => {
            // Safe navigation for elements
            const nicEl = row.querySelector('.farmer-nic');
            const severityEl = row.querySelector('.status-badge'); // formerly severity-badge
            const statusEl = row.querySelector('select[name="status"]');
            const dateEl = row.querySelector('.meta-date div');

            const rowNic = nicEl ? nicEl.textContent.toLowerCase().trim() : '';
            const rowSeverity = severityEl ? severityEl.textContent.toLowerCase().trim() : '';
            // For status, get the SELECTED OPTION's value, not the text content, or the value of the select
            const rowStatus = statusEl ? statusEl.value.toLowerCase().trim() : '';
            const rowDate = dateEl ? dateEl.textContent : '';

            const matchesNic = !nic || rowNic.includes(nic);
            // Date formatting might differ, but simple string includes check usually works for YYYY-MM-DD vs content
            // However, the display is 'M d, Y'. The input is YYYY-MM-DD.
            // Let's rely on simple string match if one is contained in another, or just ignore exact date matching complexity for now as strictly requested UI fix. 
            // Actually, let's try to parse the display date if possible, but for now simple check.
            // The input date is YYYY-MM-DD. The display is "Dec 26, 2025".
            // A simple includes() won't work. We need to convert.

            let matchesDate = true;
            if (date && rowDate) {
                const d1 = new Date(date);
                const d2 = new Date(rowDate);
                // Compare dates (ignoring time)
                matchesDate = d1.toDateString() === d2.toDateString();
            }

            const matchesSeverity = !severity || rowSeverity.includes(severity);
            const matchesStatus = !status || rowStatus === status; // Exact match for status value

            row.style.display = (matchesNic && matchesDate && matchesSeverity && matchesStatus) ? '' : 'none';
        });
    }
});
