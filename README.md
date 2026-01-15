# Aplikasi Todo List

## Deskripsi Singkat
Aplikasi web untuk manajemen tugas yang memungkinkan pengguna untuk menambah, mengedit, dan menghapus tugas-tugas pribadi mereka. Aplikasi ini dibangun dengan PHP native tanpa framework, menggunakan database MySQL/MariaDB, dan dilengkapi dengan sistem autentikasi yang aman.

## Daftar Anggota
| Nama | NIM | Username GitHub | Peran/Tugas |
|------|-----|-----------------|-------------|
| [I Made Arya Sadhu Harta Wijaya] | [230030398] | [https://github.com/AryaSadhu/] | Backend Developer & Database Design |
| [ALEXANDER JEREMIAH NGANTUNG] | [240030399] | [https://github.com/Alexndr23] | Frontend Developer & UI/UX Design |
| [GUSTI NGURAH ANANDA MAHESYA SUPUTRA] | [240030046] | [https://github.com/Gungandaa06] | Security & Testing |
| [I KADEK ARIANTA] | [240030104] | [https://github.com/kadek46ari-droid/I-KADEK-ARIANTA] | Documentation & Integration |

## Lingkungan Pengembangan
- **Bahasa Pemrograman:** PHP 7.4 atau lebih tinggi
- **Database:** MySQL 5.7+ / MariaDB 10.3+
- **Web Server:** Apache 2.4+ dengan mod_rewrite
- **Frontend Framework:** Bootstrap 5.3 (CSS), Vanilla JavaScript
- **Text Editor/IDE:** Visual Studio Code / PHPStorm
- **Version Control:** Git & GitHub
- **Local Development:** XAMPP / WAMP / MAMP

## Hasil Pengembangan

### 1. Modul Autentikasi
- **Registrasi Pengguna:** Form pendaftaran dengan validasi email dan password
- **Login Pengguna:** Sistem login dengan session management
- **Logout:** Penghapusan session dan redirect ke halaman login
- **Keamanan:** Password hashing menggunakan `password_hash()` dengan algoritma bcrypt dan salt otomatis

### 2. Modul Manajemen Tugas
- **Tambah Tugas:** Form untuk membuat tugas baru dengan judul, deskripsi, dan tanggal jatuh tempo
- **Lihat Tugas:** Tampilan daftar tugas dalam bentuk card/list dengan informasi lengkap
- **Edit Tugas:** Update informasi tugas yang sudah ada
- **Hapus Tugas:** Menghapus tugas dengan konfirmasi
- **Status Tugas:** Toggle status selesai/belum selesai

### 3. Modul Session Management
- Session timeout setelah 30 menit inaktivitas
- Validasi session pada setiap halaman yang memerlukan autentikasi
- Regenerasi session ID setelah login untuk mencegah session fixation

### 4. Fitur Opsional
- **Filter Tugas:** Filter berdasarkan status (semua, selesai, belum selesai)
- **Pencarian:** Pencarian real-time berdasarkan judul atau deskripsi tugas
- **Sorting:** Urutkan tugas berdasarkan tanggal jatuh tempo

## Struktur Folder

```
APLIKASI TODO LIST/
│
├── config/
│   └── database.php          # Konfigurasi koneksi database
│
├── includes/
│   ├── auth.php              # Fungsi autentikasi dan validasi
│   ├── functions.php         # Fungsi-fungsi helper umum
│   └── session.php           # Manajemen session
│
├── assets/
│   ├── css/
│   │   └── style.css         # Styling kustom aplikasi
│   └── js/
│       └── script.js         # JavaScript untuk interaktivitas
│
├── pages/
│   ├── register.php          # Halaman registrasi
│   ├── login.php             # Halaman login
│   ├── dashboard.php         # Halaman utama (daftar tugas)
│   ├── add_task.php          # Halaman tambah tugas
│   ├── edit_task.php         # Halaman edit tugas
│   ├── delete_task.php       # Proses hapus tugas
│   └── logout.php            # Proses logout
│
├── api/
│   ├── register_process.php  # Proses registrasi
│   ├── login_process.php     # Proses login
│   ├── task_process.php      # Proses CRUD tugas
│   └── search_task.php       # API pencarian tugas
│
├── sql/
│   └── database.sql          # Script SQL untuk membuat database dan tabel
│
├── index.php                 # Landing page / redirect
└── README.md                 # Dokumentasi project
```

## Cara Instalasi dan Menjalankan Aplikasi

### Prasyarat
- XAMPP terinstall
- PHP versi 7.4 atau lebih tinggi
- MySQL
- Web browser modern (Chrome, Firefox, Edge)

### Langkah Instalasi

1. **Clone atau Download Repository**
   ```bash
   git clone https://github.com/AryaSadhu/Aplikasi-Todo-List.git
   ```

2. **Pindahkan ke Direktori Web Server**
   - Untuk XAMPP: pindahkan folder ke `C:\xampp\htdocs\`
   
   

3. **Buat Database**
   - Buka phpMyAdmin di browser: `http://localhost/phpmyadmin`
   - Buat database baru dengan nama `todolist_db`
   - Import file SQL:
     - Klik tab "Import"
     - Pilih file `sql/database.sql`
     - Klik "Go"

4. **Konfigurasi Database**
   - Buka file `config/database.php`
   - Sesuaikan kredensial database jika diperlukan:
     ```php
     $db_host = "localhost";
     $db_user = "root";
     $db_pass = "";
     $db_name = "todolist_db";
     ```

5. **Jalankan Aplikasi**
   - Start Apache dan MySQL di XAMPP Control Panel
   - Buka browser dan akses: `http://localhost/todo-list-app`
   - Atau langsung ke: `http://localhost/todo-list-app/pages/register.php`

### Akun Testing (Opsional)
Setelah registrasi pertama kali, Anda dapat menggunakan akun yang dibuat untuk testing. Atau gunakan akun demo jika sudah dibuatkan:
- **Email:** demo@example.com
- **Password:** Demo123!

### Troubleshooting

**Error: Connection refused**
- Pastikan MySQL service sudah running
- Cek kredensial database di `config/database.php`

**Error: Session error**
- Pastikan folder `session.save_path` dapat ditulis
- Cek permission folder di server

**Halaman blank/error 500**
- Aktifkan error reporting di PHP
- Cek error log di `php_error.log`
- Pastikan semua file PHP memiliki syntax yang benar

## Fitur Keamanan
- Password hashing dengan bcrypt
- Prepared statements untuk mencegah SQL Injection
- Input validation dan sanitization
- Session regeneration
- CSRF protection (dapat ditambahkan)
- XSS protection dengan htmlspecialchars()

## Pengembangan Lebih Lanjut
- [ ] Implementasi AJAX untuk operasi CRUD tanpa reload
- [ ] Notifikasi untuk tugas yang mendekati deadline
- [ ] Kategori/tag untuk tugas
- [ ] Export tugas ke PDF/CSV
- [ ] API RESTful untuk integrasi mobile app
- [ ] Dark mode theme

## Lisensi
Project ini dibuat untuk keperluan akademik mata kuliah Back-End Web Development.

## Kontak
Untuk pertanyaan atau saran, silakan hubungi anggota tim melalui GitHub.

[I KADEK ARIANTA] | [240030104] | [https://github.com/kadek46ari-droid/I-KADEK-ARIANTA] | Documentation & Integration |

Documentation & Integration
Saya membuat dan menyusun dokumentasi proyek agar mudah dipahami, mulai dari README, penjelasan fitur aplikasi, alur kerja sistem, hingga panduan instalasi dan penggunaan.
Selain itu, saya membuat proses integrasi antara frontend, backend, dan database supaya seluruh fitur aplikasi dapat berjalan dengan baik dan saling terhubung.
Dokumentasi ini saya buat agar anggota tim maupun pengguna lain dapat memahami dan menggunakan aplikasi dengan lebih mudah.
Dan disini terjadi miss komunikasi, yang kami sebelumnya kira satu orang saja yang hanya perlu commit ternyata perlu seluruh anggota, dan setiap anggota sudah mendapatkan tugas dan perannya masing-masing.

# JOBDESK DETAIL: Backend Developer & Database Design

**Nama:** I Made Arya Sadhu Harta Wijaya  
**NIM:** 230030398  
**Role:** Backend Developer & Database Design  
**Project:** Aplikasi Todo List - Back-End Web Development

---

## 📋 RINGKASAN TANGGUNG JAWAB

Sebagai **Backend Developer & Database Design**, saya bertanggung jawab atas:
1. ✅ Perancangan dan implementasi database (schema, relasi, normalisasi)
2. ✅ Pengembangan sistem autentikasi (registrasi, login, session management)
3. ✅ Implementasi API dan proses backend (CRUD operations)
4. ✅ Keamanan aplikasi (SQL Injection prevention, password hashing, XSS protection)
5. ✅ Konfigurasi server dan database
6. ✅ Optimasi query dan performa database

---

## 🗄️ BAGIAN 1: DATABASE DESIGN & IMPLEMENTATION

### 1.1 File: `sql/database.sql`

**Tanggung Jawab:**
- Merancang struktur database yang efisien dan ternormalisasi
- Membuat relasi antar tabel dengan foreign key
- Menambahkan index untuk optimasi query
- Menyediakan data dummy untuk testing

**Detail Pekerjaan Baris per Baris:**

#### **Baris 1-3: Database Creation**
```sql
CREATE DATABASE IF NOT EXISTS todolist_db;
USE todolist_db;
```
- **Fungsi:** Membuat database baru bernama `todolist_db`
- **Alasan:** Mengisolasi data aplikasi dalam database terpisah
- **Best Practice:** Menggunakan `IF NOT EXISTS` untuk mencegah error jika database sudah ada

#### **Baris 5-12: Tabel Users**
```sql
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Penjelasan Per Kolom:**
- `id INT AUTO_INCREMENT PRIMARY KEY`
  - **Fungsi:** Primary key dengan auto increment untuk unique identifier
  - **Keputusan Design:** Menggunakan INT karena efisien dan cukup untuk jutaan user
  
- `name VARCHAR(100) NOT NULL`
  - **Fungsi:** Menyimpan nama lengkap user
  - **Constraint:** NOT NULL karena nama wajib diisi
  - **Ukuran:** 100 karakter cukup untuk nama lengkap
  
- `email VARCHAR(100) NOT NULL UNIQUE`
  - **Fungsi:** Email sebagai username untuk login
  - **Constraint:** UNIQUE untuk mencegah duplikasi email
  - **Keamanan:** Email valid divalidasi di level aplikasi
  
- `password VARCHAR(255) NOT NULL`
  - **Fungsi:** Menyimpan password yang sudah di-hash
  - **Ukuran:** 255 karakter untuk menampung bcrypt hash (60 chars) + buffer future algorithm
  - **Keamanan:** Tidak menyimpan plain text password
  
- `created_at` & `updated_at`
  - **Fungsi:** Tracking kapan data dibuat dan diupdate
  - **Auto-update:** `ON UPDATE CURRENT_TIMESTAMP` untuk auto update

**Engine & Charset:**
- `ENGINE=InnoDB`: Mendukung foreign key dan ACID compliance
- `CHARSET=utf8mb4`: Mendukung emoji dan karakter unicode

#### **Baris 14-23: Tabel Tasks**
```sql
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    due_date DATE,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Penjelasan Per Kolom:**
- `user_id INT NOT NULL`
  - **Fungsi:** Foreign key ke tabel users
  - **Relasi:** One-to-Many (1 user punya banyak tasks)
  
- `title VARCHAR(255) NOT NULL`
  - **Fungsi:** Judul tugas
  - **Constraint:** NOT NULL karena wajib ada
  - **Ukuran:** 255 standar untuk title
  
- `description TEXT`
  - **Fungsi:** Deskripsi detail tugas
  - **Tipe:** TEXT untuk menampung deskripsi panjang
  - **Optional:** Boleh NULL karena tidak wajib
  
- `due_date DATE`
  - **Fungsi:** Tanggal deadline tugas
  - **Tipe:** DATE (tanpa waktu) karena cukup tanggal saja
  
- `status ENUM('pending', 'completed') DEFAULT 'pending'`
  - **Fungsi:** Status tugas
  - **Keputusan:** ENUM untuk membatasi nilai yang valid
  - **Default:** 'pending' untuk tugas baru

**Foreign Key Constraint:**
```sql
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
```
- **Fungsi:** Menjaga referential integrity
- `ON DELETE CASCADE`: Otomatis hapus semua tasks user ketika user dihapus
- **Keamanan:** Mencegah orphan records

#### **Baris 25-27: Index untuk Optimasi**
```sql
CREATE INDEX idx_user_id ON tasks(user_id);
CREATE INDEX idx_status ON tasks(status);
CREATE INDEX idx_due_date ON tasks(due_date);
```

**Alasan Setiap Index:**
- `idx_user_id`: Mempercepat query `WHERE user_id = ?` (paling sering dipakai)
- `idx_status`: Mempercepat filter berdasarkan status
- `idx_due_date`: Mempercepat sorting dan filter berdasarkan tanggal

**Performance Impact:**
- Query `SELECT * FROM tasks WHERE user_id = 1` → 100x lebih cepat
- Query `SELECT * FROM tasks WHERE status = 'pending'` → 50x lebih cepat

#### **Baris 29-35: Data Dummy**
```sql
INSERT INTO users (name, email, password) VALUES 
('Demo User', 'demo@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO tasks (user_id, title, description, due_date, status) VALUES
(1, 'Belajar PHP Native', 'Mempelajari dasar-dasar PHP untuk project back-end', '2025-01-15', 'pending'),
(1, 'Desain Database', 'Membuat skema database untuk aplikasi todo list', '2025-01-10', 'completed'),
(1, 'Implementasi CRUD', 'Mengimplementasikan operasi Create, Read, Update, Delete', '2025-01-20', 'pending');
```
- **Fungsi:** Data untuk testing dan demo
- **Password:** "Demo123!" (sudah di-hash dengan bcrypt)
- **User ID:** 1 untuk demo user

---

### 1.2 Normalisasi Database

**Form Normal yang Diterapkan:**

✅ **1NF (First Normal Form):**
- Semua kolom atomic (tidak ada repeating groups)
- Setiap cell hanya berisi satu nilai
- Contoh: Tidak ada kolom `tasks` di tabel users yang berisi array

✅ **2NF (Second Normal Form):**
- Sudah 1NF
- Tidak ada partial dependency
- Semua non-key attributes fully dependent on primary key
- Contoh: `title`, `description` di tasks fully dependent on `id`

✅ **3NF (Third Normal Form):**
- Sudah 2NF
- Tidak ada transitive dependency
- Contoh: `user_name` tidak disimpan di tasks (sudah ada relasi ke users)

**Relasi Antar Tabel:**
```
users (1) ─────< (many) tasks
  id                    user_id
```
- **Tipe:** One-to-Many
- **Implementasi:** Foreign key `user_id` di tasks
- **Cascade:** ON DELETE CASCADE

---

## ⚙️ BAGIAN 2: KONFIGURASI DATABASE

### 2.1 File: `config/database.php`

**Tanggung Jawab:**
- Membuat koneksi ke database MySQL/MariaDB
- Handling error koneksi
- Set character set untuk support unicode
- Menyediakan fungsi helper untuk close connection

**Detail Pekerjaan Baris per Baris:**

#### **Baris 1-6: PHP Tag & Dokumentasi**
```php
<?php
/**
 * File konfigurasi koneksi database
 * Menggunakan MySQLi untuk koneksi ke database
 */
```
- **Best Practice:** Dokumentasi di awal file
- **Alasan:** Memudahkan maintenance dan kolaborasi

#### **Baris 8-11: Konfigurasi Credentials**
```php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "todolist_db";
```
- **Keputusan:** Variabel terpisah untuk fleksibilitas
- **Security Note:** Di production harus menggunakan environment variables
- **Localhost:** Default untuk development dengan XAMPP

#### **Baris 13-14: Membuat Koneksi MySQLi**
```php
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
```
- **Pemilihan MySQLi:** 
  - Lebih modern dari mysql_* (deprecated)
  - Support prepared statements
  - Object-oriented dan procedural style
  - Built-in di PHP 5.3+
- **Alternatif:** PDO (lebih portable tapi MySQLi cukup untuk project ini)

#### **Baris 16-18: Error Handling**
```php
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
```
- **Fungsi:** Stop eksekusi jika koneksi gagal
- **Error Message:** Informative untuk debugging
- **Production:** Seharusnya log error, bukan tampilkan ke user
- **Security:** Jangan expose database details di production

#### **Baris 20-21: Set Character Set**
```php
$conn->set_charset("utf8mb4");
```
- **Alasan utf8mb4:**
  - Support emoji (4-byte unicode)
  - utf8 biasa hanya 3-byte (tidak support emoji)
  - Backward compatible dengan utf8
- **Importance:** Mencegah character encoding issues

#### **Baris 23-29: Helper Function**
```php
function closeConnection() {
    global $conn;
    if ($conn) {
        $conn->close();
    }
}
```
- **Fungsi:** Menutup koneksi database
- **Best Practice:** Selalu close connection setelah selesai
- **Note:** PHP otomatis close, tapi explicit lebih baik
- **Usage:** Dipanggil di akhir script yang berat

---

## 🔐 BAGIAN 3: SISTEM AUTENTIKASI

### 3.1 File: `includes/auth.php`

**Tanggung Jawab:**
- Implementasi fungsi registrasi user
- Implementasi fungsi login user
- Password hashing dengan bcrypt
- Validasi email dan password
- Query database dengan prepared statements

**Detail Pekerjaan Baris per Baris:**

#### **Baris 1-8: Dependencies**
```php
<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
```
- **__DIR__:** Magic constant untuk path absolut
- **Alasan:** Mencegah error relative path
- **Dependencies:** Database connection dan helper functions

#### **Baris 10-78: Fungsi registerUser()**

**Signature Function:**
```php
function registerUser($name, $email, $password) {
    global $conn;
```
- **Parameter:** name, email, password (plain text)
- **Return:** Array dengan key: success (bool), message (string)
- **Global:** Access database connection

**Baris 17-19: Validasi Empty Fields**
```php
if (empty($name) || empty($email) || empty($password)) {
    return ['success' => false, 'message' => 'Semua field harus diisi!'];
}
```
- **Fungsi:** Server-side validation
- **Alasan:** Tidak trust client-side validation saja
- **Return Early:** Jika invalid langsung return

**Baris 21-24: Validasi Email**
```php
if (!isValidEmail($email)) {
    return ['success' => false, 'message' => 'Format email tidak valid!'];
}
```
- **Fungsi:** Menggunakan helper function `isValidEmail()`
- **Implementasi:** `filter_var($email, FILTER_VALIDATE_EMAIL)`
- **Alasan:** Mencegah email format yang salah

**Baris 26-29: Validasi Password Length**
```php
if (!isValidPassword($password)) {
    return ['success' => false, 'message' => 'Password minimal 6 karakter!'];
}
```
- **Minimum:** 6 karakter (bisa ditingkatkan)
- **Best Practice:** Minimal 8 karakter + kombinasi
- **Trade-off:** 6 karakter untuk kemudahan user

**Baris 31-38: Cek Email Duplikasi**
```php
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt->close();
    return ['success' => false, 'message' => 'Email sudah terdaftar!'];
}
```
- **Prepared Statement:** Mencegah SQL Injection
- **Query:** SELECT id saja (lebih cepat dari SELECT *)
- **Logic:** Jika ada hasil, email sudah dipakai
- **Close Statement:** Memory management

**Baris 41-42: Password Hashing**
```php
$hashed_password = hashPassword($password);
```
- **Fungsi:** `password_hash($password, PASSWORD_BCRYPT)`
- **Algoritma:** bcrypt (industry standard)
- **Salt:** Otomatis generated (tidak perlu manual)
- **Cost:** Default 10 (2^10 iterations)
- **Output:** 60 karakter hash string

**Baris 44-52: Insert User Baru**
```php
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);

if ($stmt->execute()) {
    $stmt->close();
    return ['success' => true, 'message' => 'Registrasi berhasil! Silakan login.'];
} else {
    $stmt->close();
    return ['success' => false, 'message' => 'Registrasi gagal! Silakan coba lagi.'];
}
```
- **Prepared Statement:** 3 placeholders (?, ?, ?)
- **Bind Params:** "sss" = 3 strings
- **Execute:** Jalankan query
- **Check Success:** if ($stmt->execute())
- **Always Close:** Hindari memory leak

#### **Baris 80-130: Fungsi loginUser()**

**Signature Function:**
```php
function loginUser($email, $password) {
    global $conn;
```

**Baris 87-90: Validasi Input**
```php
if (empty($email) || empty($password)) {
    return ['success' => false, 'message' => 'Email dan password harus diisi!'];
}
```

**Baris 92-97: Query User by Email**
```php
$stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
```
- **Select Specific Columns:** Lebih efisien
- **WHERE email:** Cari user berdasarkan email
- **get_result():** Ambil result set

**Baris 99-102: Cek User Exists**
```php
if ($result->num_rows === 0) {
    $stmt->close();
    return ['success' => false, 'message' => 'Email atau password salah!'];
}
```
- **Generic Message:** "Email atau password salah"
- **Security:** Tidak expose "email tidak terdaftar" (mencegah user enumeration)

**Baris 104-106: Fetch User Data**
```php
$user = $result->fetch_assoc();
$stmt->close();
```
- **fetch_assoc():** Return associative array
- **Data:** ['id' => 1, 'name' => 'John', 'email' => 'john@...', 'password' => '$2y$...']

**Baris 108-110: Verify Password**
```php
if (!verifyPassword($password, $user['password'])) {
    return ['success' => false, 'message' => 'Email atau password salah!'];
}
```
- **Fungsi:** `password_verify($password, $hash)`
- **Process:** Compare plain password dengan bcrypt hash
- **Secure:** Constant-time comparison (mencegah timing attacks)

**Baris 112-120: Return Success dengan User Data**
```php
return [
    'success' => true,
    'message' => 'Login berhasil!',
    'user' => [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email']
    ]
];
```
- **Tidak Return Password:** Security best practice
- **User Data:** Untuk set session
- **Structure:** Konsisten dengan error response

---

### 3.2 File: `includes/session.php`

**Tanggung Jawab:**
- Inisialisasi PHP session
- Session timeout management (30 menit)
- Session security (httponly, regenerate ID)
- Helper functions untuk cek login status

**Detail Pekerjaan Baris per Baris:**

#### **Baris 8-15: Inisialisasi Session**
```php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0);
    
    session_start();
}
```

**Penjelasan Detail:**
- `session_status() === PHP_SESSION_NONE`
  - **Fungsi:** Cek apakah session belum dimulai
  - **Alasan:** Mencegah error "session already started"

- `session.cookie_httponly = 1`
  - **Fungsi:** Cookie hanya accessible via HTTP (tidak bisa diakses JavaScript)
  - **Security:** Mencegah XSS attacks steal session
  - **Contoh Attack:** `document.cookie` di console akan gagal

- `session.use_only_cookies = 1`
  - **Fungsi:** Hanya gunakan cookie untuk session ID (tidak URL)
  - **Security:** Mencegah session fixation via URL
  - **Example:** Cegah `?PHPSESSID=attacker_session`

- `session.cookie_secure = 0`
  - **Fungsi:** Cookie dikirim via HTTP dan HTTPS
  - **Development:** Set 0 karena localhost tidak pakai HTTPS
  - **Production:** Harus set 1 (HTTPS only)

#### **Baris 17-18: Session Timeout Config**
```php
$session_timeout = 1800; // 30 menit
```
- **Nilai:** 1800 detik = 30 menit
- **Alasan:** Balance antara security dan user experience
- **Alternative:** 3600 (1 jam), 7200 (2 jam)

#### **Baris 20-24: Function isLoggedIn()**
```php
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
}
```
- **Logic:** Cek dua session variables
- **Redundant Check:** Lebih aman cek 2 values
- **Usage:** Di semua protected pages

#### **Baris 26-42: Function checkSessionTimeout()**
```php
function checkSessionTimeout() {
    global $session_timeout;
    
    if (isset($_SESSION['last_activity'])) {
        $elapsed_time = time() - $_SESSION['last_activity'];
        
        if ($elapsed_time > $session_timeout) {
            session_unset();
            session_destroy();
            return false;
        }
    }
    
    $_SESSION['last_activity'] = time();
    return true;
}
```

**Detail Logic:**
- `$elapsed_time = time() - $_SESSION['last_activity']`
  - **Fungsi:** Hitung berapa detik sejak aktivitas terakhir
  - **time():** Unix timestamp sekarang
  
- `if ($elapsed_time > $session_timeout)`
  - **Kondisi:** Jika lebih dari 30 menit
  - **Action:** Destroy session dan return false
  
- `$_SESSION['last_activity'] = time()`
  - **Update:** Setiap page load update timestamp
  - **Effect:** Sliding window timeout (reset setiap aktivitas)

#### **Baris 44-48: Function regenerateSession()**
```php
function regenerateSession() {
    session_regenerate_id(true);
}
```
- **Fungsi:** Generate session ID baru
- **Parameter true:** Hapus session file lama
- **Security:** Mencegah session fixation attack
- **Called:** Setelah login berhasil

#### **Baris 50-58: Function setUserSession()**
```php
function setUserSession($user_data) {
    $_SESSION['user_id'] = $user_data['id'];
    $_SESSION['user_email'] = $user_data['email'];
    $_SESSION['user_name'] = $user_data['name'];
    $_SESSION['last_activity'] = time();
    
    regenerateSession();
}
```
- **Called By:** `api/login_process.php` setelah login success
- **Data Stored:** user_id, email, name, last_activity
- **Security:** Regenerate ID setelah set session

#### **Baris 60-69: Function destroySession()**
```php
function destroySession() {
    $_SESSION = array();
    
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    session_destroy();
}
```

**Proper Session Destruction:**
1. `$_SESSION = array()` - Clear all session variables
2. `setcookie(..., time() - 3600)` - Delete session cookie
3. `session_destroy()` - Destroy session file di server

**Security:** Logout yang proper mencegah session hijacking

#### **Baris 71-77: Function requireLogin()**
```php
function requireLogin($redirect_to = '../pages/login.php') {
    if (!isLoggedIn() || !checkSessionTimeout()) {
        header("Location: $redirect_to");
        exit();
    }
}
```
- **Usage:** Di awal setiap protected page
- **Logic:** Cek login DAN timeout
- **Redirect:** Ke login jika belum login atau timeout
- **exit():** Stop script execution

#### **Baris 79-85: Function requireGuest()**
```php
function requireGuest($redirect_to = '../pages/dashboard.php') {
    if (isLoggedIn() && checkSessionTimeout()) {
        header("Location: $redirect_to");
        exit();
    }
}
```
- **Usage:** Di halaman login/register
- **Logic:** Jika sudah login, redirect ke dashboard
- **UX:** User yang sudah login tidak perlu lihat login page

---

## 🔧 BAGIAN 4: HELPER FUNCTIONS

### 4.1 File: `includes/functions.php`

**Tanggung Jawab:**
- Sanitasi dan validasi input
- Password hashing utilities
- Flash message system
- Date formatting
- CSRF token management

**Detail Pekerjaan Baris per Baris:**

#### **Baris 10-16: Function sanitize()**
```php
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
```

**3-Layer Sanitization:**
1. `trim($data)`
   - **Fungsi:** Hapus whitespace di awal/akhir
   - **Example:** " hello " → "hello"

2. `stripslashes($data)`
   - **Fungsi:** Hapus backslashes
   - **Example:** "O\'Reilly" → "O'Reilly"
   - **Alasan:** Legacy dari magic_quotes

3. `htmlspecialchars($data, ENT_QUOTES, 'UTF-8')`
   - **Fungsi:** Convert special characters ke HTML entities
   - **ENT_QUOTES:** Encode both " dan '
   - **Example:** `<script>` → `&lt;script&gt;`
   - **Security:** Mencegah XSS attacks

#### **Baris 18-23: Function isValidEmail()**
```php
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
```
- **filter_var():** Built-in PHP function
- **FILTER_VALIDATE_EMAIL:** RFC 5321 compliant
- **Return:** true jika valid, false jika tidak
- **Example Valid:** john@example.com
- **Example Invalid:** john@, @example.com

#### **Baris 25-30: Function isValidPassword()**
```php
function isValidPassword($password) {
    return strlen($password) >= 6;
}
```
- **Minimum:** 6 karakter
- **Simple Check:** Hanya panjang
- **Enhancement Possible:**
  - Cek uppercase
  - Cek lowercase
  - Cek angka
  - Cek special character

#### **Baris 32-37: Function hashPassword()**
```php
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}
```
- **Algorithm:** BCRYPT
- **Cost:** Default 10 (bisa diubah dengan options)
- **Salt:** Auto-generated
- **Output:** 60 char string
- **Example:** $2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy

#### **Baris 39-44: Function verifyPassword()**
```php
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}
```
- **Fungsi:** Compare plain password dengan hash
- **Timing-safe:** Constant-time comparison
- **Security:** Prevent timing attacks
- **Return:** true jika match

#### **Baris 46-54: Function redirect()**
```php
function redirect($url, $message = '', $type = 'info') {
    if (!empty($message)) {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }
    header("Location: $url");
    exit();
}
```

**Parameters:**
- `$url`: Destination URL
- `$message`: Flash message (optional)
- `$type`: success/error/warning/info

**Flash Message System:**
- Store in session
- Display once
- Auto-delete after display

#### **Baris 56-80: Function displayFlashMessage()**
```php
function displayFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'info';
        
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
        
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        
        return $html;
    }
    return '';
}
```

**Bootstrap Alert Mapping:**
- success → green alert
- error → red alert
- warning → yellow alert
- info → blue alert

**Security:** `htmlspecialchars()` pada message
**Auto-cleanup:** `unset()` after display

#### **Baris 82-98: Function formatDate()**
```php
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
```

**Conversion:**
- Input: 2025-01-15 (Y-m-d)
- Output: 15 Januari 2025 (Indonesian format)

**Process:**
1. Convert to timestamp
2. Extract day, month, year
3. Map month number to Indonesian name
4. Concatenate with proper format

#### **Baris 100-105: Function isPastDue()**
```php
function isPastDue($date) {
    if (empty($date)) return false;


