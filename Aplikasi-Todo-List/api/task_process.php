<?php
/**
 * File untuk memproses operasi CRUD pada tasks
 * Menangani add, edit, delete, dan toggle status
 */

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

// Pastikan user sudah login
requireLogin();

// Cek apakah request method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../pages/dashboard.php', 'Method not allowed!', 'error');
}

// Ambil action
$action = $_POST['action'] ?? '';
$user_id = $_SESSION['user_id'];

/**
 * Tambah Task Baru
 */
if ($action === 'add') {
    // Ambil dan sanitasi input
    $title = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $due_date = $_POST['due_date'] ?? '';
    
    // Validasi input
    if (empty($title) || empty($due_date)) {
        redirect('../pages/add_task.php', 'Judul dan tanggal jatuh tempo harus diisi!', 'error');
    }
    
    // Validasi tanggal
    if (strtotime($due_date) < strtotime(date('Y-m-d'))) {
        redirect('../pages/add_task.php', 'Tanggal jatuh tempo tidak boleh di masa lalu!', 'warning');
    }
    
    // Insert ke database
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isss", $user_id, $title, $description, $due_date);
    
    if ($stmt->execute()) {
        $stmt->close();
        redirect('../pages/dashboard.php', 'Tugas berhasil ditambahkan!', 'success');
    } else {
        $stmt->close();
        redirect('../pages/add_task.php', 'Gagal menambahkan tugas!', 'error');
    }
}

/**
 * Edit Task
 */
elseif ($action === 'edit') {
    // Ambil dan sanitasi input
    $task_id = $_POST['task_id'] ?? 0;
    $title = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $due_date = $_POST['due_date'] ?? '';
    $status = $_POST['status'] ?? 'pending';
    
    // Validasi input
    if (empty($title) || empty($due_date)) {
        redirect('../pages/edit_task.php?id=' . $task_id, 'Judul dan tanggal jatuh tempo harus diisi!', 'error');
    }
    
    // Validasi status
    if (!in_array($status, ['pending', 'completed'])) {
        $status = 'pending';
    }
    
    // Update ke database
    $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, due_date = ?, status = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssssii", $title, $description, $due_date, $status, $task_id, $user_id);
    
    if ($stmt->execute()) {
        $stmt->close();
        redirect('../pages/dashboard.php', 'Tugas berhasil diupdate!', 'success');
    } else {
        $stmt->close();
        redirect('../pages/edit_task.php?id=' . $task_id, 'Gagal mengupdate tugas!', 'error');
    }
}

/**
 * Toggle Status Task
 */
elseif ($action === 'toggle_status') {
    $task_id = $_POST['task_id'] ?? 0;
    
    // Ambil status saat ini
    $stmt = $conn->prepare("SELECT status FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $stmt->close();
        redirect('../pages/dashboard.php', 'Tugas tidak ditemukan!', 'error');
    }
    
    $task = $result->fetch_assoc();
    $stmt->close();
    
    // Toggle status
    $new_status = $task['status'] === 'pending' ? 'completed' : 'pending';
    
    // Update status
    $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sii", $new_status, $task_id, $user_id);
    
    if ($stmt->execute()) {
        $stmt->close();
        $message = $new_status === 'completed' ? 'Tugas ditandai selesai!' : 'Tugas dikembalikan ke pending!';
        redirect('../pages/dashboard.php', $message, 'success');
    } else {
        $stmt->close();
        redirect('../pages/dashboard.php', 'Gagal mengubah status tugas!', 'error');
    }
}

/**
 * Delete Task
 */
elseif ($action === 'delete') {
    $task_id = $_POST['task_id'] ?? 0;
    
    // Delete dari database
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    
    if ($stmt->execute()) {
        $stmt->close();
        redirect('../pages/dashboard.php', 'Tugas berhasil dihapus!', 'success');
    } else {
        $stmt->close();
        redirect('../pages/dashboard.php', 'Gagal menghapus tugas!', 'error');
    }
}

/**
 * Action tidak dikenali
 */
else {
    redirect('../pages/dashboard.php', 'Action tidak valid!', 'error');
}
?>