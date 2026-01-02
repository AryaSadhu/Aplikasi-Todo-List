<?php
/**
 * File konfigurasi koneksi database
 * Menggunakan MySQLi untuk koneksi ke database
 */

// Konfigurasi database
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "todolist_db";

// Membuat koneksi ke database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Set charset ke utf8mb4 untuk mendukung emoji dan karakter khusus
$conn->set_charset("utf8mb4");

/**
 * Fungsi untuk menutup koneksi database
 */
function closeConnection() {
    global $conn;
    if ($conn) {
        $conn->close();
    }
}
?>