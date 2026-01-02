<?php
/**
 * File untuk proses logout
 * Menghapus session dan redirect ke login
 */

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';

// Hapus session
destroySession();

// Redirect ke login
redirect('login.php', 'Anda telah berhasil logout!', 'success');
?>