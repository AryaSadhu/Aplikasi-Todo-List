<?php
/**
 * API untuk pencarian tugas
 * Mengembalikan hasil dalam format JSON
 * Dapat digunakan untuk AJAX search
 */

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

// Pastikan user sudah login
if (!isLoggedIn() || !checkSessionTimeout()) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized'
    ]);
    exit();
}

// Set header JSON
header('Content-Type: application/json');

// Ambil parameter pencarian
$search = $_GET['q'] ?? '';
$filter = $_GET['filter'] ?? 'all';
$user_id = $_SESSION['user_id'];

// Validasi input
if (empty($search)) {
    echo json_encode([
        'success' => false,
        'message' => 'Search query is required'
    ]);
    exit();
}

// Query pencarian
$query = "SELECT id, title, description, due_date, status, created_at 
          FROM tasks 
          WHERE user_id = ? 
          AND (title LIKE ? OR description LIKE ?)";

$params = [$user_id];
$types = "i";
$search_param = "%$search%";

// Filter berdasarkan status
if ($filter === 'completed') {
    $query .= " AND status = 'completed'";
} elseif ($filter === 'pending') {
    $query .= " AND status = 'pending'";
}

$query .= " ORDER BY due_date ASC LIMIT 20";

// Execute query
$stmt = $conn->prepare($query);
$params[] = $search_param;
$params[] = $search_param;
$types .= "ss";

$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Ambil hasil
$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = [
        'id' => $row['id'],
        'title' => htmlspecialchars($row['title']),
        'description' => htmlspecialchars($row['description']),
        'due_date' => $row['due_date'],
        'due_date_formatted' => formatDate($row['due_date']),
        'status' => $row['status'],
        'is_past_due' => isPastDue($row['due_date']) && $row['status'] !== 'completed',
        'created_at' => $row['created_at']
    ];
}

$stmt->close();

// Return hasil
echo json_encode([
    'success' => true,
    'count' => count($tasks),
    'tasks' => $tasks
]);
?>