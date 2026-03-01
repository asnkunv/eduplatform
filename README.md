# EduPlatform

A web-based education platform built with PHP and MySQL where students can enroll in courses, teachers can manage their students, and admins can oversee the entire system.

## Features

- Student, Teacher, and Admin roles
- Course enrollment system
- Teacher pricing and scheduling
- Role-based dashboards

## Requirements

- XAMPP (Apache + MySQL)
- A web browser

## Setup Instructions

### 1. Clone the repository
Clone or download this repository and place the `eduplatform` folder inside your XAMPP `htdocs` directory:
```
C:/xampp/htdocs/eduplatform
```

### 2. Start XAMPP
Open the XAMPP Control Panel and start **Apache** and **MySQL**.

### 3. Set up the database
1. Go to `http://localhost/phpmyadmin` in your browser
2. Click **Import**
3. Select the `eduplatform.sql` file from the project folder
4. Click **Go**

### 4. Run the project
Open your browser and go to:
```
http://localhost/eduplatform/login.php
```

## Default Accounts

| Role    | Email               | Password |
|---------|---------------------|----------|
| Admin   | admin@gmail.com     | admin    |
| Teacher | teacher@gmail.com   | teacher  |
| Student | student@gmail.com   | student  |

## Tech Stack

- PHP
- MySQL
- HTML/CSS
