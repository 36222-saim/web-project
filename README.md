# Student Management System

A comprehensive PHP-based CRUD (Create, Read, Update, Delete) web application for managing student records, developed as part of CSC 337 Web Programming Languages Assignment 4.

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [System Requirements](#system-requirements)
- [Installation Guide](#installation-guide)
- [Database Setup](#database-setup)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [CRUD Operations](#crud-operations)
- [Screenshots](#screenshots)
- [Group Members](#group-members)
- [Contributing](#contributing)
- [License](#license)

## 🎯 Overview

The Student Management System is a full-fledged dynamic web application that allows educational institutions to efficiently manage student information. The system provides a secure, user-friendly interface for performing all essential CRUD operations on student records.

### Problem Statement

Educational institutions face challenges in managing student data efficiently. Manual record-keeping is time-consuming and error-prone. This system provides a digital solution for:
- Adding new student records quickly
- Viewing and searching student information
- Updating student details
- Removing outdated records
- Tracking student status and academic performance

### Objectives

- Develop a fully functional PHP-based web application with database integration
- Implement complete CRUD operations for student records
- Create a secure authentication system
- Design an intuitive and responsive user interface
- Demonstrate real-world web development best practices

## ✨ Features

### Core Functionality

- **Create**: Add new student records with comprehensive details
  - Personal information (name, email, phone, DOB, gender, address)
  - Academic details (student ID, department, semester, CGPA)
  - Enrollment information (enrollment date, status)

- **Read**: View and search student records
  - List all students in a tabular format
  - View detailed information for individual students
  - Search by student ID, name, or email
  - Filter by department and status

- **Update**: Edit existing student information
  - Modify any student detail
  - Real-time validation
  - Prevent duplicate student IDs and emails

- **Delete**: Remove student records
  - Confirmation prompt to prevent accidental deletion
  - Permanent removal from database

### Additional Features

- **Environment Configuration**
  - `.env` file support for easy configuration
  - Secure credential management
  - Environment-specific settings (development/production)
  - See [ENV_SETUP.md](ENV_SETUP.md) for details

- **User Authentication**
  - Secure login and registration
  - Password encryption using PHP `password_hash()`
  - Session management

- **Dashboard & Analytics**
  - Statistics on total, active, inactive, and graduated students
  - Department-wise student distribution
  - Recently added students

- **Responsive Design**
  - Mobile-friendly interface
  - Works on all screen sizes

## 🛠 Technology Stack

### Backend
- **PHP 7.4+** - Server-side scripting
- **MySQL** - Relational database management
- **MySQLi** - Database connectivity with prepared statements

### Frontend
- **HTML5** - Markup structure
- **CSS3** - Styling and responsive design
- **JavaScript** - Client-side validation

### Development Tools
- **XAMPP/WAMP/LAMP** - Local development server
- **phpMyAdmin** - Database management
- **Git/GitHub** - Version control
- **VS Code** - Code editor

## 💻 System Requirements

### Minimum Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache Web Server
- Web browser (Chrome, Firefox, Safari, Edge)

### Recommended Setup
- XAMPP 8.0+ (includes PHP, MySQL, Apache)
- 2GB RAM
- 500MB free disk space

## 📥 Installation Guide

### Step 1: Download or Clone the Repository

```bash
# Clone the repository
git clone https://github.com/36222-saim/web-project

# Or download and extract the ZIP file
```

### Step 2: Install XAMPP (if not already installed)

1. Download XAMPP from [https://www.apachefriends.org](https://www.apachefriends.org)
2. Install XAMPP to your preferred location (e.g., `C:\xampp` on Windows)
3. Start Apache and MySQL services from XAMPP Control Panel

### Step 3: Copy Project Files

1. Copy the project folder to XAMPP's `htdocs` directory
   - Windows: `C:\xampp\htdocs\student-management-system`
   - Mac/Linux: `/opt/lampp/htdocs/student-management-system`

### Step 4: Configure Environment Variables

This project uses `.env` file for configuration (best practice!):

1. A `.env` file has been created with default settings
2. Edit `.env` file to update your database credentials:

```env
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=student_management
```

**For detailed environment configuration, see [ENV_SETUP.md](ENV_SETUP.md)**

**Alternative (Old Method):** You can also edit `config/database.php` directly if needed.

## 🗄 Database Setup

### Method 1: Using phpMyAdmin (Recommended)

1. Open phpMyAdmin in your browser: `http://localhost/phpmyadmin`
2. Click on "Import" tab
3. Click "Choose File" and select `database/schema.sql` from the project
4. Click "Go" to execute the SQL script

### Method 2: Using MySQL Command Line

```bash
# Login to MySQL
mysql -u root -p

# Run the SQL script
source C:/xampp/htdocs/student-management-system/database/schema.sql
```

### Database Structure

The database contains two main tables:

**users** - Stores administrator authentication
- id (Primary Key)
- username (Unique)
- password (Hashed)
- email
- full_name
- created_at

**students** - Stores student records
- id (Primary Key)
- student_id (Unique)
- first_name, last_name
- email (Unique)
- phone, date_of_birth, gender
- address, department
- semester, cgpa
- enrollment_date, status
- created_at, updated_at

## 🚀 Usage

### Starting the Application

1. Start Apache and MySQL from XAMPP Control Panel
2. Open your web browser
3. Navigate to: `http://localhost/student-management-system`

### Default Admin Credentials

```
Username: admin
Password: admin123
```

**⚠️ Important**: Change the default password after first login for security!

### Creating a New Account

1. Click "Register" on the login page
2. Fill in the registration form
3. Login with your new credentials

### Managing Students

#### Adding a Student
1. Login to the system
2. Click "Add Student" or navigate to Dashboard → Add New Student
3. Fill in all required fields
4. Click "Add Student" button

#### Viewing Students
1. Click "Students" in the navigation or "View All Students" on dashboard
2. Use search box to find specific students
3. Use filters to sort by department or status
4. Click "View" to see detailed information

#### Updating Student Information
1. Navigate to the student list
2. Click "Edit" button for the student you want to update
3. Modify the information
4. Click "Update Student"

#### Deleting a Student
1. Navigate to the student list
2. Click "Delete" button for the student
3. Confirm the deletion

## 📁 Project Structure

```
student-management-system/
│
├── assets/
│   └── css/
│       └── style.css              # Main stylesheet
│
├── auth/
│   ├── login.php                  # Login page
│   ├── register.php               # Registration page
│   └── logout.php                 # Logout handler
│
├── config/
│   ├── database.php               # Database connection
│   └── session.php                # Session management
│
├── database/
│   └── schema.sql                 # Database structure and sample data
│
├── includes/
│   ├── header.php                 # Header navigation
│   └── footer.php                 # Footer section
│
├── students/
│   ├── create.php                 # CREATE - Add new student
│   ├── list.php                   # READ - View all students
│   ├── view.php                   # READ - View student details
│   ├── edit.php                   # UPDATE - Edit student
│   └── delete.php                 # DELETE - Remove student
│
├── index.php                      # Home page
├── dashboard.php                  # Admin dashboard
├── about.php                      # About/Contact page
└── README.md                      # This file
```

## 🔄 CRUD Operations

### Create (C)
**File**: `students/create.php`
- Form validation (client and server-side)
- Duplicate checking (student ID and email)
- Prepared statements to prevent SQL injection
- Success/error message handling

### Read (R)
**Files**: `students/list.php`, `students/view.php`
- Display all students in paginated table
- Search functionality
- Filter by department and status
- Individual student detail view

### Update (U)
**File**: `students/edit.php`
- Pre-populate form with existing data
- Validation and duplicate checking
- Update database record
- Maintain data integrity

### Delete (D)
**File**: `students/delete.php`
- Confirmation page before deletion
- Permanent removal from database
- Prevent accidental deletions

## 📸 Screenshots

### Home Page
The landing page with system overview and key features.

### Login Page
Secure authentication with username and password.

### Dashboard
Statistics and quick actions for administrators.

### Student List
View all students with search and filter options.

### Add Student Form
Comprehensive form for creating new student records.

### Edit Student
Update existing student information.

### Student Details
Detailed view of individual student information.

## 👥 Group Members

**⚠️ UPDATE THIS SECTION WITH YOUR ACTUAL GROUP MEMBER INFORMATION**

| Name | Student ID | Role | Email |
|------|-----------|------|-------|
| Student Name 1 | 20XX-CS-XXX | Team Leader & Backend Developer | student1@university.edu |
| Student Name 2 | 20XX-CS-XXX | Database Designer | student2@university.edu |
| Student Name 3 | 20XX-CS-XXX | Frontend Developer | student3@university.edu |
| Student Name 4 | 20XX-CS-XXX | UI/UX Designer | student4@university.edu |
| Student Name 5 | 20XX-CS-XXX | Testing & Documentation | student5@university.edu |

## 📚 Course Information

- **Course Code**: CSC 337
- **Course Title**: Web Programming Languages
- **Assignment**: Assignment 4 - PHP CRUD-Based Dynamic Website
- **Instructor**: [Your Instructor Name]
- **Semester**: Fall 2025 / Spring 2026
- **Submission Date**: January 15, 2026

## 🔒 Security Features

- Password hashing using `password_hash()` with bcrypt
- Prepared statements to prevent SQL injection
- Session-based authentication
- Input validation and sanitization
- XSS prevention using `htmlspecialchars()`

## 🎓 Learning Outcomes

Through this project, we learned:
- PHP backend development and server-side programming
- MySQL database design and SQL queries
- Secure authentication and session management
- CRUD operations implementation
- Responsive web design with CSS
- Version control using Git/GitHub
- Web application deployment

## 🐛 Known Issues & Future Enhancements

### Known Issues
- None at the moment

### Future Enhancements
- Add pagination for student list
- Export students to PDF/Excel
- Email notifications
- Profile picture upload
- Advanced reporting and analytics
- Multi-user roles (admin, teacher, student)
- Attendance tracking
- Grade management

## 🤝 Contributing

This is an academic project. If you're a group member:
1. Create a feature branch
2. Make your changes
3. Test thoroughly
4. Commit with clear messages
5. Push to the repository

## 📄 License

This project is developed for educational purposes as part of CSC 337 Web Programming Languages course assignment.

## 🙏 Acknowledgments

- Thanks to our instructor for guidance and support
- XAMPP for providing an easy-to-use development environment
- PHP and MySQL communities for documentation and resources

## 📞 Contact

For questions or feedback about this project:
- **GitHub Repository**: [Update with your actual repo URL]
- **Email**: team@studentms.com

---

**Note**: This is a student project developed for educational purposes. It demonstrates CRUD operations, PHP programming, and database integration as required by the CSC 337 Web Programming Languages course assignment.

## 🚀 Deployment Instructions

### For Live Hosting

1. **Choose a PHP Hosting Provider**
   - InfinityFree (Free)
   - 000webhost (Free)
   - Hostinger
   - Bluehost
   - SiteGround

2. **Upload Files**
   - Use FTP/SFTP client (FileZilla)
   - Upload all project files to `public_html` or `www` directory

3. **Create Database**
   - Access hosting cPanel
   - Create MySQL database
   - Import `database/schema.sql`

4. **Update Configuration**
   - Edit `config/database.php` with hosting database credentials

5. **Test the Website**
   - Visit your domain
   - Test all CRUD operations
   - Verify authentication

---

**Developed with ❤️ for CSC 337 Web Programming Languages**
