<?php


class Teacher
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;

    /**
     * Teacher constructor.
     * @param $id
     * @param $firstName
     * @param $lastName
     * @param $email
     */

    public function __construct($id, $firstName, $lastName, $email)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function __toString()
    {
        return $this->id . "  " . $this->firstName . "   " . $this->lastName . "   " . $this->email;
    }

    public function getCourses()
    {
        require_once('db/DBConnection.php');
        $sql = "SELECT course_name FROM course WHERE teacher_id=\"" . $this->id . "\"";
        $conn = connectToDB();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $courses[0] = 1;
            $iterator = 0;
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $courses[$iterator++] = $row['course_name'];
            }
            return $courses;
        }
        $conn->close();
        return -1;
    }

    //TODO: check if this is used somewhere
    public function getStudentThesis($studentID)
    {
        require_once('db/DBConnection.php');
        $sql = "SELECT DISTINCT thesis.student_id, thesis.title FROM thesis, student, student2course, course, teacher\n"
            . "WHERE $studentID = student.id AND $studentID = student2course.student_id"
            . " AND student2course.course_id = course.id AND course.teacher_id = \"" . $this->getId() . "\"";
        echo $sql;
        $conn = connectToDB();
        $result = $conn->query($sql);
//        $resultSet['studentID][ThesisTitle];
        if ($result->num_rows > 0) {
            $resultSet[0][0]=1;
            $iterator = 0;
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $resultSet[$iterator][0] = $row['student_id'];
                $resultSet[$iterator++][1] = $row['title'];
            }
            return $resultSet;
        }
        $conn->close();
        return -1;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    private function connect()
    {
        $this->link = new PDO($this->id, $this->firstName, $this->lastName, $this->email);
    }


    //TODO: function to enroll a student to one of my courses, for an academic year & refactor code where it needs
}