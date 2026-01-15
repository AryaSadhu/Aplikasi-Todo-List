/**
 * Custom JavaScript untuk Todo List Application
 * Menambahkan interaktivitas dan validasi form
 */

// Fungsi yang dijalankan setelah DOM loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Auto-hide alert setelah 5 detik
    const alerts = document.querySelectorAll('.alert:not(.alert-info)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    
    // Konfirmasi sebelum delete
    const deleteLinks = document.querySelectorAll('a[href*="delete_task.php"]');
    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus tugas ini?')) {
                e.preventDefault();
            }
        });
    });
    
    // Form validation untuk semua form
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
    
    // Real-time search untuk tasks (jika ada)
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                // Auto submit form search setelah 1 detik tidak mengetik
                if (searchInput.value.length >= 3 || searchInput.value.length === 0) {
                    searchInput.closest('form').submit();
                }
            }, 1000);
        });
    }
    
    // Character counter untuk textarea
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(function(textarea) {
        const maxLength = textarea.getAttribute('maxlength');
        if (maxLength) {
            const counter = document.createElement('div');
            counter.className = 'form-text text-end';
            counter.innerHTML = `<span id="current">0</span>/${maxLength} karakter`;
            textarea.parentNode.insertBefore(counter, textarea.nextSibling);
            
            textarea.addEventListener('input', function() {
                const current = this.value.length;
                counter.querySelector('#current').textContent = current;
                
                if (current > maxLength * 0.9) {
                    counter.classList.add('text-warning');
                } else {
                    counter.classList.remove('text-warning');
                }
            });
        }
    });
    
    // Animasi untuk completed task
    const statusForms = document.querySelectorAll('form[action*="task_process.php"]');
    statusForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const card = this.closest('.card');
            if (card) {
                card.classList.add('border-success');
                setTimeout(function() {
                    card.style.transition = 'opacity 0.3s';
                    card.style.opacity = '0.7';
                }, 100);
            }
        });
    });
    
    // Tooltips initialization (jika menggunakan Bootstrap tooltips)
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Session timeout warning
    const sessionTimeout = 30 * 60 * 1000; // 30 menit
    const warningTime = 5 * 60 * 1000; // 5 menit sebelum timeout
    
    setTimeout(function() {
        showSessionWarning();
    }, sessionTimeout - warningTime);
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K untuk focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.focus();
            }
        }
        
        // Ctrl/Cmd + N untuk tambah tugas baru
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            const addButton = document.querySelector('a[href*="add_task.php"]');
            if (addButton) {
                window.location.href = addButton.href;
            }
        }
    });
});

/**
 * Fungsi untuk menampilkan warning session timeout
 */
function showSessionWarning() {
    const warningDiv = document.createElement('div');
    warningDiv.className = 'alert alert-warning alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
    warningDiv.style.zIndex = '9999';
    warningDiv.innerHTML = `
        <strong>Perhatian!</strong> Sesi Anda akan berakhir dalam 5 menit.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(warningDiv);
    
    setTimeout(function() {
        const bsAlert = new bootstrap.Alert(warningDiv);
        bsAlert.close();
    }, 10000);
}

/**
 * Fungsi untuk format tanggal
 * @param {string} dateString - Tanggal dalam format YYYY-MM-DD
 * @returns {string} - Tanggal terformat
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('id-ID', options);
}

/**
 * Fungsi untuk validasi email
 * @param {string} email - Email yang akan divalidasi
 * @returns {boolean}
 */
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

/**
 * Fungsi untuk validasi password strength
 * @param {string} password - Password yang akan divalidasi
 * @returns {object} - Object dengan strength dan message
 */
function checkPasswordStrength(password) {
    let strength = 0;
    let message = '';
    
    if (password.length >= 6) strength++;
    if (password.length >= 10) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[^a-zA-Z\d]/.test(password)) strength++;
    
    if (strength <= 2) {
        message = 'Lemah';
    } else if (strength <= 3) {
        message = 'Sedang';
    } else {
        message = 'Kuat';
    }
    
    return { strength, message };
}

/**
 * Fungsi untuk debounce
 * @param {function} func - Fungsi yang akan di-debounce
 * @param {number} wait - Waktu tunggu dalam ms
 * @returns {function}
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Fungsi untuk show loading spinner
 */
function showLoading() {
    const loadingDiv = document.createElement('div');
    loadingDiv.id = 'loading-spinner';
    loadingDiv.className = 'position-fixed top-50 start-50 translate-middle';
    loadingDiv.style.zIndex = '9999';
    loadingDiv.innerHTML = `
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    `;
    document.body.appendChild(loadingDiv);
}

/**
 * Fungsi untuk hide loading spinner
 */
function hideLoading() {
    const loadingDiv = document.getElementById('loading-spinner');
    if (loadingDiv) {
        loadingDiv.remove();
    }
}

/**
 * Fungsi untuk copy text ke clipboard
 * @param {string} text - Text yang akan dicopy
 */
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Text berhasil dicopy ke clipboard!');
    }).catch(function(err) {
        console.error('Gagal copy text: ', err);
    });
}

/**
 * Fungsi untuk konfirmasi action
 * @param {string} message - Pesan konfirmasi
 * @returns {boolean}
 */
function confirmAction(message) {
    return confirm(message || 'Apakah Anda yakin?');
}

// Export fungsi untuk digunakan di file lain
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        formatDate,
        validateEmail,
        checkPasswordStrength,
        debounce,
        showLoading,
        hideLoading,
        copyToClipboard,
        confirmAction
    };
}