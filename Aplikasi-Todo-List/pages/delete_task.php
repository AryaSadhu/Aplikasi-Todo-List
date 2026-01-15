<?php
/**
 * File untuk menghapus task
 * Menggunakan GET method dengan konfirmasi JavaScript dari dashboard
 */

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

// Pastikan user sudah login
requireLogin();

// Ambil ID task dari URL
$task_id = $_GET['id'] ?? 0;
$user_id = $_SESSION['user_id'];

// Validasi task milik user
$stmt = $conn->prepare("SELECT id FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    redirect('dashboard.php', 'Tugas tidak ditemukan!', 'error');
}
$stmt->close();

// Delete task
$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $user_id);

if ($stmt->execute()) {
    $stmt->close();
    redirect('dashboard.php', 'Tugas berhasil dihapus!', 'success');
} else {
    $stmt->close();
    redirect('dashboard.php', 'Gagal menghapus tugas!', 'error');
}
?>