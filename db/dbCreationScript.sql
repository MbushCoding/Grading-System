CREATE DATABASE IF NOT EXISTS `students_grading` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `students_grading`;

CREATE TABLE IF NOT EXISTS student
(
    id         INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(30) NOT NULL,
    last_name  VARCHAR(30) NOT NULL,
    email      VARCHAR(30) NOT NULL,
    class      VARCHAR(10) NOT NULL
);

CREATE TABLE IF NOT EXISTS teacher
(
    id         INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(30) NOT NULL,
    last_name  VARCHAR(30) NOT NULL,
    password   VARCHAR(30) NOT NULL,
    email      VARCHAR(30) NOT NULL

);

CREATE TABLE IF NOT EXISTS course
(
    id          INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    teacher_id  INT(4) UNSIGNED,
    course_name VARCHAR(30) NOT NULL,
    FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS student2course
(
    student_id INT(4) UNSIGNED,
    course_id  INT(4) UNSIGNED,
    PRIMARY KEY (student_id, course_id),
    FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE
);

# TODO: need to fix '' case
CREATE TABLE IF NOT EXISTS grade_book
(
    academic_year ENUM ('2019-2020', '2018-2019', '2017-2018', '2016-2017') PRIMARY KEY,
    student_id    INT(4) UNSIGNED,
    grade         DOUBLE(4, 3),
    FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS thesis
(
    student_id INT(4) UNSIGNED PRIMARY KEY,
    title      VARCHAR(50),
    FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE
);

ALTER TABLE student
    ADD CONSTRAINT studentEmailUnique UNIQUE (email);

ALTER TABLE grade_book
    ADD CONSTRAINT gradeBookGradeValid CHECK (grade > 0 AND grade <= 10);

INSERT INTO teacher
VALUES (NULL, "John", "Smith", "123", "john.smith@mail.com");

INSERT INTO teacher
VALUES (NULL, "James", "Killian", "passworkjk", "john.killian@mit.edu");

INSERT INTO teacher
VALUES (NULL, "Ann", "Graybiel", "passworkag", "ann.graybiel@yahoo.com");

INSERT INTO teacher
VALUES (NULL, "Ron", "Rivest", "passwordrr", "ronrivest@uti.com");

INSERT INTO teacher
VALUES (NULL, "Bruno", "Rossi", "passwordbr", "bruno.rossi@ucla.com");

INSERT INTO student
VALUES (NULL, "George", "Bush", "gbush@white-house.gov", "2004A");

INSERT INTO student
VALUES (NULL, "Barack", "Obama", "bobama@democratic.gov", "2009B");

INSERT INTO student
VALUES (NULL, "Doanld", "Trump", "trump@monkey.gov", "2017A");

INSERT INTO student
VALUES (NULL, "Vladimir", "Putin", "putin@kgb.ru", "2000");

INSERT INTO student
VALUES (NULL, "Kim", "Jong-un", "kim@nuclear.army", "2012");

INSERT INTO course
VALUES (NULL, 1, "Nuclear army");

INSERT INTO course
VALUES (NULL, 1, "Make Koreea great again");

INSERT INTO course
VALUES (NULL, 2, "How to be a real russian");

INSERT INTO course
VALUES (NULL, 4, "Do nothing for the country");

INSERT INTO course
VALUES (NULL, 2, "Be a no-one like a boss");

INSERT into student2course
VALUES (4, 1);

INSERT into student2course
VALUES (5, 1);

INSERT into student2course
VALUES (2, 1);

INSERT into student2course
VALUES (1, 2);

INSERT into student2course
VALUES (4, 2);

INSERT into student2course
VALUES (1, 4);

INSERT into student2course
VALUES (1, 5);

INSERT into student2course
VALUES (4, 3);

INSERT INTO thesis
VALUES (1, "How to be a great president");

INSERT INTO thesis
VALUES (2, "How I killed Osama bin Laden");

INSERT INTO thesis
    VALUE (3, "Short introduction in oranges history");

INSERT INTO thesis
VALUES (4, "I'm the gas boss");

INSERT INTO thesis
VALUES (5, "I will smile on any situation");
-- Add some constraints
# Add some grades for the presidents