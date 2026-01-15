-- Membuat database
CREATE DATABASE IF NOT EXISTS todolist_db;
USE todolist_db;

-- Tabel untuk menyimpan data pengguna
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel untuk menyimpan data tugas
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

-- Index untuk optimasi query
CREATE INDEX idx_user_id ON tasks(user_id);
CREATE INDEX idx_status ON tasks(status);
CREATE INDEX idx_due_date ON tasks(due_date);

-- Insert data dummy untuk testing (opsional)
-- Password: Demo123! (sudah di-hash)
INSERT INTO users (name, email, password) VALUES 
('Demo User', 'demo@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert tugas dummy untuk user demo
INSERT INTO tasks (user_id, title, description, due_date, status) VALUES
(1, 'Belajar PHP Native', 'Mempelajari dasar-dasar PHP untuk project back-end', '2025-01-15', 'pending'),
(1, 'Desain Database', 'Membuat skema database untuk aplikasi todo list', '2025-01-10', 'completed'),
(1, 'Implementasi CRUD', 'Mengimplementasikan operasi Create, Read, Update, Delete', '2025-01-20', 'pending');