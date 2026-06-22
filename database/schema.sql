-- WPoets Full Stack Test Database Schema
-- Create database if not exists
CREATE DATABASE IF NOT EXISTS wpoets_test;
USE wpoets_test;

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_display_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Items Table
CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(500),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_display_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Data: Categories
INSERT INTO categories (name, description, display_order) VALUES
('Technology', 'Latest technology trends and innovations', 1),
('Design', 'Modern design principles and inspiration', 2),
('Business', 'Business strategies and growth tips', 3),
('Lifestyle', 'Wellness and lifestyle improvement', 4);

-- Seed Data: Items for Technology Category
INSERT INTO items (category_id, title, description, image_url, display_order) VALUES
(1, 'Web Development', 'Build modern web applications with latest frameworks and technologies', 'https://via.placeholder.com/500x500?text=Web+Development', 1),
(1, 'Artificial Intelligence', 'Explore AI and machine learning capabilities', 'https://via.placeholder.com/500x500?text=Artificial+Intelligence', 2),
(1, 'Cloud Computing', 'Scale your applications with cloud infrastructure', 'https://via.placeholder.com/500x500?text=Cloud+Computing', 3),
(1, 'Mobile Development', 'Create powerful mobile apps for iOS and Android', 'https://via.placeholder.com/500x500?text=Mobile+Development', 4);

-- Seed Data: Items for Design Category
INSERT INTO items (category_id, title, description, image_url, display_order) VALUES
(2, 'UI Design', 'Create intuitive and beautiful user interfaces', 'https://via.placeholder.com/500x500?text=UI+Design', 1),
(2, 'UX Design', 'Understand user behavior and improve experience', 'https://via.placeholder.com/500x500?text=UX+Design', 2),
(2, 'Typography', 'Master the art of choosing and using fonts', 'https://via.placeholder.com/500x500?text=Typography', 3),
(2, 'Color Theory', 'Learn how to use colors effectively in design', 'https://via.placeholder.com/500x500?text=Color+Theory', 4);

-- Seed Data: Items for Business Category
INSERT INTO items (category_id, title, description, image_url, display_order) VALUES
(3, 'Marketing Strategy', 'Develop effective marketing campaigns and strategies', 'https://via.placeholder.com/500x500?text=Marketing+Strategy', 1),
(3, 'Leadership', 'Build strong leadership skills and team management', 'https://via.placeholder.com/500x500?text=Leadership', 2),
(3, 'Finance', 'Master financial management and budgeting', 'https://via.placeholder.com/500x500?text=Finance', 3),
(3, 'Entrepreneurship', 'Start and grow your own business', 'https://via.placeholder.com/500x500?text=Entrepreneurship', 4);

-- Seed Data: Items for Lifestyle Category
INSERT INTO items (category_id, title, description, image_url, display_order) VALUES
(4, 'Fitness', 'Achieve your fitness goals with proper training', 'https://via.placeholder.com/500x500?text=Fitness', 1),
(4, 'Meditation', 'Find peace and mindfulness through meditation', 'https://via.placeholder.com/500x500?text=Meditation', 2),
(4, 'Nutrition', 'Eat healthy and balanced diet for better life', 'https://via.placeholder.com/500x500?text=Nutrition', 3),
(4, 'Travel', 'Explore the world and discover new experiences', 'https://via.placeholder.com/500x500?text=Travel', 4);
