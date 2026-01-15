<?php
/**
 * File untuk memproses login user
 * Memvalidasi kredensial dan membuat session
 */

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

// Cek apakah request method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../pages/login.php', 'Method not allowed!', 'error');
}

// Ambil dan sanitasi input
$email = sanitize($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Proses login
$result = loginUser($email, $password);

if ($result['success']) {
    // Set user session
    setUserSession($result['user']);
    
    // Redirect ke dashboard
    redirect('../pages/dashboard.php', 'Selamat datang, ' . $result['user']['name'] . '!', 'success');
} else {
    // Redirect kembali ke login dengan error message
    redirect('../pages/login.php', $result['message'], 'error');
}
?>