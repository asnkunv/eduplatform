CREATE DATABASE IF NOT EXISTS eduplatform;
USE eduplatform;

CREATE TABLE IF NOT EXISTS users (
    userid INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255),
    type ENUM('student', 'teacher', 'admin')
);

CREATE TABLE courses (
    courseid INT AUTO_INCREMENT PRIMARY KEY,
    coursename VARCHAR(100) NOT NULL
);

CREATE TABLE enrollments (
    enrollid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT,
    courseid INT,
    background TEXT,
    duration INT,
    FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE,
    FOREIGN KEY (courseid) REFERENCES courses(courseid) ON DELETE CASCADE
);

CREATE TABLE pricing (
    priceid INT AUTO_INCREMENT PRIMARY KEY,
    enrollid INT,
    teacherid INT,
    suggestedprice DOUBLE,
    FOREIGN KEY (enrollid) REFERENCES enrollments(enrollid) ON DELETE CASCADE,
    FOREIGN KEY (teacherid) REFERENCES users(userid) ON DELETE CASCADE
);

INSERT INTO users (firstname, lastname, email, phone, password, type) 
VALUES ('Admin', 'User', 'admin@gmail.com', '1111111', 'admin', 'admin');

INSERT INTO users (firstname, lastname, email, phone, password, type) 
VALUES ('Teacher', 'One', 'teacher@gmail.com', '2222', 'teacher', 'teacher');

INSERT INTO users (firstname, lastname, email, phone, password, type) 
VALUES ('Student', 'One', 'student@gmail.com', '333333', 'student', 'student');

INSERT INTO courses (coursename) VALUES 
('Math'),
('English'),
('Coding'),
('German'),
('Karate');


ALTER TABLE courses ADD description TEXT;
ALTER TABLE pricing ADD status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending';


UPDATE courses SET description = 'Basic arithmetic and problem solving' WHERE coursename = 'Math';
UPDATE courses SET description = 'Grammar, vocabulary, and writing practice' WHERE coursename = 'English';
UPDATE courses SET description = 'Learn programming fundamentals' WHERE coursename = 'Coding';
UPDATE courses SET description = 'Introductory German language skills' WHERE coursename = 'German';
UPDATE courses SET description = 'Martial arts training for all levels' WHERE coursename = 'Karate';
