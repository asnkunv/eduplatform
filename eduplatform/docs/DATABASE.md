# Database Schema Documentation

## Overview

The EduPlatform database consists of 4 main tables that handle user management, course catalog, student enrollments, and pricing negotiations.

## Database Name
`eduplatform`

## Tables

### 1. users

Stores information about all platform users (students, teachers, and admins).

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| userid | INT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier for each user |
| firstname | VARCHAR(50) | | User's first name |
| lastname | VARCHAR(50) | | User's last name |
| email | VARCHAR(100) | UNIQUE | User's email address (used for login) |
| phone | VARCHAR(20) | | Contact phone number |
| password | VARCHAR(255) | | User's password (currently plain text) |
| type | ENUM | 'student', 'teacher', 'admin' | User role in the system |

**Indexes:**
- PRIMARY KEY on `userid`
- UNIQUE on `email`

**Sample Data:**
- Admin: admin@gmail.com / admin
- Teacher: teacher@gmail.com / teacher
- Student: student@gmail.com / student

---

### 2. courses

Contains all available courses on the platform.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| courseid | INT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier for each course |
| coursename | VARCHAR(100) | NOT NULL | Name of the course |
| description | TEXT | | Detailed description of the course |

**Indexes:**
- PRIMARY KEY on `courseid`

**Sample Data:**
- Math - Basic arithmetic and problem solving
- English - Grammar, vocabulary, and writing practice
- Coding - Learn programming fundamentals
- German - Introductory German language skills
- Karate - Martial arts training for all levels

---

### 3. enrollments

Tracks student enrollments in courses.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| enrollid | INT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier for each enrollment |
| userid | INT | FOREIGN KEY → users(userid) | Student who enrolled |
| courseid | INT | FOREIGN KEY → courses(courseid) | Course enrolled in |
| background | TEXT | | Student's background/experience |
| duration | INT | | Desired course duration in weeks |

**Indexes:**
- PRIMARY KEY on `enrollid`
- FOREIGN KEY on `userid` → CASCADE DELETE
- FOREIGN KEY on `courseid` → CASCADE DELETE

**Business Rules:**
- One student can enroll in multiple courses
- Multiple students can enroll in the same course
- Enrollment is deleted if user or course is deleted (CASCADE)

---

### 4. pricing

Manages pricing offers from teachers to students.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| priceid | INT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier for pricing record |
| enrollid | INT | FOREIGN KEY → enrollments(enrollid) | Associated enrollment |
| teacherid | INT | FOREIGN KEY → users(userid) | Teacher offering the price |
| suggestedprice | DOUBLE | | Price suggested by teacher |
| status | ENUM | 'pending', 'accepted', 'rejected' | Current status of price offer |

**Indexes:**
- PRIMARY KEY on `priceid`
- FOREIGN KEY on `enrollid` → CASCADE DELETE
- FOREIGN KEY on `teacherid` → CASCADE DELETE

**Business Rules:**
- Default status is 'pending'
- Student can accept or reject teacher's price
- Pricing is deleted if enrollment is deleted (CASCADE)

---

## Entity Relationship Diagram

```
┌─────────────┐
│   USERS     │
├─────────────┤
│ userid (PK) │
│ firstname   │
│ lastname    │
│ email       │
│ phone       │
│ password    │
│ type        │
└─────┬───────┘
      │
      │ 1:N
      │
┌─────▼────────────┐         ┌──────────────┐
│  ENROLLMENTS     │   N:1   │   COURSES    │
├──────────────────┤─────────├──────────────┤
│ enrollid (PK)    │         │ courseid(PK) │
│ userid (FK)      │         │ coursename   │
│ courseid (FK)    │         │ description  │
│ background       │         └──────────────┘
│ duration         │
└────┬─────────────┘
     │
     │ 1:N
     │
┌────▼─────────────┐
│    PRICING       │
├──────────────────┤
│ priceid (PK)     │
│ enrollid (FK)    │
│ teacherid (FK)   │
│ suggestedprice   │
│ status           │
└──────────────────┘
```

## Relationships

1. **users → enrollments**: One user can have many enrollments (1:N)
2. **courses → enrollments**: One course can have many enrollments (1:N)
3. **enrollments → pricing**: One enrollment can have many pricing offers (1:N)
4. **users → pricing**: One teacher can make many pricing offers (1:N)

## Workflow

### Student Enrollment Flow
1. Student selects a course from `courses` table
2. Provides `background` and `duration` preferences
3. New record created in `enrollments` table
4. Teacher views enrollment and creates `pricing` record
5. Student accepts/rejects in `pricing.status`

### Admin Course Management
1. Admin adds course to `courses` table
2. Course becomes available for enrollment
3. Admin can delete course (cascades to enrollments and pricing)

### Teacher Pricing Flow
1. Teacher views `enrollments` for all students
2. Sets `suggestedprice` in `pricing` table
3. Can update price anytime while status is 'pending'
4. Student's action updates `status` field

## Security Considerations

⚠️ **Current Issues** (To Fix Before Production):
- Passwords stored in plain text (use `password_hash()`)
- No prepared statements in some queries (SQL injection risk)
- Missing input validation
- No CSRF protection

## Backup and Restore

### Backup
```bash
mysqldump -u root -p eduplatform > backup.sql
```

### Restore
```bash
mysql -u root -p eduplatform < backup.sql
```

## Future Schema Enhancements

Potential additions for v2.0:
- `course_materials` table for file uploads
- `payments` table for transaction tracking
- `reviews` table for course ratings
- `messages` table for teacher-student communication
- `categories` table for course organization
- Indexes on frequently queried foreign keys
- Full-text search on course descriptions
