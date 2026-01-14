-- Student Management System Database Schema
-- CSC 337 - Web Programming Languages - Assignment 4

-- Users table for authentication
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Students table for CRUD operations
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other') DEFAULT 'Male',
    address TEXT,
    department VARCHAR(100),
    semester INT,
    cgpa DECIMAL(3,2),
    enrollment_date DATE,
    status ENUM('Active', 'Inactive', 'Graduated') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, email, full_name) VALUES
('admin', '$2y$10$KDAdpeeKDtGVGzz63HHMvOsz64TNJLyttEYsepD3arBHReTwGqxua', 'admin@studentms.com', 'System Administrator');

-- Insert sample students
INSERT INTO students (student_id, first_name, last_name, email, phone, date_of_birth, gender, address, department, semester, cgpa, enrollment_date, status) VALUES
('STD001', 'Ahmad', 'Hassan', 'ahmad.hassan@university.edu', '+92-300-1234567', '2002-05-15', 'Male', '123 Main Street, Lahore', 'Computer Science', 6, 3.45, '2021-09-01', 'Active'),
('STD002', 'Fatima', 'Khan', 'fatima.khan@university.edu', '+92-301-2345678', '2003-03-22', 'Female', '456 Park Avenue, Karachi', 'Software Engineering', 4, 3.78, '2022-09-01', 'Active'),
('STD003', 'Ali', 'Ahmed', 'ali.ahmed@university.edu', '+92-302-3456789', '2001-11-10', 'Male', '789 Garden Road, Islamabad', 'Information Technology', 8, 3.21, '2020-09-01', 'Active'),
('STD004', 'Ayesha', 'Malik', 'ayesha.malik@university.edu', '+92-303-4567890', '2002-07-18', 'Female', '321 University Town, Lahore', 'Computer Science', 5, 3.92, '2022-01-15', 'Active'),
('STD005', 'Usman', 'Sheikh', 'usman.sheikh@university.edu', '+92-304-5678901', '2000-12-05', 'Male', '654 Model Town, Faisalabad', 'Software Engineering', 8, 3.56, '2020-09-01', 'Graduated');

-- Create indexes for better performance
CREATE INDEX idx_student_id ON students(student_id);
CREATE INDEX idx_department ON students(department);
CREATE INDEX idx_status ON students(status);
CREATE INDEX idx_username ON users(username);
