# Student Information System (SIS)

A comprehensive Student Information System built with Laravel, implementing MVC architecture for managing student records, subjects, enrollments, and grades for a private high school.

## Project Overview

This system provides a robust platform for managing student academic information with role-based access control (RBAC) for administrators and students.

## Key Features

### Authentication & Authorization
- Secure login system for both administrators and students
- Role-based access control
  - Administrators: Full access to all modules and CRUD operations
  - Students: Limited access (Grades module only)

### Core Modules

1. **Student Management**
   - Complete CRUD functionality
   - Student profile management
   - Data validation and error handling

2. **Subject Management**
   - Course/subject creation and management
   - Curriculum planning tools
   - Validation and error handling

3. **Enrollment System**
   - Student enrollment processing
   - Class scheduling
   - Enrollment status tracking
   - Data validation and error handling

4. **Grading System**
   - Grade entry and management
   - BukSU grading system implementation
   - Grade viewing for students
   - Comprehensive error handling

## Technical Implementation

- **Framework**: Laravel
- **Architecture**: Model-View-Controller (MVC)
- **Database**: MySQL
- **Frontend**: Blade templating engine with Bootstrap

## Security Features

- Authentication middleware
- Role-based authorization
- Form validation
- Error handling
- Data sanitization

