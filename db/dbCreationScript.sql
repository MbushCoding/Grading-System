CREATE TABLE student(
    id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    class VARCHAR(10) NOT NULL
); CREATE TABLE teacher(
    id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL
); CREATE TABLE course(
    id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT(4) UNSIGNED,
    course_name VARCHAR(30) NOT NULL,
    FOREIGN KEY(teacher_id) REFERENCES teacher(id)
); CREATE TABLE student2course(
    student_id INT(4) UNSIGNED,
    course_id INT(4) UNSIGNED,
    PRIMARY KEY(student_id, course_id),
    FOREIGN KEY(student_id) REFERENCES student(id),
    FOREIGN KEY(course_id) REFERENCES course(id)
); CREATE TABLE grade_book(
    academic_year VARCHAR(9) PRIMARY KEY,
    student_id INT(4) UNSIGNED,
    grade DOUBLE(4, 3),
    FOREIGN KEY(student_id) REFERENCES student(id)
);

ALTER TABLE teacher
ADD password VARCHAR(30) NOT NULL;

ALTER TABLE teacher
ADD email VARCHAR(30) NOT NULL;

