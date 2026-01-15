<?php
/**
 * Landing page / Root file
 * Redirect ke dashboard jika sudah login, atau ke login jika belum
 */

require_once __DIR__ . '/includes/session.php';

// Cek apakah user sudah login
if (isLoggedIn() && checkSessionTimeout()) {
    header('Location: pages/dashboard.php');
} else {
    header('Location: pages/login.php');
}
exit();
?>