
-- MySQL Dump 
-- Database: your_database_name
-- Date: 2024-10-02

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    email_verified_at DATETIME,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create tshirts table
CREATE TABLE tshirts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    color VARCHAR(255) NOT NULL,
    size VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create carts table
CREATE TABLE carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create cart_items table
CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    tshirt_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (tshirt_id) REFERENCES tshirts(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample Data Insert Commands

-- Insert users
INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES
('Admin User', 'admin@example.com', 'hashed_password_here', 'admin', NOW(), NOW()),
('John Doe', 'john@example.com', 'hashed_password_here', 'customer', NOW(), NOW());

-- Insert tshirts
INSERT INTO tshirts (name, color, size, price, stock, created_at, updated_at) VALUES
('Classic Tee', 'Red', 'M', 19.99, 100, NOW(), NOW()),
('Graphic Tee', 'Black', 'L', 24.99, 50, NOW(), NOW());

-- Insert carts
INSERT INTO carts (user_id, created_at, updated_at) VALUES
(1, NOW(), NOW()), -- Cart for Admin User
(2, NOW(), NOW()); -- Cart for John Doe

-- Insert cart_items
INSERT INTO cart_items (cart_id, tshirt_id, quantity, created_at, updated_at) VALUES
(1, 1, 2, NOW(), NOW()), -- 2 Classic Tee for Admin User
(2, 2, 1, NOW(), NOW()); -- 1 Graphic Tee for John Doe
