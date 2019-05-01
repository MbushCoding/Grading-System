<?php
require_once 'Student.php';

class Course
{
    private $id;
    private $teacherId;
    private $courseName;

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

    /**
     * @return mixed
     */
    public function getTeacherId()
    {
        return $this->teacherId;
    }

    /**
     * @param mixed $teacherId
     */
    public function setTeacherId($teacherId)
    {
        $this->teacherId = $teacherId;
    }

    /**
     * @return mixed
     */
    public function getCourseName()
    {
        return $this->courseName;
    }

    /**
     * @param mixed $courseName
     */
    public function setCourseName($courseName)
    {
        $this->courseName = $courseName;
    }

    public function getEnrolledStudents()
    {
        require_once('db/DBConnection.php');
        $this->getIDForCourseName();
        $sql = "SELECT s.id, s.first_name, s.last_name, s.email, s.class FROM student s, student2course"
            . " WHERE course_id=$this->id AND student_id=s.id";
        $conn = connectToDB();
        $students[0]= 0;
        $iterator = 0;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $student=new Student();
                $student->setId($row['id']);
                $student->setFirstName($row['first_name']);
                $student->setLastName($row['last_name']);
                $student->setEmail($row['email']);
                $student->setClass($row['class']);
                $students[$iterator]=serialize($student);
                $iterator++;
            }
            return serialize($students);
        }
    }

    private function getIDForCourseName()
    {
        require_once('db/DBConnection.php');
        $sql = "SELECT DISTINCT id FROM course WHERE course_name = \"" . $this->courseName . "\"";
        $conn = connectToDB();
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            $conn->close();
            return;
        }
        $conn->close();
        $this->id = -1;
    }
}