# Student Event Management System

A comprehensive web-based event management system designed for university students to discover, register for, and manage campus events.

## Project Overview

The Student Event Management System is a full-stack web application that allows students to browse and register for university events, while administrators can create, manage, and track event registrations. Built with modern web technologies, the system emphasizes security, usability, and responsive design.

## Features

### For Students:
- **User Registration & Authentication**: Secure account creation and login system
- **Browse Events**: View all upcoming university events with detailed information
- **Search Functionality**: Filter events by title using the search box
- **Event Registration**: Register for events with a single click
- **Registration Status**: View which events you're already registered for

### For Administrators:
- **Admin Dashboard**: Overview of system statistics and quick actions
- **Event Management**: Create, edit, and delete events
- **View Registrations**: See detailed lists of students registered for each event
- **Statistics**: Track total events, students, and registrations

## Technology Stack

- **Front-End**: HTML5, CSS3, Bootstrap 5, JavaScript
- **Back-End**: PHP (Pure PHP, no frameworks)
- **Database**: MySQL with PDO (Prepared Statements)
- **Authentication**: PHP Sessions
- **Validation**: Client-side JavaScript + Server-side PHP

## Project Structure
```
student_event_management/
│
├── index.php                 # Home page
├── login.php                 # User login
├── register.php              # User registration
├── events.php                # Event listing page
├── logout.php                # Logout handler
├── README.md                 # This file
│
├── css/
│   └── styles.css           # Custom CSS styles
│
├── js/
│   └── validate.js          # Client-side validation
│
├── php/
│   ├── db_connect.php       # Database connection (PDO)
│   ├── auth_check.php       # Session authentication
│   ├── register_user.php    # User registration handler
│   ├── login_user.php       # Login handler
│   ├── register_event.php   # Event registration handler
│   └── logout_user.php      # Logout handler
│
├── admin/
│   ├── dashboard.php        # Admin dashboard
│   ├── add_event.php        # Add new event
│   ├── edit_event.php       # Edit existing event
│   ├── delete_event.php     # Delete event
│   └── view_registrations.php  # View event registrations
│
├── images/
│   └── (placeholder images)
│
└── database/
    └── event_management.sql # Database schema and sample data
```

## Installation & Setup

### Prerequisites
- XAMPP/WAMP/LAMP (Apache, MySQL, PHP 7.4+)
- Web browser (Chrome, Firefox, Edge, etc.)
- Text editor (VS Code, Sublime Text, etc.)

### Step-by-Step Installation

1. **Install XAMPP/WAMP**
   - Download and install XAMPP from [https://www.apachefriends.org](https://www.apachefriends.org)
   - Start Apache and MySQL services

2. **Setup Project Files**
   - Copy the `student_event_management` folder to your web server directory:
     - For XAMPP: `C:/xampp/htdocs/`
     - For WAMP: `C:/wamp64/www/`

3. **Create Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Click on "New" to create a new database
   - Import the SQL file:
     - Click on "Import" tab
     - Choose file: `database/event_management.sql`
     - Click "Go" to execute

4. **Configure Database Connection**
   - Open `php/db_connect.php`
   - Update the database credentials if necessary:
```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'event_management');
     define('DB_USER', 'root');
     define('DB_PASS', '');
```

5. **Access the Application**
   - Open your web browser
   - Navigate to: `http://localhost/student_event_management/`

## Login Credentials

### Administrator Account
- **Email**: admin@gmail.com
- **Password**:password

### Sample Student Accounts
- **Email**: user1@gmail.com | **Password**: user14562

## Database Schema

### Tables

**users**
- `user_id` (INT, Primary Key, Auto Increment)
- `name` (VARCHAR 100)
- `email` (VARCHAR 100, Unique)
- `password` (VARCHAR 255, Hashed)
- `role` (ENUM: 'admin', 'student')
- `created_at` (TIMESTAMP)

**events**
- `event_id` (INT, Primary Key, Auto Increment)
- `title` (VARCHAR 150)
- `date` (DATE)
- `venue` (VARCHAR 150)
- `description` (TEXT)
- `created_at` (TIMESTAMP)

**registrations**
- `reg_id` (INT, Primary Key, Auto Increment)
- `user_id` (INT, Foreign Key → users)
- `event_id` (INT, Foreign Key → events)
- `timestamp` (TIMESTAMP)
- Unique constraint on (user_id, event_id)

## Security Features

- **Password Hashing**: Using PHP's `password_hash()` with bcrypt
- **PDO Prepared Statements**: Protection against SQL injection
- **Session Management**: Secure user authentication
- **Input Validation**: Both client-side and server-side
- **Role-Based Access Control**: Admin pages protected from unauthorized access
- **XSS Prevention**: Using `htmlspecialchars()` for output

## Key Features Implemented

### Client-Side Validation
- Real-time form validation using JavaScript
- Email format validation
- Password length validation (minimum 6 characters)
- Password confirmation matching
- Required field checking

### Admin Features
- Dashboard with statistics
- CRUD operations for events
- View registrations by event or all registrations
- Search and filter capabilities

### Student Features
- Event browsing with search
- One-click event registration
- Registration status tracking
- Responsive design for mobile devices

## Troubleshooting

**Database Connection Error**
- Verify MySQL service is running
- Check database credentials in `db_connect.php`
- Ensure database `event_management` exists

**Login Issues**
- Clear browser cookies and cache
- Verify user exists in database
- Check password hash in database

**Page Not Found (404)**
- Verify file paths are correct
- Check Apache is running
- Ensure mod_rewrite is enabled

## Browser Compatibility

- Google Chrome (Recommended)
- Mozilla Firefox
- Microsoft Edge
- Safari
- Opera

## Developer Information

**Project By**: K.M.N.I. Ranasinghe  
**Student ID**: 23IT0520  
**Course**: Web Development / Information Technology  
**Year**: 2025

## License

This project is developed for educational purposes as part of a university coursework.

