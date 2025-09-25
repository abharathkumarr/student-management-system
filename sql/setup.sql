-- Student Management System Database Setup
-- Run this script in your InfinityFree phpMyAdmin or MySQL console

-- Create students table
CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    date_of_birth DATE,
    address TEXT,
    major VARCHAR(100),
    gpa DECIMAL(3,2),
    enrollment_date DATE DEFAULT CURRENT_DATE,
    status ENUM('active', 'inactive', 'graduated') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO students (first_name, last_name, email, phone, date_of_birth, address, major, gpa) VALUES
('John', 'Doe', 'john.doe@email.com', '555-0101', '2000-01-15', '123 Main St, City, State', 'Computer Science', 3.75),
('Jane', 'Smith', 'jane.smith@email.com', '555-0102', '1999-05-20', '456 Oak Ave, City, State', 'Business Administration', 3.92),
('Mike', 'Johnson', 'mike.johnson@email.com', '555-0103', '2001-03-10', '789 Pine Rd, City, State', 'Engineering', 3.45),
('Sarah', 'Wilson', 'sarah.wilson@email.com', '555-0104', '2000-11-08', '321 Elm St, City, State', 'Psychology', 3.88),
('David', 'Brown', 'david.brown@email.com', '555-0105', '1998-07-25', '654 Maple Dr, City, State', 'Mathematics', 3.67);

-- Create courses table (optional - for future expansion)
CREATE TABLE IF NOT EXISTS courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_code VARCHAR(10) NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    credits INT NOT NULL,
    instructor VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample courses
INSERT INTO courses (course_code, course_name, credits, instructor) VALUES
('CS101', 'Introduction to Programming', 3, 'Dr. Smith'),
('CS201', 'Data Structures', 4, 'Dr. Johnson'),
('MATH101', 'College Algebra', 3, 'Dr. Wilson'),
('ENG101', 'English Composition', 3, 'Dr. Davis'),
('BUS101', 'Introduction to Business', 3, 'Dr. Miller');

-- Create enrollments table (optional - for future expansion)
CREATE TABLE IF NOT EXISTS enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    semester VARCHAR(20),
    year INT,
    grade CHAR(2),
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Show tables to verify creation
SHOW TABLES;