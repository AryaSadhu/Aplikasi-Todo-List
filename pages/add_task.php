<?php
/**
 * Halaman untuk menambah tugas baru
 */

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';

// Pastikan user sudah login
requireLogin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas - Todo List App</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">
                <i class="fas fa-tasks me-2"></i>
                Todo List App
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white">
                            <i class="fas fa-user me-1"></i>
                            <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i>
                            Tambah Tugas Baru
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Flash Message -->
                        <?php echo displayFlashMessage(); ?>

                        <form id="addTaskForm" action="../api/task_process.php" method="POST">
                            <input type="hidden" name="action" value="add">
                            
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    <i class="fas fa-heading me-1"></i>
                                    Judul Tugas <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="title" name="title" 
                                       placeholder="Masukkan judul tugas" required maxlength="255">
                                <div class="form-text">Maksimal 255 karakter</div>
                            </div>
                            
                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    <i class="fas fa-align-left me-1"></i>
                                    Deskripsi
                                </label>
                                <textarea class="form-control" id="description" name="description" 
                                          rows="5" placeholder="Masukkan deskripsi tugas (opsional)"></textarea>
                                <div class="form-text">Jelaskan detail tugas Anda</div>
                            </div>
                            
                            <!-- Due Date -->
                            <div class="mb-4">
                                <label for="due_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    Tanggal Jatuh Tempo <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="due_date" name="due_date" 
                                       min="<?php echo date('Y-m-d'); ?>" required>
                                <div class="form-text">Pilih tanggal deadline tugas</div>
                            </div>
                            
                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    Simpan Tugas
                                </button>
                                <a href="dashboard.php" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../assets/js/script.js"></script>
    <script>
        // Set minimum date to today
        document.getElementById('due_date').setAttribute('min', new Date().toISOString().split('T')[0]);
        
        // Form validation
        document.getElementById('addTaskForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const dueDate = document.getElementById('due_date').value;
            
            if (!title) {
                e.preventDefault();
                alert('Judul tugas harus diisi!');
                return false;
            }
            
            if (!dueDate) {
                e.preventDefault();
                alert('Tanggal jatuh tempo harus diisi!');
                return false;
            }
        });
    </script>
</body>
</html>