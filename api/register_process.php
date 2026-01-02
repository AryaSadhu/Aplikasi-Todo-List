<?php
/**
 * File untuk memproses registrasi user baru
 * Menerima data dari form registrasi dan menyimpan ke database
 */

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

// Cek apakah request method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../pages/register.php', 'Method not allowed!', 'error');
}

// Ambil dan sanitasi input
$name = sanitize($_POST['name'] ?? '');
$email = sanitize($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validasi password match
if ($password !== $confirm_password) {
    redirect('../pages/register.php', 'Password tidak cocok!', 'error');
}

// Proses registrasi
$result = registerUser($name, $email, $password);

if ($result['success']) {
    redirect('../pages/login.php', $result['message'], 'success');
} else {
    redirect('../pages/register.php', $result['message'], 'error');
}
?>