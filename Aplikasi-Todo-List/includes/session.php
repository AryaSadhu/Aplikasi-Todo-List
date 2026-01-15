<?php
/**
 * File untuk manajemen session
 * Menangani inisialisasi, validasi, dan keamanan session
 */

// Memulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    // Konfigurasi session untuk keamanan
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0); // Set ke 1 jika menggunakan HTTPS
    
    session_start();
}

// Set timeout session (30 menit = 1800 detik)
$session_timeout = 1800;

/**
 * Fungsi untuk mengecek apakah user sudah login
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
}

/**
 * Fungsi untuk validasi session timeout
 * @return bool
 */
function checkSessionTimeout() {
    global $session_timeout;
    
    if (isset($_SESSION['last_activity'])) {
        $elapsed_time = time() - $_SESSION['last_activity'];
        
        if ($elapsed_time > $session_timeout) {
            // Session timeout, hapus session
            session_unset();
            session_destroy();
            return false;
        }
    }
    
    // Update last activity time
    $_SESSION['last_activity'] = time();
    return true;
}

/**
 * Fungsi untuk regenerasi session ID (mencegah session fixation)
 */
function regenerateSession() {
    session_regenerate_id(true);
}

/**
 * Fungsi untuk set session setelah login berhasil
 * @param array $user_data Data user dari database
 */
function setUserSession($user_data) {
    $_SESSION['user_id'] = $user_data['id'];
    $_SESSION['user_email'] = $user_data['email'];
    $_SESSION['user_name'] = $user_data['name'];
    $_SESSION['last_activity'] = time();
    
    // Regenerate session ID untuk keamanan
    regenerateSession();
}

/**
 * Fungsi untuk menghapus session (logout)
 */
function destroySession() {
    $_SESSION = array();
    
    // Hapus cookie session jika ada
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    session_destroy();
}

/**
 * Fungsi untuk redirect jika belum login
 * @param string $redirect_to URL tujuan redirect
 */
function requireLogin($redirect_to = '../pages/login.php') {
    if (!isLoggedIn() || !checkSessionTimeout()) {
        header("Location: $redirect_to");
        exit();
    }
}

/**
 * Fungsi untuk redirect jika sudah login
 * @param string $redirect_to URL tujuan redirect
 */
function requireGuest($redirect_to = '../pages/dashboard.php') {
    if (isLoggedIn() && checkSessionTimeout()) {
        header("Location: $redirect_to");
        exit();
    }
}
?>