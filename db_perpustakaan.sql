-- Database Mini Digital Library
CREATE DATABASE IF NOT EXISTS db_perpustakaan CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE db_perpustakaan;

DROP TABLE IF EXISTS buku;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama_lengkap VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE buku (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(150) NOT NULL,
  kategori VARCHAR(50) NOT NULL,
  penulis VARCHAR(100) NOT NULL,
  tahun_terbit YEAR NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  sampul VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Akun default: username admin | password admin123 (bcrypt)
INSERT INTO users (username, password, nama_lengkap) VALUES
('admin', '$2y$10$XB7LDf2nHZ1FJ07dNZ9wvuznjFD3k5O6qTWB/eB5hepM6tb6UKP9q', 'Administrator');

INSERT INTO buku (judul, kategori, penulis, tahun_terbit, stok) VALUES
('Pemrograman Web dengan PHP dan MySQL', 'Teknologi', 'Abdul Kadir', 2019, 3),
('Sistem Informasi Manajemen', 'Sistem Informasi', 'Jogiyanto HM', 2017, 0),
('Basis Data: Konsep dan Implementasi', 'Teknologi', 'Rosa A.S.', 2018, 5);
