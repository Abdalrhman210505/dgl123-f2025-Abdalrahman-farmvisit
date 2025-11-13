-- Farm Visit & Produce Showcase Website Database Schema
-- Milestone 2: Data Model
-- Author: Abdalrhman Awad

CREATE DATABASE IF NOT EXISTS farm_visit_showcase;
USE farm_visit_showcase;

-- =========================
-- Table: users (admin/staff)
-- =========================
CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  full_name VARCHAR(255),
  role ENUM('admin', 'staff') DEFAULT 'staff',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- Table: bookings (contact/visit requests)
-- =========================
CREATE TABLE bookings (
  booking_id INT AUTO_INCREMENT PRIMARY KEY,
  visitor_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(50),
  visit_date DATE,
  visit_time TIME,
  party_size INT DEFAULT 1,
  notes TEXT,
  status ENUM('new','confirmed','cancelled') DEFAULT 'new',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- Table: gallery_images
-- =========================
CREATE TABLE gallery_images (
  image_id INT AUTO_INCREMENT PRIMARY KEY,
  file_name VARCHAR(255) NOT NULL,
  caption VARCHAR(255),
  uploaded_by INT,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  is_public TINYINT(1) DEFAULT 1,
  FOREIGN KEY (uploaded_by) REFERENCES users(user_id) ON DELETE SET NULL
);

-- =========================
-- Table: farm_hours
-- =========================
CREATE TABLE farm_hours (
  day_of_week TINYINT PRIMARY KEY,   -- 0=Sunday .. 6=Saturday
  open_time TIME NULL,
  close_time TIME NULL,
  notes VARCHAR(255),
  is_closed TINYINT(1) DEFAULT 0
);

-- =========================
-- Table: produce
-- =========================
CREATE TABLE produce (
  produce_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(8,2),
  in_stock INT DEFAULT 0,
  image_id INT NULL,
  featured TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (image_id) REFERENCES gallery_images(image_id) ON DELETE SET NULL
);

-- =========================
-- Table: categories
-- =========================
CREATE TABLE categories (
  category_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
);

-- =========================
-- Junction Table: produce_categories (many-to-many)
-- =========================
CREATE TABLE produce_categories (
  produce_id INT NOT NULL,
  category_id INT NOT NULL,
  PRIMARY KEY (produce_id, category_id),
  FOREIGN KEY (produce_id) REFERENCES produce(produce_id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
);


-- =========================
-- Sample Data for farm_hours
-- =========================
INSERT INTO farm_hours (day_of_week, open_time, close_time, notes, is_closed)
VALUES
(0, NULL, NULL, 'Closed', 1),
(1, '09:00:00', '17:00:00', 'Open to visits', 0),
(2, '09:00:00', '17:00:00', 'Open to visits', 0),
(3, '09:00:00', '17:00:00', 'Open to visits', 0),
(4, '09:00:00', '17:00:00', 'Open to visits', 0),
(5, '09:00:00', '18:00:00', 'Farmers market on-site', 0),
(6, '10:00:00', '16:00:00', 'Weekend visits', 0);
