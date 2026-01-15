<?php
/**
 * File untuk fungsi-fungsi autentikasi
 * Menangani registrasi, login, dan validasi user
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';

/**
 * Fungsi untuk registrasi user baru
 * @param string $name Nama user
 * @param string $email Email user
 * @param string $password Password user
 * @return array Array dengan status dan message
 */
function registerUser($name, $email, $password) {
    global $conn;
    
    // Validasi input
    if (empty($name) || empty($email) || empty($password)) {
        return ['success' => false, 'message' => 'Semua field harus diisi!'];
    }
    
    // Validasi email
    if (!isValidEmail($email)) {
        return ['success' => false, 'message' => 'Format email tidak valid!'];
    }
    
    // Validasi password
    if (!isValidPassword($password)) {
        return ['success' => false, 'message' => 'Password minimal 6 karakter!'];
    }
    
    // Cek apakah email sudah terdaftar
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $stmt->close();
        return ['success' => false, 'message' => 'Email sudah terdaftar!'];
    }
    $stmt->close();
    
    // Hash password
    $hashed_password = hashPassword($password);
    
    // Insert user baru ke database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);
    
    if ($stmt->execute()) {
        $stmt->close();
        return ['success' => true, 'message' => 'Registrasi berhasil! Silakan login.'];
    } else {
        $stmt->close();
        return ['success' => false, 'message' => 'Registrasi gagal! Silakan coba lagi.'];
    }
}

/**
 * Fungsi untuk login user
 * @param string $email Email user
 * @param string $password Password user
 * @return array Array dengan status, message, dan data user
 */
function loginUser($email, $password) {
    global $conn;
    
    // Validasi input
    if (empty($email) || empty($password)) {
        return ['success' => false, 'message' => 'Email dan password harus diisi!'];
    }
    
    // Cari user berdasarkan email
    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $stmt->close();
        return ['success' => false, 'message' => 'Email atau password salah!'];
    }
    
    $user = $result->fetch_assoc();
    $stmt->close();
    
    // Verifikasi password
    if (!verifyPassword($password, $user['password'])) {
        return ['success' => false, 'message' => 'Email atau password salah!'];
    }
    
    // Login berhasil
    return [
        'success' => true,
        'message' => 'Login berhasil!',
        'user' => [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ]
    ];
}

/**
 * Fungsi untuk mengambil data user berdasarkan ID
 * @param int $user_id ID user
 * @return array|null Data user atau null jika tidak ditemukan
 */
function getUserById($user_id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT id, name, email, created_at FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
    
    $stmt->close();
    return null;
}

/**
 * Fungsi untuk update profil user
 * @param int $user_id ID user
 * @param string $name Nama baru
 * @param string $email Email baru
 * @return array Array dengan status dan message
 */
function updateUserProfile($user_id, $name, $email) {
    global $conn;
    
    // Validasi input
    if (empty($name) || empty($email)) {
        return ['success' => false, 'message' => 'Nama dan email harus diisi!'];
    }
    
    // Validasi email
    if (!isValidEmail($email)) {
        return ['success' => false, 'message' => 'Format email tidak valid!'];
    }
    
    // Cek apakah email sudah digunakan user lain
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $stmt->close();
        return ['success' => false, 'message' => 'Email sudah digunakan user lain!'];
    }
    $stmt->close();
    
    // Update data user
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $user_id);
    
    if ($stmt->execute()) {
        $stmt->close();
        return ['success' => true, 'message' => 'Profil berhasil diupdate!'];
    } else {
        $stmt->close();
        return ['success' => false, 'message' => 'Update profil gagal!'];
    }
}
?>