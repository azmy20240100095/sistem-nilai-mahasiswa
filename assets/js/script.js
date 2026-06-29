/**
 * Sistem Nilai Mahasiswa - Custom JavaScript
 * File: assets/js/script.js
 */

// DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Confirm delete with custom message
    const deleteLinks = document.querySelectorAll('a[href*="delete.php"]');
    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini? Data yang sudah dihapus tidak dapat dikembalikan.')) {
                e.preventDefault();
            }
        });
    });

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Search input auto-focus
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    }

    // Format number inputs
    const numberInputs = document.querySelectorAll('input[type="number"]');
    numberInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            // Remove leading zeros
            if (this.value.length > 1 && this.value[0] === '0' && this.value[1] !== '.') {
                this.value = this.value.replace(/^0+/, '');
            }
        });
    });

    // Nilai input validation and grade preview
    const nilaiInput = document.querySelector('input[name="nilai"]');
    if (nilaiInput) {
        // Create grade preview element
        const gradePreview = document.createElement('div');
        gradePreview.className = 'mt-2';
        gradePreview.innerHTML = '<strong>Grade Preview:</strong> <span id="grade-value" class="badge bg-secondary">-</span>';
        nilaiInput.parentElement.appendChild(gradePreview);

        nilaiInput.addEventListener('input', function() {
            const nilai = parseFloat(this.value);
            const gradeSpan = document.getElementById('grade-value');
            
            if (isNaN(nilai) || nilai < 0 || nilai > 100) {
                gradeSpan.textContent = '-';
                gradeSpan.className = 'badge bg-secondary';
                return;
            }

            let grade = '';
            let badgeClass = 'badge ';

            if (nilai >= 85) {
                grade = 'A';
                badgeClass += 'bg-success';
            } else if (nilai >= 80) {
                grade = 'A-';
                badgeClass += 'bg-success';
            } else if (nilai >= 75) {
                grade = 'B+';
                badgeClass += 'bg-info';
            } else if (nilai >= 70) {
                grade = 'B';
                badgeClass += 'bg-info';
            } else if (nilai >= 65) {
                grade = 'B-';
                badgeClass += 'bg-info';
            } else if (nilai >= 60) {
                grade = 'C+';
                badgeClass += 'bg-warning';
            } else if (nilai >= 55) {
                grade = 'C';
                badgeClass += 'bg-warning';
            } else if (nilai >= 40) {
                grade = 'D';
                badgeClass += 'bg-danger';
            } else {
                grade = 'E';
                badgeClass += 'bg-danger';
            }

            gradeSpan.textContent = grade;
            gradeSpan.className = badgeClass;
        });

        // Trigger on page load if value exists
        if (nilaiInput.value) {
            nilaiInput.dispatchEvent(new Event('input'));
        }
    }

    // Table row highlight on click
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(function(row) {
        row.addEventListener('click', function(e) {
            // Don't highlight if clicking a button
            if (e.target.tagName !== 'A' && e.target.tagName !== 'BUTTON') {
                this.classList.toggle('table-active');
            }
        });
    });

    // Smooth scroll to top
    const scrollBtn = document.createElement('button');
    scrollBtn.innerHTML = '<i class="bi bi-arrow-up"></i>';
    scrollBtn.className = 'btn btn-primary position-fixed bottom-0 end-0 m-3 rounded-circle';
    scrollBtn.style.width = '50px';
    scrollBtn.style.height = '50px';
    scrollBtn.style.display = 'none';
    scrollBtn.style.zIndex = '1000';
    scrollBtn.onclick = function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
    document.body.appendChild(scrollBtn);

    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollBtn.style.display = 'block';
        } else {
            scrollBtn.style.display = 'none';
        }
    });
});

// Utility Functions
function formatNumber(num, decimals = 2) {
    return parseFloat(num).toFixed(decimals);
}

function showLoading(button) {
    button.disabled = true;
    button.innerHTML = '<span class="loading"></span> Loading...';
}

function hideLoading(button, originalText) {
    button.disabled = false;
    button.innerHTML = originalText;
}

// Print function
function printTable() {
    window.print();
}

// Export to CSV (simple implementation)
function exportToCSV(tableId, filename) {
    const table = document.getElementById(tableId);
    if (!table) return;

    let csv = [];
    const rows = table.querySelectorAll('tr');

    rows.forEach(function(row) {
        const cols = row.querySelectorAll('td, th');
        let csvRow = [];
        cols.forEach(function(col) {
            csvRow.push('"' + col.innerText.replace(/"/g, '""') + '"');
        });
        csv.push(csvRow.join(','));
    });

    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', filename);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

console.log('Sistem Nilai Mahasiswa - Loaded Successfully');
