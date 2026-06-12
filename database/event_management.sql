-- Create Database
CREATE DATABASE IF NOT EXISTS event_management;
USE event_management;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    contact VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Events Table
CREATE TABLE IF NOT EXISTS events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    date DATE NOT NULL,
    venue VARCHAR(150) NOT NULL,
    description TEXT,
    organizer VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Registrations Table
CREATE TABLE IF NOT EXISTS registrations (
    reg_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE,
    UNIQUE KEY unique_registration (user_id, event_id)
);

-- Insert Admin User (password: 123456)
INSERT INTO users (name, student_id, email, contact, password, role) 
VALUES ('Admin User', 'ADMIN001', 'admin@gmail.com', '0771234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('User 1','45678','user1@gmail.com','0743467578','$2y$10$U9TL58L0xH2AKQ88R.Qc/O5ngqhkFq4zb0.nGJI8TeffFYDNcZmaa','student');

-- Insert Sample Events
INSERT INTO events (title, date, venue, description, organizer) VALUES
('UI/UX Design Workshop', '2025-12-15', 'Mini Auditorium', 'Join us for awareness session regarding recent trends in UI/UX design with industry professionals.','Information Technology field student'),
('Diwali Function', '2025-11-03', 'Canteen', 'Experience diverse cultures through music, dance, and food from different religions.','2023/2024 intake student batch'),
('Career Fair 2025', '2025-12-01', 'T.A. Gunasekara Hall', 'Meet top employers and explore career opportunities in various industries.','IT Department'),
('Sports Day', '2025-11-25', 'Mahinda Rajapaksha playground', 'Annual sports competition with various athletic events.','IDS Division');
