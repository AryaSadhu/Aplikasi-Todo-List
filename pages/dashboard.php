<?php
/**
 * Halaman dashboard - menampilkan daftar tugas user
 */

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

// Pastikan user sudah login
requireLogin();

// Ambil parameter filter dan search
$filter = $_GET['filter'] ?? 'all';
$search = $_GET['search'] ?? '';

// Query untuk mengambil tasks
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tasks WHERE user_id = ?";
$params = [$user_id];
$types = "i";

// Filter berdasarkan status
if ($filter === 'completed') {
    $query .= " AND status = 'completed'";
} elseif ($filter === 'pending') {
    $query .= " AND status = 'pending'";
}

// Search berdasarkan title atau description
if (!empty($search)) {
    $query .= " AND (title LIKE ? OR description LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ss";
}

// Order by due_date
$query .= " ORDER BY due_date ASC, created_at DESC";

// Execute query
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Hitung statistik
$total_tasks = count($tasks);
$completed_tasks = count(array_filter($tasks, function($task) {
    return $task['status'] === 'completed';
}));
$pending_tasks = $total_tasks - $completed_tasks;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Todo List App</title>
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
        <!-- Flash Message -->
        <?php echo displayFlashMessage(); ?>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-list me-2"></i>Total Tugas
                        </h5>
                        <h2 class="mb-0"><?php echo $total_tasks; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-clock me-2"></i>Belum Selesai
                        </h5>
                        <h2 class="mb-0"><?php echo $pending_tasks; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-check-circle me-2"></i>Selesai
                        </h5>
                        <h2 class="mb-0"><?php echo $completed_tasks; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <form action="dashboard.php" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" 
                                   placeholder="Cari tugas..." value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="btn-group" role="group">
                            <a href="dashboard.php?filter=all" 
                               class="btn btn-outline-primary <?php echo $filter === 'all' ? 'active' : ''; ?>">
                                Semua
                            </a>
                            <a href="dashboard.php?filter=pending" 
                               class="btn btn-outline-warning <?php echo $filter === 'pending' ? 'active' : ''; ?>">
                                Belum Selesai
                            </a>
                            <a href="dashboard.php?filter=completed" 
                               class="btn btn-outline-success <?php echo $filter === 'completed' ? 'active' : ''; ?>">
                                Selesai
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Task Button -->
        <div class="mb-3">
            <a href="add_task.php" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Tugas Baru
            </a>
        </div>

        <!-- Tasks List -->
        <?php if (empty($tasks)): ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>
                <?php if (!empty($search)): ?>
                    Tidak ada tugas yang ditemukan untuk pencarian "<?php echo htmlspecialchars($search); ?>".
                <?php else: ?>
                    Belum ada tugas. Mulai tambahkan tugas pertama Anda!
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($tasks as $task): ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 shadow-sm <?php echo $task['status'] === 'completed' ? 'border-success' : ''; ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0 <?php echo $task['status'] === 'completed' ? 'text-decoration-line-through text-muted' : ''; ?>">
                                        <?php echo htmlspecialchars($task['title']); ?>
                                    </h5>
                                    <span class="badge <?php echo $task['status'] === 'completed' ? 'bg-success' : 'bg-warning'; ?>">
                                        <?php echo $task['status'] === 'completed' ? 'Selesai' : 'Pending'; ?>
                                    </span>
                                </div>
                                
                                <p class="card-text text-muted small">
                                    <?php echo htmlspecialchars(substr($task['description'], 0, 100)) . (strlen($task['description']) > 100 ? '...' : ''); ?>
                                </p>
                                
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        Jatuh Tempo: 
                                        <span class="<?php echo isPastDue($task['due_date']) && $task['status'] !== 'completed' ? 'text-danger fw-bold' : ''; ?>">
                                            <?php echo formatDate($task['due_date']); ?>
                                        </span>
                                    </small>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="edit_task.php?id=<?php echo $task['id']; ?>" 
                                       class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form action="../api/task_process.php" method="POST" class="flex-fill">
                                        <input type="hidden" name="action" value="toggle_status">
                                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                            <i class="fas fa-check"></i> 
                                            <?php echo $task['status'] === 'completed' ? 'Batal' : 'Selesai'; ?>
                                        </button>
                                    </form>
                                    
                                    <a href="delete_task.php?id=<?php echo $task['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../assets/js/script.js"></script>
</body>
</html>