<?php
/**
 * File untuk fungsi-fungsi helper umum
 * Berisi fungsi sanitasi, validasi, dan helper lainnya
 */

/**
 * Fungsi untuk sanitasi input string
 * @param string $data Input yang akan di-sanitasi
 * @return string
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Fungsi untuk validasi email
 * @param string $email Email yang akan divalidasi
 * @return bool
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Fungsi untuk validasi password (minimal 6 karakter)
 * @param string $password Password yang akan divalidasi
 * @return bool
 */
function isValidPassword($password) {
    return strlen($password) >= 6;
}

/**
 * Fungsi untuk hash password dengan bcrypt
 * @param string $password Password yang akan di-hash
 * @return string
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Fungsi untuk verifikasi password
 * @param string $password Password input
 * @param string $hash Hash password dari database
 * @return bool
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Fungsi untuk redirect dengan pesan
 * @param string $url URL tujuan redirect
 * @param string $message Pesan yang akan ditampilkan
 * @param string $type Tipe pesan (success, error, warning, info)
 */
function redirect($url, $message = '', $type = 'info') {
    if (!empty($message)) {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }
    header("Location: $url");
    exit();
}

/**
 * Fungsi untuk menampilkan flash message
 * @return string HTML flash message
 */
function displayFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'info';
        
        // Mapping type ke Bootstrap alert class
        $alert_class = [
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info'
        ];
        
        $class = $alert_class[$type] ?? 'alert-info';
        
        $html = "<div class='alert {$class} alert-dismissible fade show' role='alert'>";
        $html .= htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
        $html .= "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
        $html .= "</div>";
        
        // Hapus flash message setelah ditampilkan
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        
        return $html;
    }
    return '';
}

/**
 * Fungsi untuk format tanggal Indonesia
 * @param string $date Tanggal dalam format Y-m-d
 * @return string
 */
function formatDate($date) {
    if (empty($date)) return '-';
    
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $timestamp = strtotime($date);
    $day = date('d', $timestamp);
    $month = $bulan[date('n', $timestamp)];
    $year = date('Y', $timestamp);
    
    return $day . ' ' . $month . ' ' . $year;
}

/**
 * Fungsi untuk mengecek apakah tanggal sudah lewat
 * @param string $date Tanggal dalam format Y-m-d
 * @return bool
 */
function isPastDue($date) {
    if (empty($date)) return false;
    return strtotime($date) < strtotime(date('Y-m-d'));
}

/**
 * Fungsi untuk escape output SQL (prepared statement helper)
 * @param mysqli $conn Koneksi database
 * @param string $value Value yang akan di-escape
 * @return string
 */
function escape($conn, $value) {
    return $conn->real_escape_string($value);
}

/**
 * Fungsi untuk generate CSRF token
 * @return string
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Fungsi untuk validasi CSRF token
 * @param string $token Token yang akan divalidasi
 * @return bool
 */
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>